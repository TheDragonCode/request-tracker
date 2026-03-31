<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;

test('Explicit string', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->userId('42');

    expect($request->headers->get($header->userId))->toBe('42')
        ->and($telemetry->getUserId())->toBe('42');
});

test('Explicit int should be cast to string', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->userId(7);

    expect($request->headers->get($header->userId))->toBe('7');
});

test('Fallback to existing header when null', function () {
    $header = new TrackerHeader;

    $request   = makeRequest([$header->userId => '555']);
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->userId(null);

    expect($request->headers->get($header->userId))->toBe('555')
        ->and($telemetry->getUserId())->toBe('555');
});

test('getUserId() returns 0 when nothing present', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    expect($telemetry->getUserId())->toBeNull();
});

test('telemetry header is empty', function (string $value) {
    $header = new TrackerHeader;

    $request   = makeRequest([$header->userId => $value]);
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->userId();

    expect($request->headers->get($header->userId))->toBeNull();
})->with(['', '-']);
