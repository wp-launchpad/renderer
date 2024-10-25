<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Cache\WPFilesystemCache;

use Mockery;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadFilesystem\FilesystemBase;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Cache\WPFilesystemCache::deleteMultiple
 */
class Test_deleteMultiple extends TestCase {

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
        Functions\when('wp_hash')->justReturn('hash');

        $this->wpfilesystemcache = Mockery::mock( WPFilesystemCache::class . '[delete]', [$this->filesystem, $this->root_directory, $this->prefix]);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        foreach ($expected as $key) {
            $this->wpfilesystemcache->expects()->delete($key);
        }
        $this->wpfilesystemcache->deleteMultiple($config['values']);
    }
}
