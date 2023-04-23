<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Cache\WPFilesystemCache;

use Mockery;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadFilesystem\FilesystemBase;


use LaunchpadRenderer\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadRenderer\Cache\WPFilesystemCache::delete
 */
class Test_delete extends TestCase {

    /**
     * @var FilesystemBase
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $root_directory;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var WPFilesystemCache
     */
    protected $wpfilesystemcache;

    public function set_up() {
        parent::set_up();
        $this->filesystem = Mockery::mock(FilesystemBase::class);
        $this->root_directory = '';
        $this->prefix = '';

        $this->wpfilesystemcache = new WPFilesystemCache($this->filesystem, $this->root_directory, $this->prefix);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config )
    {
        $this->wpfilesystemcache->delete();

    }
}
