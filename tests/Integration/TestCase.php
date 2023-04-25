<?php

namespace LaunchpadRenderer\Tests\Integration;

use ReflectionObject;
use WPMedia\PHPUnit\Integration\VirtualFilesystemTestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $config;
    protected static $transients         = [];

    public static function set_up_before_class() {
        parent::set_up_before_class();

        if ( ! empty( self::$transients ) ) {
            foreach ( array_keys( self::$transients ) as $transient ) {
                self::$transients[ $transient ] = get_transient( $transient );
            }
        }
    }

    public static function tear_down_after_class() {
        parent::tear_down_after_class();

        foreach ( self::$transients as $transient => $value ) {
            if ( ! empty( $transient ) ) {
                set_transient( $transient, $value );
            } else {
                delete_transient( $transient );
            }
        }
    }

    public function getPathToFixturesDir()
    {
        return LAUNCHPAD_RENDERER_TESTS_FIXTURES_DIR;
    }

    public function set_up() {
        parent::set_up();

        $this->init();
    }
}
