<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Subscriber;

use League\Plates\Engine;
use Mockery;
use LaunchpadRenderer\Subscriber;
use Psr\SimpleCache\CacheInterface;
use LaunchpadRenderer\Renderer\Renderer;


use LaunchpadRenderer\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadRenderer\Subscriber::clear
 */
class Test_clear extends TestCase {

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
        $this->renderer = Mockery::mock(Engine::class);

        $this->subscriber = new Subscriber($this->prefix, $this->renderer_cache_enabled, $this->cache, $this->renderer);
    }

    public function testShouldDoAsExpected()
    {
        $this->cache->expects()->clear();
        $this->subscriber->clear();

    }
}
