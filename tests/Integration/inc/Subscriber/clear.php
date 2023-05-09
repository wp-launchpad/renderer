<?php

namespace LaunchpadRenderer\Tests\Integration\inc\Subscriber;

use LaunchpadRenderer\Tests\Integration\TestCase;
use League\Plates\Engine;

/**
 * @covers \LaunchpadRenderer\Subscriber::clear
 */
class Test_clear extends TestCase {

    protected $path_to_test_data = '/inc/Subscriber/integration/clear.php';

    protected $config;

    public function set_up()
    {
        parent::set_up();
        add_filter('prefix_root_path', [$this, 'root_path']);
        $container = apply_filters('prefix_container', null);
        if(! $container) {
            return;
        }
        $container->get(Engine::class)->setDirectory($this->filesystem->getUrl('/templates'));
    }

    public function tear_down()
    {
        remove_filter('prefix_root_path', [$this, 'root_path']);
        parent::tear_down();
    }

    /**
     * @dataProvider providerTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        $this->config = $config;
        foreach ($config['cache'] as $path => $content) {
            $this->filesystem->put_contents($path, $content);
        }
        do_action($config['hook']);
        foreach ($expected['files'] as $path => $file) {
            if($file['exists']) {
                $this->assertTrue($this->filesystem->exists($path));
                $this->assertSame($file['content'], $this->filesystem->get_contents($path));
                continue;
            }

            $this->assertFalse($this->filesystem->exists($path));
        }
    }

    public function root_path() {
        return $this->filesystem->getUrl('/cache');
    }
}
