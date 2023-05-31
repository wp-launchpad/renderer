<?php

namespace LaunchpadRenderer\Cache\Cron;

use LaunchpadRenderer\Dependencies\LaunchpadCore\Container\AbstractServiceProvider;

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
            \LaunchpadRenderer\Cache\Cron\Subscriber::class,
        ];
    }

    /**
     * Registers items with the container
     *
     * @return void
     */
    public function define()
    {
        $this->register_service(\LaunchpadRenderer\Cache\Cron\Subscriber::class);
    }
}
