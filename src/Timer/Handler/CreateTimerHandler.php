<?php

declare(strict_types=1);

namespace App\Timer\Handler;

use App\Timer\Message\TimerMessage;
use App\Timer\Saver\CreateTimerDto;
use App\Timer\Saver\TimerSaver;
use App\Timer\Timer;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class CreateTimerHandler
{
    public function __construct(private TimerSaver $saver, private MessageBusInterface $bus)
    {
    }

    public function handle(CreateTimerDto $dto): Timer
    {
        $timer = $this->saver->save($dto);
        $this->dispatchMessage($timer);

        return $timer;
    }

    private function dispatchMessage(Timer $timer): void
    {
        $delay = ($timer->getTriggerAt()->getTimestamp() - $timer->getCreatedAt()->getTimestamp());

        $stamps = [];
        if ($delay) {
            $stamps[] = new DelayStamp($delay * 1000);
        }

        $this->bus->dispatch(new TimerMessage($timer->getId(), $timer->getUrl()), $stamps);
    }
}
