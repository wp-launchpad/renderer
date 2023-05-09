<?php
namespace LaunchpadRenderer;

use LaunchpadCore\EventManagement\SubscriberInterface;
use League\Plates\Engine;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Subscriber implements SubscriberInterface {

    /**
     * Hook prefix.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Is the renderer cache activated.
     *
     * @var bool
     */
    protected $renderer_cache_enabled;

    /**
     * Cache instance.
     *
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Renderer instance.
     *
     * @var Engine
     */
    protected $renderer;

    /**
     * Instantiate the class.
     *
     * @param string $prefix Hook prefix.
     * @param bool $renderer_cache_enabled Is the renderer cache activated.
     * @param CacheInterface $cache Cache instance.
     * @param Engine $renderer Renderer instance.
     */
    public function __construct(string $prefix, bool $renderer_cache_enabled, CacheInterface $cache, Engine $renderer)
    {
        $this->prefix = $prefix;
        $this->renderer_cache_enabled = $renderer_cache_enabled;
        $this->cache = $cache;
        $this->renderer = $renderer;
    }

    /**
     * Returns an array of events that this subscriber wants to listen to.
     *
     * @return array
     */
    public function get_subscribed_events() {
        return [
            "{$this->prefix}has_template" => ['has', 10, 2],
            "{$this->prefix}render_template" => ['render', 10 , 2],
            "{$this->prefix}delete_template" => ['delete', 10, 2],
            "{$this->prefix}clean_all_templates" => 'clear',
            'launchpad_clean_all_templates' => 'clear',
        ];
    }

    /**
     * Has cache from a template.
     * @param string $template Name from the template.
     * @param array $configurations Configurations.
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    public function has(string $template, array $configurations = []) {
        if( ! $this->renderer_cache_enabled ) {
            return false;
        }
        $key = $this->create_key($template, $configurations);

        return $this->cache->has($key);
    }

    /**
     * Render a template.
     * @param string $template Name from the template.
     * @param array $configurations Configurations.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function render(string $template, array $configurations = []) {
        $key = $this->create_key($template, $configurations);

        if( $this->has($template, $configurations) ) {
            echo $this->cache->get($key);
            return;
        }

        $content = $this->renderer->render($template, $configurations);

        if( $this->renderer_cache_enabled ) {
            $this->cache->set($key, $content);
        }

        echo $content;
    }

    /**
     * Delete cache from a template.
     *
     * @param string $template Name from the template.
     * @param array $configurations Configurations.
     * @return void
     */
    public function delete(string $template, array $configurations = []) {
        $key = $this->create_key($template, $configurations);
        try {
            $this->cache->delete($key);
        } catch (InvalidArgumentException $e) {}
    }

    /**
     * Delete all templates cache.
     *
     * @return void
     */
    public function clear() {
        $this->cache->clear();
    }

    /**
     * Transform parameters into a hash.
     * @param array $parameters parameters to use.
     * @return string
     */
    protected function transform_parameters_into_hash(array $parameters) {
        $json = wp_json_encode($parameters);
        return md5($json);
    }

    /**
     * Create a key from the view and its parameters.
     *
     * @param string $template Name from the template.
     * @param array $parameters parameters to use.
     * @return string
     */
    protected function create_key(string $template, array $parameters) {
        return $template . '-' . $this->transform_parameters_into_hash($parameters);
    }
}
