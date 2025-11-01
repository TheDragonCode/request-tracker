<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerHeader;

it('uses default header names', function () {
    $header = new TrackerHeader;

    expect($header->userId)->toBe('X-Tracker-User-Id')
        ->and($header->ip)->toBe('X-Tracker-Ip')
        ->and($header->traceId)->toBe('X-Tracker-Trace-Id');
});

it('accepts custom header names', function () {
    $header = new TrackerHeader(
        userId : 'Some-User-Id',
        ip     : 'Some-IP',
        traceId: 'Some-Trace-Id',
    );

    expect($header->userId)->toBe('Some-User-Id')
        ->and($header->ip)->toBe('Some-IP')
        ->and($header->traceId)->toBe('Some-Trace-Id');
});
