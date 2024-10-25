<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Subscriber;

use LaunchpadRenderer\Configuration\Configurations;
use LaunchpadRenderer\Configuration\Factory;
use LaunchpadRenderer\Tests\Unit\InitializeProperties;
use League\Plates\Engine;
use Mockery;
use LaunchpadRenderer\Subscriber;
use Psr\SimpleCache\CacheInterface;
use LaunchpadRenderer\Renderer\Renderer;


use LaunchpadRenderer\Tests\Unit\TestCase;
use Brain\Monkey\Functions;

/**
 * @covers \LaunchpadRenderer\Subscriber::render
 */
class Test_render extends TestCase {

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
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->setProperties($this->subscriber, $config['properties']);
        Functions\expect('wp_encode_json')->with($expected['parameters'])->andReturn($config['json']);
        Functions\expect('wp_hash')->with($expected['json'])->andReturn($config['hash']);
        $this->factory->shouldReceive('make')->with($expected['parameters'])->andReturn($this->configurations)->atLeast()->once();
        $this->configurations->shouldReceive('get_cache_parameters')->andReturn($config['cache_parameters'])->atLeast()->once();

        $this->configureCache($config, $expected);
        $this->configureRenderer($config, $expected);
        ob_start();
        $this->subscriber->render($config['template'], $config['configurations']);
        $content = ob_get_clean();
        $this->assertSame($expected['content'], $content);
    }

    protected function configureCache( $config, $expected ) {
        if ( ! $config['renderer_cache_enabled']) {
            return;
        }

        $this->cache->expects()->has($expected['key'])->andReturn($config['has_cache_hit']);

        if ( ! $config['has_cache_hit']) {
            return;
        }

        $this->cache->expects()->get($expected['key'])->andReturn($config['cached_content']);
    }

    protected function configureRenderer( $config, $expected ) {
        if( $config['has_cache_hit']) {
            return;
        }

        $this->configurations->expects()->get_view_parameters()->andReturn($config['view_parameters']);
        $this->renderer->expects()->render($expected['template'], $expected['view_parameters'])->andReturn($config['content']);

        if(! $config['renderer_cache_enabled']) {
            return;
        }

        $this->cache->expects()->set($expected['key'], $config['content']);
    }
}
