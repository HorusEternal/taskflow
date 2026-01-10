<?php

namespace App\Domain\Task\Event;

use App\Domain\Event\DomainEvent;
use App\Domain\Task\Enum\Difficulty;
use App\Domain\Task\VO\TaskId;
use DateTimeImmutable;

final class TaskCreated implements DomainEvent
{
    private function __construct(
        readonly private TaskId     $taskId,
        readonly private string     $title,
        readonly private Difficulty $difficulty,
        readonly private ?string    $description,
        private ?DateTimeImmutable  $occurredOn = null,
        readonly private int        $version = 1
    )
    {
        $this->occurredOn = $occurredOn ?? new DateTimeImmutable();
    }

    public static function create(
        TaskId     $taskId,
        string     $title,
        Difficulty $difficulty,
        string     $description,
    ): self
    {
        return new self($taskId, $title, $difficulty, $description);
    }


    /**
     * @inheritDoc
     */
    public function aggregateId(): string
    {
        return $this->taskId->toString();
    }

    public function getTaskId(): TaskId
    {
        return $this->taskId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function getVersion(): int
    {
        return $this->version;
    }


}

