<?php

declare(strict_types=1);

namespace App\Timer\Controller\CreateTimer;

class CreateTimerResponseDto
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
