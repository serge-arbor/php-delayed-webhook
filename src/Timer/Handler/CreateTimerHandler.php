<?php

declare(strict_types=1);

namespace App\Timer\Handler;

use App\Timer\Saver\CreateTimerDto;
use App\Timer\Saver\TimerSaver;
use App\Timer\Timer;

class CreateTimerHandler
{
    public function __construct(private TimerSaver $saver)
    {
    }

    public function handle(CreateTimerDto $dto): Timer
    {
        $timer = $this->saver->save($dto);

        // TODO: dispatch a message

        return $timer;
    }
}
