<?php

namespace Amplify\System\Backend\Http\Controllers\Admin;

use Amplify\System\Abstracts\BackpackCustomCrudController;
use Amplify\System\Backend\Models\Contact;
use Amplify\System\Backend\Models\User;
use Amplify\System\Message\Facades\Messenger;
use Amplify\System\Message\Http\Requests\MessageRequest;
use Amplify\System\Message\Models\Message;
use Amplify\System\Message\Models\MessageThread;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageCrudController extends BackpackCustomCrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

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
        $this->data['threads'] = backpack_user()->threads;
        $this->data['currentThread'] = $this->crud->getCurrentEntry();

        backpack_user()->markThreadAsRead($this->data['currentThread']->id);

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
        } catch (\Exception $exception) {
            \Alert::error($exception->getMessage());

            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @return RedirectResponse
     *
     * @throws \Amplify\System\Message\Exceptions\MessengerException
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'msg' => 'required_without:attachment|nullable|min:1',
            'attachment' => 'required_without:msg',
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
}
