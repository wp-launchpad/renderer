<?php

namespace LaunchpadRenderer\Cache;

use DateInterval;
use LaunchpadFilesystem\FilesystemBase;
use Psr\SimpleCache\CacheInterface;

class WPFilesystemCache implements CacheInterface
{

    /**
     * @var FilesystemBase
     */
    protected $filesystem;

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value, ?DateInterval $ttl = null): bool
    {
        // TODO: Implement set() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        // TODO: Implement clear() method.
    }

    /**
     * @inheritDoc
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        // TODO: Implement getMultiple() method.
    }

    /**
     * @inheritDoc
     */
    public function setMultiple(iterable $values, ?DateInterval $ttl = null): bool
    {
        // TODO: Implement setMultiple() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(iterable $keys): bool
    {
        // TODO: Implement deleteMultiple() method.
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        // TODO: Implement has() method.
    }
}