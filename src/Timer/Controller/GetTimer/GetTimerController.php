<?php

declare(strict_types=1);

namespace App\Timer\Controller\GetTimer;

use App\Timer\Repository\TimerRepository;
use App\Timer\Timer;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Get(
 *     operationId="getTimer",
 *     @OA\Response(
 *         response="200",
 *         description="Returns the timer by the ID",
 *         @Model(type=GetTimerResponseDto::class)
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Returns timer not found error",
 *         @OA\JsonContent(
 *             @OA\Property(property="type", type="string"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="status", type="integer"),
 *             @OA\Property(property="detail", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="type", type="string"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="status", type="integer"),
 *             @OA\Property(property="detail", type="string")
 *         )
 *     )
 * )
 * @OA\Tag(name="timers")
 */
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

//        if (!$timer) {
        throw $this->createNotFoundException();
//        }

        return $timer;
    }

    private function calculateTimeLeft(Timer $timer): int
    {
        $now = new \DateTimeImmutable();

        return max($timer->getTriggerAt()->getTimestamp() - $now->getTimestamp(), 0);
    }
}
