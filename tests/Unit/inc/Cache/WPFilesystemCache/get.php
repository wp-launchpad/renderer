<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Cache\WPFilesystemCache;

use LaunchpadRenderer\Tests\Unit\InitializeProperties;
use Mockery;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadFilesystem\FilesystemBase;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Cache\WPFilesystemCache::get
 */
class Test_get extends TestCase {

    use InitializeProperties;

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

        $this->wpfilesystemcache = new WPFilesystemCache($this->filesystem, $this->root_directory, $this->prefix);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->setProperties($this->wpfilesystemcache, $config['properties']);
        $this->filesystem->expects()->exists($expected['path'])->andReturn($config['exists']);
        $this->configureFetchData($config, $expected);
        $this->assertSame($expected['result'], $this->wpfilesystemcache->get($config['key'], $config['default']));
    }

    protected function configureFetchData($config, $expected) {
        if(! $config['exists']) {
            return;
        }

        $this->filesystem->expects()->get_contents($expected['path'])->andReturn($config['content']);
    }
}
