<?php
declare(strict_types=1);

namespace App\Application\Task\Handler;

use App\Application\Task\Command\CreateTaskCommand;
use App\Domain\Event\DomainEvent;
use App\Domain\Task\Event\TaskCreated;
use App\Domain\Task\VO\TaskId;
use App\Infrastructure\EventStore\EventStoreInterface;
use App\Infrastructure\Idempotency\IdempotencyServiceInterface;
use Ramsey\Uuid\Uuid;

final readonly class CreateTaskHandler
{
    public function __construct(
        private EventStoreInterface         $eventStore,
        private IdempotencyServiceInterface $idempotency,
    )
    {
    }

    public function handle(CreateTaskCommand $command): DomainEvent
    {
        if ($this->idempotency->find($command->idempotencyKey)) {
            throw new \RuntimeException('Request already processed');
        }

        $taskId = TaskId::fromString(Uuid::uuid4()->toString());

        $event = TaskCreated::create(
            taskId: $taskId,
            title: $command->title,
            difficulty: $command->difficulty,
            description: $command->description
        );

        $storedEvent = $this->eventStore->append($event);

        $this->idempotency->remember(
            key: $command->idempotencyKey,
            eventId: $storedEvent->eventId,
            aggregateId: $taskId->toString(),
        );

        return $event;
    }
}
