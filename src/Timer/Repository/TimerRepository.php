<?php

declare(strict_types=1);

namespace App\Timer\Repository;

use App\Timer\Timer;

interface TimerRepository
{
    public function findById(int $id): ?Timer;
}
