<?php

namespace App\Infrastructure\Schema;

use App\Enums\EventName;
use App\Enums\SchemaVersion;

interface SchemaRegistryInterface
{
    public function get(
        EventName     $eventName,
        SchemaVersion $version,
    ): string;
}
