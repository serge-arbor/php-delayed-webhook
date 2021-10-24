<?php

declare(strict_types=1);

namespace App\Timer\Controller\CreateTimer;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTimerRequestDto
{
    /**
     * @OA\Property(description="Hours to delay timer")
     */
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private int $hours;

    /**
     * @OA\Property(description="Monites to delay timer")
     */
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private int $minutes;

    /**
     * @OA\Property(description="Seconds to delay timer")
     */
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private int $seconds;

    /**
     * @OA\Property(description="URL to call after the delay")
     */
    #[Assert\NotBlank]
    #[Assert\Url]
    private string $url;

    public function getHours(): int
    {
        return $this->hours;
    }

    public function setHours(int $hours): void
    {
        $this->hours = $hours;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): void
    {
        $this->minutes = $minutes;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    public function setSeconds(int $seconds): void
    {
        $this->seconds = $seconds;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
