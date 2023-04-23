<?php

namespace LaunchpadRenderer\Cache;

use DateInterval;
use LaunchpadFilesystem\FilesystemBase;
use Psr\SimpleCache\CacheInterface;

class WPFilesystemCache implements CacheInterface
{

    /**
     * WordPress filesystem.
     *
     * @var FilesystemBase
     */
    protected $filesystem;

    /**
     * Root directory from the cache
     * @var string
     */
    protected $root_directory;

    /**
     * @param FilesystemBase $filesystem
     * @param string $root_directory
     */
    public function __construct(FilesystemBase $filesystem, string $root_directory)
    {
        $this->filesystem = $filesystem;
        $this->root_directory = $root_directory;
    }

    public function get($key, $default = null)
    {
        // TODO: Implement get() method.
    }

    public function set($key, $value, $ttl = null)
    {
        // TODO: Implement set() method.
    }

    public function delete($key)
    {
        // TODO: Implement delete() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    public function setMultiple($values, $ttl = null)
    {
        // TODO: Implement setMultiple() method.
    }

    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

    public function has($key)
    {
        // TODO: Implement has() method.
    }

    protected function transform_key_to_path(string $key): string {

    }
}