<?php

declare(strict_types=1);

namespace App\Timer\Repository;

use App\RedisClient;
use App\Timer\Timer;

class RedisTimerRepository implements TimerRepository
{
    public function __construct(private RedisClient $redisClient)
    {
    }

    /**
     * @throws \Exception
     */
    public function findById(int $id): ?Timer
    {
        $data = $this->redisClient->hGet('timer:' . $id, ['created_at', 'trigger_at']);

        if (!$data['created_at'] || !$data['trigger_at']) {
            return null;
        }

        return new Timer($id, new \DateTimeImmutable($data['created_at']), new \DateTimeImmutable($data['trigger_at']));
    }
}
