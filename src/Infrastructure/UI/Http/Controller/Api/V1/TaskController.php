<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Http\Controller\Api\V1;

use App\Application\Task\Command\CreateTaskCommand;
use App\Application\Task\Handler\CreateTaskHandler;
use App\Infrastructure\UI\Http\Request\Task\TaskCreateRequest;
use App\Infrastructure\UI\Http\Response\ValidationErrorResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/tasks", name: 'app_api_v1_task_')]
final class TaskController extends AbstractController
{
    public function __construct(private readonly CreateTaskHandler $handler, private readonly ValidatorInterface $validator)
    {

    }

    /**
     * @throws \JsonException
     */
    #[Route('', name: 'store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $dto = TaskCreateRequest::fromRequest($request);

        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return ValidationErrorResponse::fromViolations($errors);
        }

        $command = new CreateTaskCommand(
            title: $dto->title,
            difficulty: $dto->difficulty,
            idempotencyKey: $dto->idempotencyKey,
            description: $dto->description,
        );

        try {
            $event = $this->handler->handle($command);
            $taskId = $event->getTaskId()->toString();
        } catch (\RuntimeException $e) {
            if (str_contains($e->getMessage(), 'already processed')) {
                return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
            }

            throw $e;
        }

        return $this->json([
            'task_id' => $taskId,
        ], Response::HTTP_CREATED);
    }
}
