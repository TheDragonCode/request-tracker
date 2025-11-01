<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;
use Ramsey\Uuid\Uuid;

it('gets or sets trace id, generating a UUID v4 when absent', function () {
    $header = new TrackerHeader;

    // 1) If header exists, return it
    $request   = makeRequest([$header->traceId => 'trace-123']);
    $telemetry = new TrackerRequest($request, $header);
    expect($telemetry->getTraceId())->toBe('trace-123');

    // 2) When absent, generate UUID v4
    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $generated = $telemetry->getTraceId();
    expect(Uuid::isValid($generated))->toBeTrue()
        ->and(Uuid::fromString($generated)->getVersion())->toBe(4);

    // 3) traceId() without param sets header using getTraceId()
    $telemetry->traceId();
    expect($request->headers->has($header->traceId))->toBeTrue()
        ->and(Uuid::isValid($request->headers->get($header->traceId)))->toBeTrue();

    // 4) traceId() with explicit value sets header
    $telemetry->traceId('manual-id');
    expect($request->headers->get($header->traceId))->toBe('manual-id');
});
