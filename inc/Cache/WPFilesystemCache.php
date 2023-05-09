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
     * @var string
     */
    protected $prefix;

    /**
     * @param FilesystemBase $filesystem
     * @param string $root_directory
     * @param string $prefix
     */
    public function __construct(FilesystemBase $filesystem, string $root_directory, string $prefix)
    {
        $this->filesystem = $filesystem;
        $this->root_directory = $root_directory . DIRECTORY_SEPARATOR . $prefix . wp_hash($prefix) . DIRECTORY_SEPARATOR;
        $this->prefix = $prefix;
    }

    public function get($key, $default = null)
    {
        $path = $this->transform_key_to_path($key);
        if(! $this->filesystem->exists($path)) {
            return $default;
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
        $this->filesystem->delete($this->get_root(), true);
    }

    public function getMultiple($keys, $default = null)
    {
        $output = [];
        foreach ($keys as $key) {
            $output[$key] = $this->get($key, $default);
        }
        return $output;
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
        $path = apply_filters("{$this->prefix}root_path", $this->root_directory . '/' ) . $key;
        return  str_replace('/', DIRECTORY_SEPARATOR, $path) . '.html';
    }

    protected function get_root(): string {
        $path = apply_filters("{$this->prefix}root_path", $this->root_directory . '/' );
        return  str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
