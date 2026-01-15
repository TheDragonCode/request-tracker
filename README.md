# 🪢 Request Tracker

<picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://banners.beyondco.de/Request%20Tracker.png?theme=dark&pattern=topography&style=style_2&fontSize=100px&images=https%3A%2F%2Fsymfony.com%2Flogos%2Fsymfony_black_03.svg&packageManager=composer+require&packageName=dragon-code%2Frequest-tracker&description=Request+tracking+across+microservices&md=1&showWatermark=1">
    <img src="https://banners.beyondco.de/Request%20Tracker.png?theme=light&pattern=topography&style=style_2&fontSize=100px&images=https%3A%2F%2Fsymfony.com%2Flogos%2Fsymfony_black_03.svg&packageManager=composer+require&packageName=dragon-code%2Frequest-tracker&description=Request+tracking+across+microservices&md=1&showWatermark=1" alt="Request Tracker">
</picture>

[![Stable Version][badge_stable]][link_packagist]
[![Total Downloads][badge_downloads]][link_packagist]
[![License][badge_license]][link_license]

Request tracking across microservices.

## Installation

You can install the **Request Tracker** package via [Composer](https://getcomposer.org):

```Bash
composer require dragon-code/request-tracker
```

## Basic Usage

### Using Default Header Names

```php
use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;
use Symfony\Component\HttpFoundation\Request;

/** @var Request $request */
$request = /* ... */;

$tracker = new TrackerRequest($request, new TrackerHeader);

function tracker(Request $request, ?int $userId = null): Request
{
    return (new TrackerRequest($request, new TrackerHeader))
        ->userId($userId)
        ->ip()
        ->traceId()
        ->getRequest();
}

// For the first call
tracker($request, $user->id);

// For subsequent services
tracker($request);
```

### Custom Headers

```php
use DragonCode\RequestTracker\TrackerHeader;
use DragonCode\RequestTracker\TrackerRequest;
use Symfony\Component\HttpFoundation\Request;

/** @var Request $request */
$request = /* ... */;

$tracker = new TrackerRequest($request, new TrackerHeader);

function tracker(Request $request, ?int $userId = null): Request
{
    return (new TrackerRequest($request, new TrackerHeader))
        ->userId($userId)
        ->ip()
        ->traceId()
        ->custom('Some-Header', fn (Request $request) => 1234
        ->getRequest();
}
```

```php
$item = tracker($request);

return $item->headers->get('Some-Header'); // 1234
```

```php
$request->headers->set('Some-Header', 'qwerty');

$item = tracker($request);

return $item->headers->get('Some-Header'); // qwerty
```

### Custom Header Names

```php
use DragonCode\RequestTracker\TrackerHeader;

return new TrackerHeader(
    userId: 'Some-User-Id',
    ip: 'Some-IP',
    traceId: 'Some-Trace-Id',
);
```

## License

This package is licensed under the [MIT License](LICENSE).


[badge_downloads]:      https://img.shields.io/packagist/dt/dragon-code/request-tracker.svg?style=flat-square

[badge_license]:        https://img.shields.io/packagist/l/dragon-code/request-tracker.svg?style=flat-square

[badge_stable]:         https://img.shields.io/github/v/release/TheDragonCode/request-tracker?label=packagist&style=flat-square

[link_license]:         LICENSE

[link_packagist]:       https://packagist.org/packages/dragon-code/request-tracker
