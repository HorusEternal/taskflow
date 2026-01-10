<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Setting
{

    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $key;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $value = [];

    #[ORM\Column(type: 'datetimetz')]
    private ?\DateTimeImmutable $updatedAt = null;


    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): static
    {
        $this->value = $value;
        $this->setUpdatedAt(new \DateTimeImmutable());
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
