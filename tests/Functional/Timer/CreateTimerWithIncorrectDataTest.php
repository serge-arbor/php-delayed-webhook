<?php

declare(strict_types=1);

namespace App\Tests\Functional\Timer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CreateTimerWithIncorrectDataTest extends WebTestCase
{
    /**
     * @throws \JsonException
     */
    public function testCreateTimerWithIncorrectField(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $this->expectException(BadRequestHttpException::class);

        $postRequestData = ['a' => 'b'];
        $client->request('POST', '/api/v1/timers', [], [], [], json_encode($postRequestData, JSON_THROW_ON_ERROR));
    }

    /**
     * @throws \JsonException
     */
    public function testCreateTimerWithIncorrectFieldValue(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);

        $this->expectException(BadRequestHttpException::class);

        $postRequestData = ['hours' => 'a'];
        $client->request('POST', '/api/v1/timers', [], [], [], json_encode($postRequestData, JSON_THROW_ON_ERROR));
    }
}
