<?php

declare(strict_types=1);

namespace App\Timer\Saver;

use App\RedisClient;
use App\Timer\Timer;

class RedisTimerSaver implements TimerSaver
{
    public function __construct(private RedisClient $redisClient)
    {
    }

    public function save(CreateTimerDto $dto): Timer
    {
        $id = $this->redisClient->incr('timer:id_sequence');
        $this->redisClient->hSet(
            'timer:' . $id,
            [
                'created_at' => $dto->getCreatedAt()->format(\DateTimeInterface::ATOM),
                'trigger_at' => $dto->getTriggerAt()->format(\DateTimeInterface::ATOM),
                'url' => $dto->getUrl(),
            ],
        );

        return new Timer($id, $dto->getCreatedAt(), $dto->getTriggerAt(), $dto->getUrl());
    }
}
