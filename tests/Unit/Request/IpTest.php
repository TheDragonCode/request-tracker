<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;

test('If telemetry header exists, it wins', function () {
    $header = new TrackerHeader;

    $request   = makeRequest([$header->ip => '203.0.113.10']);
    $telemetry = new TrackerRequest($request, $header);

    expect($telemetry->getIp())->toBe('203.0.113.10');
});

test('Else HTTP_X_REAL_IP (non-standard header name checked by the class)', function () {
    $header = new TrackerHeader;

    $request = makeRequest();
    $request->headers->set('HTTP_X_REAL_IP', '198.51.100.20');
    $telemetry = new TrackerRequest($request, $header);

    expect($telemetry->getIp())->toBe('198.51.100.20');
});

test('Else client ip (REMOTE_ADDR)', function () {
    $header = new TrackerHeader;

    $request   = makeRequest([], ['REMOTE_ADDR' => '192.0.2.30']);
    $telemetry = new TrackerRequest($request, $header);

    expect($telemetry->getIp())->toBe('192.0.2.30');
});

test('ip() without argument sets header from getIp()', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->ip();

    expect($request->headers->get($header->ip))->toBe('127.0.0.1');
});

test('ip() with value overrides and sets header', function () {
    $header = new TrackerHeader;

    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);
    $telemetry->ip('10.0.0.1');

    expect($request->headers->get($header->ip))->toBe('10.0.0.1');
});
