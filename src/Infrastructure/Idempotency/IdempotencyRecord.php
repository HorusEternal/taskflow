<?php

namespace App\Infrastructure\Idempotency;

class IdempotencyRecord
{
    public function __construct(
        public string             $key,
        public int|string         $eventId,
        public string             $aggregateId,
        public \DateTimeImmutable $processedAt,
    )
    {
    }
}
