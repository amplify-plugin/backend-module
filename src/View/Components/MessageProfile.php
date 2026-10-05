<?php

namespace Amplify\System\Backend\View\Components;

use Amplify\System\Backend\Models\Contact;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class MessageProfile extends Component
{
    private Collection $threads;

    private $entries;

    private $currentThead;

    /**
     * @var bool
     */
    private $asCustomer;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $asCustomer = false, $threads = null, $current = null)
    {
        $this->entries = $threads;

        $this->threads = collect();

        $this->currentThead = $current;

        $this->asCustomer = $asCustomer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $this->loadActiveThreads();

        return view('message::message-profile', [
            'threads' => $this->threads,
            'as_customer' => $this->asCustomer,
        ]);
    }

    private function loadActiveThreads()
    {
        if ($this->entries != null) {
            $this->entries->each(function ($thead) {
                if ($thead->lastMessage) {
                    $this->push($thead);
                }
            });

            $this->threads = $this->threads
                ->sortByDesc('last_message_at')
                ->values();
        }
    }

    private function push($thread)
    {
        $item = new \stdClass;
        $item->id = $thread->id;
        $item->is_active = $this->currentThead && $thread->id == $this->currentThead->id;
        $item->link = ($this->asCustomer) ? route('frontend.messages.show', $thread->id) : route('message.show', $thread->id);
        $item->title = $thread->sender->name ?? 'Deleted User';
        $item->image = $this->theadImage($thread, $item->is_active);
        $item->company = ($thread->sender instanceof Contact) ? $thread->sender->customer->customer_name : '';
        $item->unreaded = (int) ($thread->unreadMessagesCount ?? 0);
        $item->preview = $this->preview($thread->lastMessage);
        $item->last_message_at = $thread->lastMessage->created_at?->toIso8601String();
        $item->last_saw_at = $thread->lastMessage->created_at?->diffForHumans();

        $this->threads->push($item);
    }

    private function theadImage($thread, $is_active)
    {
        $sender = $thread->sender;

        if ($sender == null) {
            return 'https://ui-avatars.com/api/?background='.(($is_active) ? 'cef2ef' : 'a0a0a0').'&rounded=true&name='.urlencode($thread->sender->name ?? 'N M');
        }

        return $sender->avatarImage();
    }

    private function preview($message): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) ($message->body ?? ''))));

        if ($text === '') {
            return $message->attachment ? 'Attachment' : '';
        }

        return \Illuminate\Support\Str::limit($text, 42);
    }
}
