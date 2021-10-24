<?php

declare(strict_types=1);

namespace App\Timer\Controller\CreateTimer;

use App\Timer\Handler\CreateTimerHandler;
use App\Timer\Saver\CreateTimerDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/timers', methods: ['POST'])]
class CreateTimerController extends AbstractController
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        private ValidatorInterface $validator,
        private CreateTimerHandler $handler,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $dto = $this->deserializeRequest($request);
        $this->validate($dto);

        $createdAt = new \DateTimeImmutable();
        $triggerAt = $createdAt->add($this->getInterval($dto));

        $timer = $this->handler->handle(new CreateTimerDto($createdAt, $triggerAt));

        return $this->json(new CreateTimerResponseDto($timer->getId()));
    }

    private function deserializeRequest(Request $request): CreateTimerRequestDto
    {
        $data = $request->toArray();

        try {
            return $this->denormalizer->denormalize($data, CreateTimerRequestDto::class, 'json');
        } catch (ExceptionInterface $e) {
            throw new BadRequestHttpException('Could not denormalize request body.', $e);
        }
    }

    private function validate(CreateTimerRequestDto $dto): void
    {
        $errors = $this->validator->validate($dto);
        if (count($errors)) {
            throw new BadRequestHttpException('Request is invalid.');
        }
    }

    private function getInterval(CreateTimerRequestDto $dto): \DateInterval
    {
        $duration = sprintf('PT%dH%dM%dS', $dto->getHours(), $dto->getMinutes(), $dto->getSeconds());

        try {
            return new \DateInterval($duration);
        } catch (\Exception $e) {
            throw new InvalidIntervalException('Interval is incorrect.', 0, $e);
        }
    }
}
