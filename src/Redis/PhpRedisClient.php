<?php

declare(strict_types=1);

namespace App\Redis;

class PhpRedisClient implements RedisClient
{
    private \Redis $redis;

    public function __construct(string $host, int $port)
    {
        $this->redis = new \Redis();
        $this->redis->connect($host, $port);
    }

    public function hGet(string $key, array $hashKeys): array
    {
        return $this->redis->hMGet($key, $hashKeys);
    }

    public function hSet(string $key, array $hashKeys): bool
    {
        return $this->redis->hMSet($key, $hashKeys);
    }

    public function incr(string $key): int
    {
        return $this->redis->incr($key);
    }
}
