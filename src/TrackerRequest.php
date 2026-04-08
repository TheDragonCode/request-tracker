<?php

declare(strict_types=1);

namespace DragonCode\RequestTracker;

use Closure;
use Symfony\Component\HttpFoundation\Request;

use function in_array;
use function is_array;
use function is_int;

class TrackerRequest
{
    public function __construct(
        protected Request $request,
        protected TrackerHeader $header,
    ) {}

    public function userId(int|string|null $id = null): static
    {
        $id ??= $this->getUserId();

        $this->set($this->header->userId, $id);

        return $this;
    }

    public function getUserId(): ?string
    {
        if ($id = $this->get($this->header->userId)) {
            return $id;
        }

        return null;
    }

    public function ip(?string $ip = null): static
    {
        $ip ??= $this->getIp();

        $this->set($this->header->ip, $ip);

        return $this;
    }

    public function getIp(): ?string
    {
        if ($ip = $this->get($this->header->ip)) {
            return $ip;
        }

        return $this->get('HTTP_X_REAL_IP') ?: $this->request->getClientIp();
    }

    public function traceId(?string $id = null): static
    {
        $id ??= $this->getTraceId();

        $this->set($this->header->traceId, $id);

        return $this;
    }

    public function getTraceId(): string
    {
        if ($id = $this->get($this->header->traceId)) {
            return $id;
        }

        return TrackerUuid::get();
    }

    public function custom(string $header, Closure $callback): static
    {
        $value = $this->get($header) ?: $callback($this->getRequest());

        $this->set($header, $value);

        return $this;
    }

    public function getRequest(): Request
    {

        return $this->request;
    }

    protected function set(string $key, array|int|string|null $value): static
    {
        if (! is_int($value) && ! $value) {
            $this->request->headers->remove($key);

            return $this;
        }

        if (is_int($value)) {
            $value = (string) $value;
        }

        $this->request->headers->set($key, $value);

        return $this;
    }

    protected function get(string $key): array|string|null
    {
        return $this->resolve(
            $this->request->headers->get($key)
        );
    }

    protected function resolve(array|int|string|null $value): array|string|null
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_int($value)) {
            return (string) $value;
        }

        if (in_array($value, ['', 'null', '[]', '{}', '-'], true)) {
            return null;
        }

        return $value;
    }
}
