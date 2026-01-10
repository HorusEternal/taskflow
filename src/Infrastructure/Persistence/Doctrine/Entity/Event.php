<?php

namespace App\Infrastructure\Persistence\Doctrine\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\Column(type: Types::GUID, unique: true)]
    #[ORM\CustomIdGenerator(class: UlidGenerator::class)]
    private string $id;

    #[ORM\Column(type: Types::GUID)]
    private string $aggregateId;

    #[ORM\Column(length: 255)]
    private string $aggregateType;

    #[ORM\Column(length: 255)]
    private string $eventType;

    #[ORM\Column(type: Types::JSONB)]
    private array $payload = [];

    #[ORM\Column(type: Types::JSONB, options: ['default' => '{}'])]
    private array $metadata = [];

    #[ORM\Column]
    private int $version = 1;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string              $aggregateId,
        string              $aggregateType,
        string              $eventType,
        array               $payload,
        int                 $version,
        array               $metadata = [],
        ?\DateTimeImmutable $createdAt = null
    )
    {
        $this->aggregateId = $aggregateId;
        $this->aggregateType = $aggregateType;
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->version = $version;
        $this->metadata = $metadata;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAggregateId(): ?string
    {
        return $this->aggregateId;
    }


    public function getAggregateType(): ?string
    {
        return $this->aggregateType;
    }


    public function getEventType(): ?string
    {
        return $this->eventType;
    }


    public function getPayload(): array
    {
        return $this->payload;
    }


    public function getMetadata(): array
    {
        return $this->metadata;
    }


    public function getVersion(): int
    {
        return $this->version;
    }


    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }


}
