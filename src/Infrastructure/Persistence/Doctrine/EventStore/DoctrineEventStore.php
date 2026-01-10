<?php

namespace App\Infrastructure\Persistence\Doctrine\EventStore;

use App\Domain\Event\DomainEvent;
use App\Infrastructure\EventStore\EventStoreInterface;
use App\Infrastructure\EventStore\StoredEvent;
use App\Infrastructure\Persistence\Doctrine\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineEventStore implements EventStoreInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventNormalizer        $normalizer,
    )
    {

    }


    public function append(DomainEvent $event): StoredEvent
    {
        $eventEntity = new Event(
            aggregateId: $event->aggregateId(),
            aggregateType: new \ReflectionClass($event)->getShortName(),
            eventType: $event::class,
            payload: $this->normalizer->normalize($event),
            version: $event->getVersion(),
            metadata: [],
            createdAt: $event->getOccurredOn()
        );

        $this->entityManager->wrapInTransaction(function () use ($eventEntity): void {
            $this->entityManager->persist($eventEntity);
        });

        return new StoredEvent(
            id: $eventEntity->getId(),
            aggregateId: $eventEntity->getAggregateId(),
            eventType: $eventEntity->getEventType(),
            version: $eventEntity->getVersion(),
            payload: $eventEntity->getPayload(),
            metadata: $eventEntity->getMetadata(),
            createdAt: $eventEntity->getCreatedAt()
        );
    }
}
