<?php

declare(strict_types=1);

namespace App\Timer\Controller\GetTimer;

use App\Timer\Repository\TimerRepository;
use App\Timer\Timer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/timers/{id}', requirements: ['id' => '\d+'], methods: ['GET'])]
class GetTimerController extends AbstractController
{
    public function __construct(private TimerRepository $repository)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $timer = $this->getTimer($id);

        return $this->json(new GetTimerResponseDto($timer->getId(), $this->calculateTimeLeft($timer)));
    }

    private function getTimer(int $id): Timer
    {
        $timer = $this->repository->findById($id);

        if (!$timer) {
            throw $this->createNotFoundException();
        }

        return $timer;
    }

    private function calculateTimeLeft(Timer $timer): int
    {
        $now = new \DateTimeImmutable();

        return max($timer->getTriggerAt()->getTimestamp() - $now->getTimestamp(), 0);
    }
}
