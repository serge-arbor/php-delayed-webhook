<?php

declare(strict_types=1);

namespace App\Timer\Message;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TimerMessageHandler implements MessageHandlerInterface
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(TimerMessage $message): void
    {
        // TODO: how it will decide if there need to retry?
        $this->client->request('POST', rtrim($message->getUrl(), '/') . '/' . $message->getId());
    }
}
