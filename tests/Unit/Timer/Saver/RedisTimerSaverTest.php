<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timer\Saver;

use App\Redis\RedisClient;
use App\Timer\Saver\CreateTimerDto;
use App\Timer\Saver\RedisTimerSaver;
use PHPUnit\Framework\TestCase;

class RedisTimerSaverTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testSave(): void
    {
        $id = 1;
        $createdAt = '2000-01-02T10:20:30+00:00';
        $triggerAt = '2000-01-03T10:20:30+00:00';
        $url = 'https://example.com';

        $redisClient = $this->createMock(RedisClient::class);
        $redisClient
            ->expects($this->once())
            ->method('incr')
            ->with('timer:id_sequence')
            ->willReturn($id);
        $redisClient
            ->expects($this->once())
            ->method('hSet')
            ->with('timer:' . $id, ['created_at' => $createdAt, 'trigger_at' => $triggerAt, 'url' => $url]);

        $saver = new RedisTimerSaver($redisClient);
        $saver->save(new CreateTimerDto(new \DateTimeImmutable($createdAt), new \DateTimeImmutable($triggerAt), $url));
    }
}
