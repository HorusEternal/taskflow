<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'profile')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(type: Types::BIGINT)]
    private string $totalXp;

    #[ORM\Column]
    private int $overallLevel;

    #[ORM\Column(type: Types::JSON, options: ['default' => '{}'])]
    private array $preferences = [];

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    private \DateTimeImmutable $updatedAt;


    public function getTotalXp(): ?string
    {
        return $this->totalXp;
    }

    public function setTotalXp(string $totalXp): static
    {
        $this->totalXp = $totalXp;

        return $this;
    }

    public function getOverallLevel(): ?int
    {
        return $this->overallLevel;
    }

    public function setOverallLevel(int $overallLevel): static
    {
        $this->overallLevel = $overallLevel;

        return $this;
    }

    public function getPreferences(): array
    {
        return $this->preferences;
    }

    public function setPreferences(array $preferences): static
    {
        $this->preferences = $preferences;

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
