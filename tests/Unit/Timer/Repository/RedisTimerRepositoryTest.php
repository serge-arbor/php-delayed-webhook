<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timer\Repository;

use App\Redis\RedisClient;
use App\Timer\Repository\RedisTimerRepository;
use App\Timer\Timer;
use PHPUnit\Framework\TestCase;

class RedisTimerRepositoryTest extends TestCase
{
    private RedisClient $redisClient;

    private RedisTimerRepository $repository;

    protected function setUp(): void
    {
        $this->redisClient = $this->createMock(RedisClient::class);
        $this->repository = new RedisTimerRepository($this->redisClient);
    }

    /**
     * @throws \Exception
     */
    public function testFindById(): void
    {
        $id = 1;
        $createdAt = '2000-01-02T10:20:30+00:00';
        $triggerAt = '2000-01-03T10:20:30+00:00';
        $url = 'https://example.com';

        $this->redisClient
            ->expects($this->once())
            ->method('hGet')
            ->with('timer:' . $id, ['created_at', 'trigger_at', 'url'])
            ->willReturn(['created_at' => $createdAt, 'trigger_at' => $triggerAt, 'url' => $url]);

        $timer = $this->repository->findById($id);

        $expected = new Timer($id, new \DateTimeImmutable($createdAt), new \DateTimeImmutable($triggerAt), $url);
        $this->assertEquals($expected, $timer);
    }

    /**
     * @throws \Exception
     */
    public function testFindByIdWithNonExistingId(): void
    {
        $id = 1;

        $this->redisClient
            ->expects($this->once())
            ->method('hGet')
            ->with('timer:' . $id, ['created_at', 'trigger_at', 'url'])
            ->willReturn(['created_at' => false, 'trigger_at' => false, 'url' => false]);

        $this->assertNull($this->repository->findById($id));
    }
}
