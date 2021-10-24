<?php

declare(strict_types=1);

namespace App\Timer\Saver;

use App\Timer\Timer;

class RedisTimerSaver implements TimerSaver
{
    public function save(CreateTimerDto $dto): Timer
    {
        // TODO: implement save to Redis
        return new Timer(1, $dto->getCreatedAt(), $dto->getTriggerAt());
    }
}
