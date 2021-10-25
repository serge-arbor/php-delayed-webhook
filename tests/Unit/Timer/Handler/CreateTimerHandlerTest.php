<?php

declare(strict_types=1);

namespace App\Tests\Unit\Timer\Handler;

use App\Timer\Handler\CreateTimerHandler;
use App\Timer\Message\TimerMessage;
use App\Timer\Saver\CreateTimerDto;
use App\Timer\Saver\TimerSaver;
use App\Timer\Timer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class CreateTimerHandlerTest extends TestCase
{
    private TimerSaver $saver;

    private MessageBusInterface $bus;

    private CreateTimerHandler $handler;

    protected function setUp(): void
    {
        $this->saver = $this->createMock(TimerSaver::class);
        $this->bus = $this->createMock(MessageBusInterface::class);
        $this->handler = new CreateTimerHandler($this->saver, $this->bus);
    }

    /**
     * @throws \Exception
     */
    public function testHandle(): void
    {
        $id = 1;
        $createdAt = new \DateTimeImmutable('2000-01-02T10:20:30+00:00');
        $triggerAt = new \DateTimeImmutable('2000-01-02T10:20:40+00:00');
        $url = 'https://example.com';

        $dto = new CreateTimerDto($createdAt, $triggerAt, $url);
        $expectedTimer = new Timer($id, $createdAt, $triggerAt, $url);

        $this->saver
            ->expects($this->once())
            ->method('save')
            ->with($dto)
            ->willReturn($expectedTimer);

        $message = new TimerMessage($id, $url);

        $this->bus
            ->expects($this->once())
            ->method('dispatch')
            ->with($message, [new DelayStamp(10000)])
            ->willReturn(new Envelope($message));

        $this->assertSame($expectedTimer, $this->handler->handle($dto));
    }

    /**
     * @throws \Exception
     */
    public function testHandleWithoutDelay(): void
    {
        $id = 1;
        $createdAt = new \DateTimeImmutable('2000-01-02T10:20:30+00:00');
        $triggerAt = new \DateTimeImmutable('2000-01-02T10:20:30+00:00');
        $url = 'https://example.com';

        $dto = new CreateTimerDto($createdAt, $triggerAt, $url);
        $expectedTimer = new Timer($id, $createdAt, $triggerAt, $url);

        $this->saver
            ->expects($this->once())
            ->method('save')
            ->with($dto)
            ->willReturn($expectedTimer);

        $message = new TimerMessage($id, $url);

        $this->bus
            ->expects($this->once())
            ->method('dispatch')
            ->with($message, [])
            ->willReturn(new Envelope($message));

        $this->assertSame($expectedTimer, $this->handler->handle($dto));
    }
}
