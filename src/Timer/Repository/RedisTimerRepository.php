<?php

declare(strict_types=1);

namespace App\Timer\Repository;

use App\Timer\Timer;

class RedisTimerRepository implements TimerRepository
{
    public function findById(int $id): ?Timer
    {
        // TODO: implement search in Redis
        return new Timer($id, new \DateTimeImmutable(), new \DateTimeImmutable());
    }
}
