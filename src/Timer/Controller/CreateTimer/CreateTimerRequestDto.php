<?php

declare(strict_types=1);

namespace App\Timer\Controller\CreateTimer;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTimerRequestDto
{
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private int $hours;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private int $minutes;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(0)]
    private int $seconds;

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
