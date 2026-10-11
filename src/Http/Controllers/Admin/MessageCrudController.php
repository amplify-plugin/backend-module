<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\User;
use Amplify\System\Message\Exceptions\MessengerException;
use Amplify\System\Message\Facades\Messenger;
use Amplify\System\Message\Http\Requests\MessageRequest;
use Amplify\System\Message\Models\Message;
use Amplify\System\Message\Models\MessageThread;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageCrudController extends BackpackCustomCrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup()
    {
        $this->crud->setModel(MessageThread::class);
        $this->crud->setRoute(config('backpack.base.route_prefix').'/message');
        $this->crud->setEntityNameStrings('message', 'messages');
    }

    protected function setupListOperation()
    {
        $this->data['threads'] = backpack_user()->threads;
        $this->data['currentThread'] = null;
        $this->crud->setListView('backend::pages.messages.index');
    }

    public function setupShowOperation()
    {
        $this->data['currentThread'] = $this->crud->getCurrentEntry();

        $user = backpack_user();
        $user->markThreadAsRead($this->data['currentThread']->id);
        $user->unsetRelation('threads');

        $this->data['threads'] = $user->threads;

        $this->crud->setShowView('backend::pages.messages.index');
    }

    /**
     * @throws Exception
     */
    public function store(MessageRequest $request)
    {
        try {
            switch ($request->user_type) {
                case 'user':
                    $receiver = User::findOrFail($request->msg_to);
                    break;
                case 'contact':
                    $receiver = Contact::findOrFail($request->msg_to);
                    break;
            }

            $sender = ($request->boolean('as_customer')) ? customer(true) : backpack_user();

            $attachmentTitle = null;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $attachmentTitle = $file->getClientOriginalName();
            }

            $message = Messenger::from($sender)
                ->to($receiver)
                ->attachmentTitle($attachmentTitle)
                ->message($request->msg)
                ->attachment($request->file('attachment'))
                ->send();

            ($message instanceof Message)
                ? \Alert::success('Message Send Successfully')
                : \Alert::error('Something went wrong');

            $url = ($request->boolean('as_customer')) ? route('frontend.messages.show', $message->thread_id) : route('message.show', $message->thread_id);

            return ($message instanceof Message)
                ? redirect($url)
                : redirect()->back()->with('error', 'Something went wrong');
        } catch (Exception $exception) {
            \Alert::error($exception->getMessage());

            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @return RedirectResponse
     *
     * @throws MessengerException
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'msg' => 'required_without:attachment|nullable|string|min:1|max:10000',
            'attachment' => MessageRequest::attachmentRules(),
        ], [
            'attachment.mimes' => 'Attach an image, PDF, Word, Excel, PowerPoint, CSV, or text file.',
        ]);

        $thread = MessageThread::findOrFail($id);

        $from = $request->boolean('as_customer') ? customer(true) : backpack_user();

        $attachmentTitle = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentTitle = $file->getClientOriginalName();
        }
        Messenger::from($from)->to($thread)->attachmentTitle($attachmentTitle)->message($request->msg)->attachment($request->file('attachment'))->send();

        return back();
    }

    public function recipients(Request $request, string $type): JsonResponse
    {
        $term = trim(str_replace(['%', '_'], '', (string) $request->query('q', '')));
        $like = $term === '' ? null : '%'.$term.'%';

        if ($type === 'user') {
            $results = User::query()
                ->where('id', '!=', backpack_user()->id)
                ->when($like, fn ($query) => $query->where('name', 'like', $like))
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(fn (User $user) => [
                    'id' => (int) $user->id,
                    'text' => (string) $user->name,
                ])
                ->values();
        } else {
            $results = Contact::query()
                ->with('customer:id,customer_name')
                ->when($like, function ($query) use ($like) {
                    $query->where(function ($inner) use ($like) {
                        $inner->where('name', 'like', $like)
                            ->orWhereHas('customer', function ($customer) use ($like) {
                                $customer->where('customer_name', 'like', $like);
                            });
                    });
                })
                ->get(['id', 'name', 'customer_id'])
                ->sortBy(fn (Contact $contact) => strtolower(($contact->customer->customer_name ?? '').' '.$contact->name))
                ->map(function (Contact $contact) {
                    return [
                        'id' => (int) $contact->id,
                        'text' => (string) $contact->name,
                        'group' => (string) ($contact->customer->customer_name ?? ''),
                    ];
                })
                ->values();
        }

        return response()->json(['results' => $results])->header('Cache-Control', 'no-store');
    }

    public function recent(): JsonResponse
    {
        $threads = backpack_user()->threads
            ->map(function ($thread) {
                $last = $thread->lastMessage;

                if (! $last || ! $last->created_at) {
                    return null;
                }

                $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($last->body ?? ''))));

                return [
                    'id' => (int) $thread->id,
                    'sent_at' => $last->created_at->toIso8601String(),
                    'unread' => (int) ($thread->unreadMessagesCount ?? 0),
                    'preview' => $text === '' ? ($last->attachment ? 'Attachment' : '') : \Illuminate\Support\Str::limit($text, 42),
                ];
            })
            ->filter()
            ->sortByDesc('sent_at')
            ->values();

        return response()->json([
            'threads' => $threads,
        ])->header('Cache-Control', 'no-store');
    }

    public function messages(Request $request, int $thread): JsonResponse
    {
        $thread = $this->findReadableThread($thread);
        backpack_user()->markThreadAsRead($thread->id);

        $afterId = max(0, (int) $request->query('after', 0));
        $table = (new Message)->getTable();

        $messages = $thread->messages()
            ->where($table.'.id', '>', $afterId)
            ->orderBy($table.'.id')
            ->limit(100)
            ->get()
            ->map(fn (Message $message) => $this->presentMessage($message))
            ->values();

        return response()->json([
            'messages' => $messages,
        ])->header('Cache-Control', 'no-store');
    }

    public function reply(Request $request, int $thread): JsonResponse|RedirectResponse
    {
        $thread = $this->findReadableThread($thread);
        $sender = backpack_user();

        if (! $sender) {
            abort(403);
        }

        $body = $request->input('msg');

        if (is_string($body)) {
            $body = trim($body);
            $request->merge(['msg' => $body === '' ? null : $body]);
        }

        $file = $request->file('attachment');

        if (! $file || ! $file->isValid()) {
            $request->files->remove('attachment');
        }

        $request->validate([
            'msg' => 'required_without:attachment|nullable|string|min:1|max:10000',
            'attachment' => MessageRequest::attachmentRules(),
        ], [
            'attachment.mimes' => 'Attach an image, PDF, Word, Excel, PowerPoint, CSV, or text file.',
        ]);

        $file = $request->file('attachment');

        $message = Messenger::from($sender)
            ->to($thread)
            ->attachmentTitle($file ? $file->getClientOriginalName() : null)
            ->message($request->input('msg'))
            ->attachment($file)
            ->send();

        if (! $message instanceof Message) {
            abort(500, 'Unable to save the message.');
        }

        backpack_user()->markThreadAsRead($thread->id);

        if (! $request->expectsJson()) {
            return redirect()->route('message.show', $thread->id);
        }

        return response()->json([
            'message' => $this->presentMessage($message),
        ]);
    }

    private function findReadableThread(int $threadId): MessageThread
    {
        $thread = MessageThread::query()
            ->without('messages')
            ->with('participants')
            ->find($threadId);

        if (! $thread instanceof MessageThread) {
            abort(404);
        }

        $user = backpack_user();

        if (! $user) {
            abort(403);
        }

        $allowed = $thread->participants->contains(function ($participant) use ($user) {
            return $participant->model === $user::class
                && (int) $participant->user_id === (int) $user->id;
        });

        if (! $allowed) {
            abort(404);
        }

        return $thread;
    }

    /**
     * @return array<string, mixed>
     */
    private function presentMessage(Message $message): array
    {
        $user = backpack_user();
        $url = is_string($message->attachment) ? $message->attachment : '';
        $path = parse_url($url, PHP_URL_PATH) ?: $url;
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $safeUrl = $url !== '' && (
            (str_starts_with($url, '/') && ! str_starts_with($url, '//'))
            || str_starts_with($url, 'http://')
            || str_starts_with($url, 'https://')
        );

        return [
            'id' => (int) $message->id,
            'body' => (string) ($message->body ?? ''),
            'mine' => $user
                && (int) $message->sender_id === (int) $user->id
                && ($message->model === null || $message->model === '' || $message->model === $user::class),
            'time' => optional($message->created_at)->diffForHumans() ?? '',
            'sent_at' => optional($message->created_at)->toIso8601String() ?? '',
            'attachment' => $safeUrl ? [
                'url' => $url,
                'name' => $message->attachment_title ?: 'Attachment',
                'is_image' => in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true),
            ] : null,
        ];
    }
}
