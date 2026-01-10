<?php

namespace App\Infrastructure\Messaging;

enum KafkaTopic: string
{
    case TASK_EVENT = 'taskflow.events';
    case SKILL_EVENTS = 'taskflow.skills';
}
