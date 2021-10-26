<?php

declare(strict_types=1);

namespace App\Tests\Functional\Timer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetNonExistingTimerTest extends WebTestCase
{
    /**
     * @throws \JsonException
     */
    public function testGetTimer(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $this->expectException(NotFoundHttpException::class);

        $client->request('GET', '/api/v1/timers/999');
    }
}
