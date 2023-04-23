<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Subscriber;

use LaunchpadRenderer\Tests\Unit\InitializeProperties;
use Mockery;
use LaunchpadRenderer\Subscriber;
use Psr\SimpleCache\CacheInterface;
use LaunchpadRenderer\Renderer\Renderer;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Subscriber::has
 */
class Test_has extends TestCase {

    use InitializeProperties;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var bool
     */
    protected $renderer_cache_enabled;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var Subscriber
     */
    protected $subscriber;

    public function set_up() {
        parent::set_up();
        $this->prefix = '';
        $this->renderer_cache_enabled = false;
        $this->cache = Mockery::mock(CacheInterface::class);
        $this->renderer = Mockery::mock(Renderer::class);

        $this->subscriber = new Subscriber($this->prefix, $this->renderer_cache_enabled, $this->cache, $this->renderer);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->setProperties($this->subscriber, $config['properties']);
        $this->configureCache($config, $expected);
        $this->assertSame($expected['result'], $this->subscriber->has($config['template'], $config['configurations']));
    }

    protected function configureCache( $config, $expected ) {

        if(! $config['renderer_cache_enabled']) {
            return;
        }

        Functions\expect('wp_encode_json')->with($expected['parameters'])->andReturn($config['json']);
        Functions\expect('wp_hash')->with($expected['json'])->andReturn($config['hash']);

        $this->cache->expects()->has($expected['key'])->andReturn($config['has_cache_hit']);
    }
}
