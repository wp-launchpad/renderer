<?php

use LaunchpadCore\Plugin;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadRenderer\ServiceProvider;
use League\Container\Container;
use LaunchpadCore\EventManagement\EventManager;

if ( file_exists( LAUNCHPAD_RENDERER_PLUGIN_ROOT . 'vendor/autoload.php' ) ) {
    require LAUNCHPAD_RENDERER_PLUGIN_ROOT . 'vendor/autoload.php';
}

/**
 * Tell WP what to do when plugin is loaded.
 *
 */
add_action( 'plugins_loaded',  function() {
    // Nothing to do if autosave.
    if ( defined( 'DOING_AUTOSAVE' ) ) {
        return;
    }

    $container = new Container();

    $container = $container->defaultToShared();

    $wp_rocket = new Plugin(
        $container,
        new EventManager()
    );

    $wp_rocket->load( [
        'prefix' => 'prefix_',
        'template_path' => LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR . '/files/templates/',
        'root_directory' => WP_CONTENT_DIR . '/cache/',
        'renderer_cache_enabled' => true,
        'renderer_caching_solution' => [WPFilesystemCache::class]
    ], [
        ServiceProvider::class
    ] );
} );
