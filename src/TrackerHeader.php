<?php

declare(strict_types=1);

namespace DragonCode\RequestTracker;

readonly class TrackerHeader
{
    public function __construct(
        public string $userId = 'X-Tracker-User-Id',
        public string $ip = 'X-Tracker-Ip',
        public string $traceId = 'X-Tracker-Trace-Id',
    ) {}
}
