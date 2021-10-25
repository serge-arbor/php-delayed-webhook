<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MockClientCallback
{
    private array $requests = [];

    public function __invoke(string $method, string $url, array $options = []): ResponseInterface
    {
        $this->requests[] = ['method' => $method, 'url' => $url, 'option' => $options];

        return new MockResponse();
    }

    public function getRequests(): array
    {
        return $this->requests;
    }
}
