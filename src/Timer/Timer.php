<?php

declare(strict_types=1);

namespace App\Timer;

class Timer
{
    public function __construct(
        private int $id,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $triggerAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getTriggerAt(): \DateTimeImmutable
    {
        return $this->triggerAt;
    }
}
