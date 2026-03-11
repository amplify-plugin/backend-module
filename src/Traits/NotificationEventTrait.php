<?php

namespace Amplify\System\Backend\Traits;

use Amplify\System\Backend\Models\Event;
use Amplify\System\Services\EmailService;
use Amplify\System\Services\MessageService;

trait NotificationEventTrait
{
    private $eventCode;

    /**
     * @var EmailService
     */
    private $emailService;

    /**
     * @var MessageService
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
        $this->eventInfo = Event::where(['enabled' => true, 'code' => $this->eventCode])
            ->with('eventActions', 'eventActions.eventTemplate')
            ->first();
    }
}
