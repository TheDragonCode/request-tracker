<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;
use Ramsey\Uuid\Uuid;

test('If header exists, return it', function () {
    $header = new TrackerHeader;

    $request   = makeRequest([$header->traceId => 'trace-123']);
    $telemetry = new TrackerRequest($request, $header);

    expect($telemetry->getTraceId())->toBe('trace-123');
});

test('When absent, generate UUID', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $generated = $telemetry->getTraceId();

    expect(Uuid::isValid($generated))->toBeTrue()
        ->and(Uuid::fromString($generated)->getVersion())->toBe(7);
});

test('traceId() without param sets header using getTraceId()', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->traceId();

    expect($request->headers->has($header->traceId))->toBeTrue()
        ->and(Uuid::isValid($request->headers->get($header->traceId)))->toBeTrue();
});

test('traceId() with explicit value sets header', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->traceId('manual-id');

    expect($request->headers->get($header->traceId))->toBe('manual-id');
});
