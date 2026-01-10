<?php

namespace App\Domain\Task;

use App\Domain\Task\Enum\Difficulty;
use App\Domain\Task\Event\TaskCreated;
use App\Domain\Task\VO\TaskId;
use DateTimeImmutable;

class Task
{
    private array $recordedEvents;

    public function __construct(
        private TaskId             $id,
        private string             $title,
        private ?string            $description,
        private Difficulty         $difficulty,
        private DateTimeImmutable  $createdAt,
        private ?DateTimeImmutable $completedAt = null,
        private bool               $isCompleted = false,
    )
    {
    }

    public static function create(
        string     $title,
        ?string    $description,
        Difficulty $difficulty,
    ): self
    {
        $id = TaskId::create();
        $createdAt = new DateTimeImmutable();
        $task = new self(
            id: $id,
            title: $title,
            description: $description,
            difficulty: $difficulty,
            createdAt: $createdAt,
        );

        $task->recordThat(
            TaskCreated::create(
                taskId: $id,
                title: $title,
                difficulty: $difficulty,
                description: $description,
            )
        );

        return $task;
    }

    private function recordThat(object $event): void
    {
        $this->recordedEvents[] = $event;
        $this->apply($event);
    }

    private function apply(object $event): void
    {
        match (true) {
            $event instanceof TaskCreated => $this->applyTaskCreated($event),
            default => throw new \DomainException("Unknown event type: " . $event::class),
        };
    }

    private function applyTaskCreated(TaskCreated $event): void
    {
        // Здесь можно было бы менять состояние, но т.к. мы создаём через фабрику,
        // состояние уже соответствует событию → оставляем пустым на данном этапе
    }

    /** @return object[] */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}
