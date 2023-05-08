<?php

namespace LaunchpadRenderer;

use LaunchpadCore\Container\AbstractServiceProvider;
use LaunchpadFilesystem\WPFilesystemDirect;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use League\Container\Definition\Definition;
use League\Plates\Engine;

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

        $this->register_service(WPFilesystemDirect::class);

        $this->register_service(WPFilesystemCache::class, function (Definition $definition) {
            $definition
                ->addArgument($this->getContainer()->get(WPFilesystemDirect::class))
                ->addArgument($this->getContainer()->get('root_directory'))
                ->addArgument($this->getContainer()->get('prefix'));
        });

        $this->register_service(Engine::class, function (Definition $definition) {
            $definition
                ->addArgument($this->getContainer()->get('template_path'));
        });

        $this->register_service(Subscriber::class, function (Definition $definition) {
            $renderer_caching_solutions = $this->getContainer()->get('renderer_caching_solution') ?: [];
            $renderer_caching_solution = array_pop($renderer_caching_solutions);
            if(! $renderer_caching_solution) {
                $renderer_caching_solution = WPFilesystemCache::class;
            }
            $definition
                ->addArgument($this->getContainer()->get('prefix'))
                ->addArgument($this->getContainer()->get('renderer_cache_enabled'))
                ->addArgument($this->getContainer()->get($renderer_caching_solution))
                ->addArgument($this->getContainer()->get(Engine::class));
        });
    }
}
