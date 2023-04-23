<?php

namespace LaunchpadRenderer\Tests\Integration;

define('LAUNCHPAD_RENDERER_PLUGIN_ROOT', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
define('LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR', dirname(__DIR__) . '/Fixtures');
define('LAUNCHPAD_RENDERER_TESTS_DIR', __DIR__);
define('LAUNCHPAD_RENDERER_IS_TESTING', true);

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function () {
        // Load the plugin.
        require __DIR__ . '/test.php';
    }
);
