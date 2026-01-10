<?php

namespace App\Enums;

enum EventName: string
{
    case TASK_CREATED = 'TaskCreated';
    case TASK_UPDATED = 'TaskUpdated';
    case TASK_COMPLETED = 'TaskCompleted';

    public function directory(): string
    {
        return $this->value;
    }
}
