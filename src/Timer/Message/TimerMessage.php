<?php

declare(strict_types=1);

namespace App\Timer\Message;

class TimerMessage
{
    public function __construct(private int $id, private string $url)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
