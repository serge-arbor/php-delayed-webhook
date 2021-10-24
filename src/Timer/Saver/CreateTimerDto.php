<?php

declare(strict_types=1);

namespace App\Timer\Saver;

class CreateTimerDto
{
    public function __construct(private \DateTimeImmutable $createdAt, private \DateTimeImmutable $triggerAt)
    {
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
