<?php
namespace LaunchpadRenderer;

use LaunchpadCore\EventManagement\SubscriberInterface;
use LaunchpadRenderer\Renderer\Renderer;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Subscriber implements SubscriberInterface {

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var bool
     */
    protected $renderer_cache_enabled;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @param string $prefix
     * @param bool $renderer_cache_enabled
     */
    public function __construct(string $prefix, bool $renderer_cache_enabled, CacheInterface $cache, Renderer $renderer)
    {
        $this->prefix = $prefix;
        $this->renderer_cache_enabled = $renderer_cache_enabled;
        $this->cache = $cache;
        $this->renderer = $renderer;
    }

    /**
     * Returns an array of events that this subscriber wants to listen to.
     *
     * The array key is the event name. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('hook_name' => 'method_name')
     *  * array('hook_name' => array('method_name', $priority))
     *  * array('hook_name' => array('method_name', $priority, $accepted_args))
     *  * array('hook_name' => array(array('method_name_1', $priority_1, $accepted_args_1)), array('method_name_2', $priority_2, $accepted_args_2)))
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


    public function has(string $template, array $configurations = []) {
        if( ! $this->renderer_cache_enabled ) {
            return false;
        }
        $key = $this->create_key($template, $configurations);

        return $this->cache->has($key);
    }

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

    public function delete(string $template, array $configurations = []) {
        $key = $this->create_key($template, $configurations);
        try {
            $this->cache->delete($key);
        } catch (InvalidArgumentException $e) {}
    }

    public function clear() {
        $this->cache->clear();
    }

    protected function transform_parameters_into_hash(array $parameters) {
        $json = wp_json_encode($parameters);
        return md5($json);
    }

    protected function create_key(string $template, array $parameters) {
        return $template . '-' . $this->transform_parameters_into_hash($parameters);
    }
}
