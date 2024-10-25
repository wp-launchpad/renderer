<?php

namespace LaunchpadRenderer\Tests\Unit;

use ReflectionObject;
use WPMedia\PHPUnit\Unit\VirtualFilesystemTestCase;

abstract class FilesystemTestCase extends VirtualFilesystemTestCase
{
    protected $config;

    protected function set_up() {
        parent::set_up();

        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }

        $this->init();
    }

    public function configTestData() {
        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }

        return isset( $this->config['test_data'] )
            ? $this->config['test_data']
            : $this->config;
    }

    protected function loadTestDataConfig() {
        $obj      = new ReflectionObject( $this );
        $filename = $obj->getFileName();

        $this->config = $this->getTestData( dirname( $filename ), basename( $filename, '.php' ) );
    }
}