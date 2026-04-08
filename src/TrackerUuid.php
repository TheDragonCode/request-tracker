<?php

declare(strict_types=1);

namespace DragonCode\RequestTracker;

use Ramsey\Uuid\UuidFactory;

class TrackerUuid
{
    public static function get(): string
    {
        return (new UuidFactory)->uuid7()->toString();
    }
}
