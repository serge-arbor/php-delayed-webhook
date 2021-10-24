<?php

declare(strict_types=1);

namespace App\Timer\Controller\GetTimer;

class GetTimerResponseDto
{
    public function __construct(private int $id, private int $timeLeft)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTimeLeft(): int
    {
        return $this->timeLeft;
    }
}
