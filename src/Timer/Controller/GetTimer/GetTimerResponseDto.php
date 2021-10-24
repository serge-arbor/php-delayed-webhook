<?php

declare(strict_types=1);

namespace App\Timer\Controller\GetTimer;

use OpenApi\Annotations as OA;

class GetTimerResponseDto
{
    public function __construct(private int $id, private int $timeLeft)
    {
    }

    /**
     * @OA\Property(description="The ID of the timer")
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @OA\Property(description="Amount of seconds left until the timer expires")
     */
    public function getTimeLeft(): int
    {
        return $this->timeLeft;
    }
}
