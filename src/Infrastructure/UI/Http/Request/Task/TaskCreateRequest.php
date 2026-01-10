<?php
declare(strict_types=1);

namespace App\Infrastructure\UI\Http\Request\Task;

use App\Domain\Task\Enum\Difficulty;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class TaskCreateRequest
{
    #[Assert\NotBlank(message: 'Title is required')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Title must be at least {{ limit }} characters long',
        maxMessage: 'Title cannot be longer than {{ limit }} characters'
    )]
    public string $title;

    #[Assert\Length(max: 1000)]
    public ?string $description;

    #[Assert\NotBlank]
    #[Assert\Type(type: Difficulty::class)]
    public Difficulty $difficulty;

    #[Assert\NotBlank]
    #[Assert\Uuid(message: 'Idempotency key must be a valid UUID')]
    public ?string $idempotencyKey;

    public function __construct(
        string     $title,
        ?string    $description,
        Difficulty $difficulty,
        ?string    $idempotencyKey = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->idempotencyKey = $idempotencyKey;
        $this->difficulty = $difficulty;
    }

    /**
     * @throws JsonException
     */
    public static function fromRequest(Request $request): self
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        return new self(
            title: $data['title'] ?? throw new \InvalidArgumentException('Title is required'),
            description: $data['description'] ?? null,
            difficulty: Difficulty::fromString($data['difficulty'] ?? null),
            idempotencyKey: $data['idempotencyKey'] ?? null
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? throw new \InvalidArgumentException('Title is required'),
            description: $data['description'] ?? null,
            difficulty: Difficulty::fromString($data['difficulty'] ?? null),
            idempotencyKey: $data['idempotencyKey'] ?? null
        );
    }
}
