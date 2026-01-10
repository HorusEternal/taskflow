<?php

namespace App\Domain\Task\Enum;

enum TaskStatus: string
{
    case OPEN = 'open';
    case PROCESS = 'process';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case FAILED = 'failed';
    case PAUSED = 'paused';
}
