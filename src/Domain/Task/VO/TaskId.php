<?php

namespace App\Domain\Task\VO;

use Ramsey\Uuid\Uuid;
use Stringable;

readonly class TaskId implements Stringable
{

    public function __construct(
        private string $value,
    )
    {
        if (!Uuid::isValid($this->value)) {
            throw new \InvalidArgumentException("Invalid task id format: must be a valid UUIDv4");
        }
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function equals(self $other): bool
    {
        return $other->value === $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->value;
    }
}

