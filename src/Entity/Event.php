<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::GUID)]
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


    public function getId(): ?int
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

    public function setAggregateId(string $aggregateId): static
    {
        $this->aggregateId = $aggregateId;

        return $this;
    }

    public function getAggregateType(): ?string
    {
        return $this->aggregateType;
    }

    public function setAggregateType(string $aggregateType): static
    {
        $this->aggregateType = $aggregateType;

        return $this;
    }

    public function getEventType(): ?string
    {
        return $this->eventType;
    }

    public function setEventType(string $eventType): static
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata): static
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
