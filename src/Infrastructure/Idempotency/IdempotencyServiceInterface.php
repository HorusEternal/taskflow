<?php

declare(strict_types=1);

namespace App\Infrastructure\Idempotency;

interface IdempotencyServiceInterface
{
    public function find(string $key): ?IdempotencyRecord;

    public function remember(string $key, int|string $eventId, string $aggregateId, ?\DateTimeImmutable $occurredAt = null);
}
