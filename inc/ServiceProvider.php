<?php

namespace LaunchpadRenderer;

use LaunchpadCore\Container\AbstractServiceProvider;
use LaunchpadFilesystem\WPFilesystemDirect;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadRenderer\Renderer\Renderer;
use League\Container\Definition\Definition;

/**
 * Service provider.
 */
class ServiceProvider extends AbstractServiceProvider
{

    /**
     * Return IDs from common subscribers.
     *
     * @return string[]
     */
    public function get_common_subscribers(): array {
        return [
            Subscriber::class,
        ];
    }

    /**
     * Registers items with the container
     *
     * @return void
     */
    public function define()
    {

        $this->register_service(WPFilesystemCache::class, function (Definition $definition) {
            $definition
                ->addArgument(WPFilesystemDirect::class);
        });

        $this->register_service(Renderer::class, function (Definition $definition) {
            $definition
                ->addArgument($this->getContainer()->get('template_path'));
        });

        $this->register_service(Subscriber::class, function (Definition $definition) {
            $definition
                ->addArgument($this->getContainer()->get('prefix'))
                ->addArgument($this->getContainer()->get('renderer_cache_enabled'))
                ->addArgument($this->getContainer()->get('renderer_caching_solution'))
                ->addArgument($this->getContainer()->get(Renderer::class));
        });
    }
}