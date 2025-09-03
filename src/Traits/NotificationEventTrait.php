<?php

namespace Amplify\System\Backend\Traits;

use Amplify\System\Services\EmailService;
use Amplify\System\Services\MessageService;
use App\Models\Event;

trait NotificationEventTrait
{
    private $eventCode;

    /**
     * @var \Amplify\System\Services\EmailService
     */
    private $emailService;

    /**
     * @var \Amplify\System\Services\MessageService
     */
    private $messageService;

    /**
     * @var Event
     */
    private $eventInfo;

    private function getNecessaryItems()
    {
        $this->emailService = new EmailService;

        $this->messageService = new MessageService;
        $this->eventInfo = Event::where(['enabled' => 1, 'code' => $this->eventCode])
            ->with('eventActions', 'eventActions.eventTemplate')
            ->first();
    }
}
