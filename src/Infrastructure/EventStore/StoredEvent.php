<?php
declare(strict_types=1);

namespace App\Infrastructure\EventStore;

use DateTimeImmutable;

final readonly class StoredEvent
{
    public function __construct(
        public string            $id,
        public string            $aggregateId,
        public string            $eventType,
        public int               $version,
        public array             $payload,
        public array             $metadata,
        public DateTimeImmutable $createdAt
    )
    {
    }
}
