<?php

namespace App\Domain\Task\Enum;

enum Difficulty: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
    case EPIC = 'epic';

    public static function fromString(?string $s): self
    {
        return match ($s) {
            'easy' => self::EASY,
            'hard' => self::HARD,
            'epic' => self::EPIC,
            default => self::MEDIUM,
        };
    }
}
