<?php

declare(strict_types=1);

namespace App\Timer\Controller\CreateTimer;

use OpenApi\Annotations as OA;

class CreateTimerResponseDto
{
    public function __construct(private int $id)
    {
    }

    /**
     * @OA\Property(description="The ID of the created timer")
     */
    public function getId(): int
    {
        return $this->id;
    }
}
