<?php

namespace LaunchpadRenderer\Configuration;

use DateTime;

class Configurations
{

    const CACHE_PARAMETER_KEY = 'keys';
    const VIEW_PARAMETER_KEY = 'parameters';
    const TTL_KEY = 'ttl';

    /**
     * Parameters to send to the cache key.
     *
     * @var array
     */
    protected $cache_parameters = [];

    /**
     * Parameters to send to the view.
     *
     * @var array
     */
    protected $view_parameters = [];

    /**
     * Expiration from the cache.
     *
     * @var int|DateTime|null
     */
    protected $ttl = -1;

    /**
     * Instantiate the class.
     * @param array $configurations Configurations.
     */
    public function __construct(array $configurations = []) {
        $this->setup_cache_parameters($configurations);
        $this->setup_view_parameters($configurations);
        $this->setup_ttl($configurations);
    }

    /**
     * Get parameters to send to the cache key.
     * @return array
     */
    public function get_cache_parameters(): array {
        return $this->cache_parameters;
    }

    /**
     * Get parameters to send to the view.
     * @return array
     */
    public function get_view_parameters(): array {
        return $this->view_parameters;
    }

    /**
     * Get expiration from the cache.
     * @return int|DateTime|null
     */
    public function get_ttl() {
        return $this->ttl;
    }

    /**
     * Setup parameters to send to the cache key.
     * @param array $configurations Configurations.
     * @return void
     */
    protected function setup_cache_parameters(array $configurations) {
        if( key_exists(self::CACHE_PARAMETER_KEY, $configurations)){
            $this->cache_parameters = $configurations[self::CACHE_PARAMETER_KEY];
            return;
        }

        if(! key_exists(self::VIEW_PARAMETER_KEY, $configurations)){
            return;
        }

        $this->cache_parameters = $configurations[self::VIEW_PARAMETER_KEY];
    }

    /**
     * Setup parameters to send to the view.
     * @param array $configurations Configurations.
     * @return void
     */
    protected function setup_view_parameters(array $configurations) {
        if(! key_exists(self::VIEW_PARAMETER_KEY, $configurations)){
            return;
        }

        $this->view_parameters = $configurations[self::VIEW_PARAMETER_KEY];
    }

    /**
     * Setup expiration from the cache.
     * @param array $configurations Configurations.
     * @return void
     */
    protected function setup_ttl(array $configurations) {
        if(! key_exists(self::TTL_KEY, $configurations)){
            return;
        }

        $this->ttl = $configurations[self::TTL_KEY];
    }
}
