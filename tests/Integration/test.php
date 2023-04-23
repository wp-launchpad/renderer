<?php

use LaunchpadCore\Plugin;
use LaunchpadRenderer\Cache\WPFilesystemCache;
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

    $wp_rocket = new Plugin(
        new Container(),
        new EventManager()
    );

    $wp_rocket->load( [
        'prefix' => '',
        'template_path' => '',
        'root_directory' => '',
        'renderer_cache_enabled' => true,
        'renderer_caching_solution' => WPFilesystemCache::class
    ], [
        \LaunchpadRenderer\ServiceProvider::class
    ] );
} );
