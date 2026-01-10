<?php

namespace App\Infrastructure\Schema;

use App\Enums\EventName;
use App\Enums\SchemaVersion;


final class FileSchemaRegistry implements SchemaRegistryInterface
{
    public function __construct(
        private string $schemasRoot,
    )
    {
    }


    public function get(EventName $eventName, SchemaVersion $version): string
    {
        $path = sprintf(
            '%s/%s/v%d.schema.json',
            $this->schemasRoot,
            $eventName->directory(),
            $version->value
        );

        if (!is_file($path)) {
            throw new SchemaNotFoundException(
                $eventName,
                $version
            );
        }

        return file_get_contents($path);
    }
}
