<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Cache\WPFilesystemCache;

use Mockery;
use LaunchpadRenderer\Cache\WPFilesystemCache;
use LaunchpadFilesystem\FilesystemBase;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Cache\WPFilesystemCache::getMultiple
 */
class Test_getMultiple extends TestCase {

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

        $this->wpfilesystemcache = Mockery::mock(WPFilesystemCache::class . '[get]', [$this->filesystem, $this->root_directory, $this->prefix]);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        foreach ($expected['values'] as $key => $value) {
            $this->wpfilesystemcache->expects()->get($key, $expected['default'])->andReturn($value);
        }

        $this->assertSame($expected['results'], $this->wpfilesystemcache->getMultiple($config['values'], $config['default']));
    }
}
