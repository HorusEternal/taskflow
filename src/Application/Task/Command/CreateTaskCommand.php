<?php

declare(strict_types=1);

namespace App\Application\Task\Command;

use App\Domain\Task\Enum\Difficulty;

final readonly class CreateTaskCommand
{
    public function __construct(
        public string     $title,
        public Difficulty $difficulty,
        public ?string    $idempotencyKey,
        public string     $description,
    )
    {
    }
}
