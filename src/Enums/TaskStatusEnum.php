<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case Open = 'open';
    case InProgress = 'in-progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Failed = 'failed';
    case Paused = 'paused';
}
