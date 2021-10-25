<?php

declare(strict_types=1);

namespace App\Timer\Message;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TimerMessageHandler implements MessageHandlerInterface
{
    public function __invoke(TimerMessage $message): void
    {
        // TODO: implement
    }
}
