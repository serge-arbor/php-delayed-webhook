<?php

declare(strict_types=1);

namespace App\Timer\Saver;

use App\Timer\Timer;

interface TimerSaver
{
    public function save(CreateTimerDto $dto): Timer;
}
