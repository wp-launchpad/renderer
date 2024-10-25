<?php

namespace LaunchpadRenderer\Cache;

use DateTime;
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
     * Root directory from the cache.
     * @var string
     */
    protected $root_directory;

    /**
     * Hook prefix.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Instantiate class.
     * @param FilesystemBase $filesystem WordPress filesystem.
     * @param string $root_directory Root directory from the cache.
     * @param string $prefix Hook prefix.
     */
    public function __construct(FilesystemBase $filesystem, string $root_directory, string $prefix)
    {
        $this->filesystem = $filesystem;
        $this->root_directory = $root_directory . DIRECTORY_SEPARATOR . $prefix . wp_hash($prefix) . DIRECTORY_SEPARATOR;
        $this->prefix = $prefix;
    }

    /**
     * Get the value from the cache.
     * @param string $key key from the value.
     * @param mixed $default Default value.
     * @return false|mixed|string|null
     */
    public function get($key, $default = null)
    {
        $path = $this->transform_key_to_path($key);
        if(! $this->filesystem->exists($path)) {
            return $default;
        }
        return $this->filesystem->get_contents($path);
    }

    /**
     * Save a value.
     *
     * @param string $key Key from the value.
     * @param mixed $value Value to save.
     * @param DateTime|int|null $ttl Expiration date.
     * @return void
     */
    public function set($key, $value, $ttl = null)
    {
        $path = $this->transform_key_to_path($key);
        $directory = dirname($path);
        $this->filesystem->recursive_mkdir($directory);
        $this->filesystem->put_contents($path, $value);
    }

    /**
     * Delete a key.
     * @param string $key Key to delete.
     * @return void
     */
    public function delete($key)
    {
        $this->filesystem->delete($this->transform_key_to_path($key));
    }

    /**
     * Clear the cache.
     *
     * @return void
     */
    public function clear()
    {
        $this->filesystem->delete($this->get_root(), true);
    }

    /**
     * Get multiple values.
     * @param string[] $keys key from the value.
     * @param mixed $default Default value.
     * @return array
     */
    public function getMultiple($keys, $default = null)
    {
        $output = [];
        foreach ($keys as $key) {
            $output[$key] = $this->get($key, $default);
        }
        return $output;
    }

    /**
     * Set multiple values.
     *
     * @param array<string,mixed> $values Value to save.
     * @param DateTime|int|null $ttl Expiration date.
     * @return void
     */
    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    /**
     * Delete multiple keys.
     *
     * @param string[] $keys Keys to delete.
     * @return void
     */
    public function deleteMultiple($keys)
    {
        $array_keys = (array) $keys;
        array_walk($array_keys, function ($key) {
            $this->delete($key);
        });
    }

    /**
     * Has a key.
     * @param string $key Key to check.
     * @return bool
     */
    public function has($key)
    {
        return $this->filesystem->exists($this->transform_key_to_path($key));
    }

    /**
     * Transform the key to a path to save.
     *
     * @param string $key key used.
     * @return string
     */
    protected function transform_key_to_path(string $key): string {
        $path = apply_filters("{$this->prefix}root_path", $this->root_directory . '/' ) . $key;
        return  str_replace('/', DIRECTORY_SEPARATOR, $path) . '.html';
    }

    /**
     * Get root path from the cache.
     * @return string
     */
    protected function get_root(): string {
        $path = apply_filters("{$this->prefix}root_path", $this->root_directory . '/' );
        return  str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
