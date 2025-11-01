<?php

declare(strict_types=1);

use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;

it('returns the same Request instance via getRequest()', function () {
    $header    = new TrackerHeader;
    $request   = makeRequest();
    $telemetry = new TrackerRequest($request, $header);

    expect($telemetry->getRequest())->toBe($request);
});
