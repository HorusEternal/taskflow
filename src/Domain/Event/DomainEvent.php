<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTimeImmutable;

interface DomainEvent
{
    /**
     * Идентификатор агрегата, к которому относится событие
     * (в нашем случае — TaskId)
     */
    public function aggregateId(): string;

    /**
     * Когда событие произошло (обычно время создания события)
     */
    public function getOccurredOn(): DateTimeImmutable;

    /**
     * Версия агрегата после применения этого события (опционально на старте)
     * Полезно для optimistic concurrency и при восстановлении состояния
     *
     * @return int
     */
    public function getVersion(): int;
}
