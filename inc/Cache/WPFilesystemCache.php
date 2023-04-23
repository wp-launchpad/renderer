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
     * @param string $prefix
     */
    public function __construct(FilesystemBase $filesystem, string $root_directory, string $prefix)
    {
        $this->filesystem = $filesystem;
        $this->root_directory = $root_directory . DIRECTORY_SEPARATOR . $prefix . wp_hash($prefix) . DIRECTORY_SEPARATOR;
    }

    public function get($key, $default = null)
    {
        $path = $this->transform_key_to_path($key);
        if(! $this->filesystem->exists($path)) {
            return  $default;
        }
        return $this->filesystem->get_contents($path);
    }

    public function set($key, $value, $ttl = null)
    {
        $this->filesystem->put_contents($this->transform_key_to_path($key), $value);
    }

    public function delete($key)
    {
        $this->filesystem->delete($this->transform_key_to_path($key));
    }

    public function clear()
    {
        $this->filesystem->rmdir($this->root_directory, true);
    }

    public function getMultiple($keys, $default = null)
    {
        return array_map(function ($key) use ($default) {
            return $this->get($key, $default);
        }, (array) $keys);
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    public function deleteMultiple($keys)
    {
        $array_keys = (array) $keys;
        array_walk($array_keys, function ($key) {
            $this->delete($key);
        });
    }

    public function has($key)
    {
        return $this->filesystem->exists($this->transform_key_to_path($key));
    }

    protected function transform_key_to_path(string $key): string {
        $path = $this->root_directory . '/' . $key;
        return  str_replace('/', DIRECTORY_SEPARATOR, $path) . '.html';
    }
}