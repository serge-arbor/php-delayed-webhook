<?php

declare(strict_types=1);

namespace App\Redis;

interface RedisClient
{
    public function hGet(string $key, array $hashKeys): array;

    public function hSet(string $key, array $hashKeys): bool;

    public function incr(string $key): int;
}
