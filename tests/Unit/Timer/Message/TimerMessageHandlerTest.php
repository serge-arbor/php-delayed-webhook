<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timer\Message;

use App\Timer\Message\TimerMessage;
use App\Timer\Message\TimerMessageHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TimerMessageHandlerTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     */
    public function testInvoke(): void
    {
        $id = 1;
        $url = 'https://example.com';

        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with('POST', $url . '/' . $id);

        $handler = new TimerMessageHandler($httpClient);
        $handler(new TimerMessage($id, $url));
    }
}
