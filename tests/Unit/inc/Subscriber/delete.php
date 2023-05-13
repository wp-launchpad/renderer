<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Subscriber;

use LaunchpadRenderer\Configuration\Configurations;
use LaunchpadRenderer\Configuration\Factory;
use League\Plates\Engine;
use Mockery;
use LaunchpadRenderer\Subscriber;
use Psr\SimpleCache\CacheInterface;
use LaunchpadRenderer\Renderer\Renderer;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Subscriber::delete
 */
class Test_delete extends TestCase {

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

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var Configurations
     */
    protected $configurations;

    public function set_up() {
        parent::set_up();
        $this->prefix = '';
        $this->renderer_cache_enabled = false;
        $this->cache = Mockery::mock(CacheInterface::class);
        $this->renderer = Mockery::mock(Engine::class);
        $this->factory = Mockery::mock(Factory::class);
        $this->configurations = Mockery::mock(Configurations::class);

        $this->subscriber = new Subscriber($this->prefix, $this->renderer_cache_enabled, $this->cache, $this->renderer, $this->factory);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        Functions\expect('wp_encode_json')->with($expected['parameters'])->andReturn($config['json']);
        Functions\expect('wp_hash')->with($expected['json'])->andReturn($config['hash']);
        $this->cache->expects()->delete($expected['key']);
        $this->factory->expects()->make($expected['parameters'])->andReturn($this->configurations);
        $this->configurations->expects()->get_cache_parameters()->andReturn($config['cache_parameters']);
        $this->subscriber->delete($config['template'], $config['configurations']);
    }
}
