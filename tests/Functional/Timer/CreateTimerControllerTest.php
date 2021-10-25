<?php

declare(strict_types=1);

namespace App\Tests\Functional\Timer;

use App\Tests\Functional\MockClientCallback;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\EventListener\StopWorkerOnMessageLimitListener;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Worker;

class CreateTimerControllerTest extends WebTestCase
{
    /**
     * @throws \JsonException
     */
    public function testInvoke(): void
    {
        $client = static::createClient();

        $url = 'https://example.com';

        $postRequestData = ['hours' => 0, 'minutes' => 0, 'seconds' => 0, 'url' => $url];
        $client->request('POST', '/api/v1/timers', [], [], [], json_encode($postRequestData, JSON_THROW_ON_ERROR));

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseFormatSame('json');

        $postResponseData = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertArrayHasKey('id', $postResponseData);

        $client->request('GET', '/api/v1/timers/' . $postResponseData['id']);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseFormatSame('json');

        $getResponseData = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame(['id' => $postResponseData['id'], 'time_left' => 0], $getResponseData);

        $container = $this->getContainer();

        $receiver = $container->get('messenger.transport.async');
        $bus = $container->get(MessageBusInterface::class);
        $eventDispatcher = $container->get(EventDispatcherInterface::class);
        $eventDispatcher->addSubscriber(new StopWorkerOnMessageLimitListener(1));

        $worker = new Worker([$receiver], $bus, $eventDispatcher);
        $worker->run();

        $mockClientCallback = $container->get(MockClientCallback::class);
        $this->assertCount(1, $mockClientCallback->getRequests());
        $this->assertSame('POST', $mockClientCallback->getRequests()[0]['method']);
        $this->assertSame($url . '/' . $postResponseData['id'], $mockClientCallback->getRequests()[0]['url']);
    }
}
