<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Cache\WPFilesystemCache;

use Mockery;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadFilesystem\FilesystemBase;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Cache\WPFilesystemCache::setMultiple
 */
class Test_setMultiple extends TestCase {

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

        $this->wpfilesystemcache = Mockery::mock(WPFilesystemCache::class. '[set]', [$this->filesystem, $this->root_directory, $this->prefix]);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        foreach ($expected['values'] as $key => $value) {
            $this->wpfilesystemcache->expects()->set($key, $value, $expected['ttl']);
        }
        $this->wpfilesystemcache->setMultiple($config['values'], $config['ttl']);
    }
}
