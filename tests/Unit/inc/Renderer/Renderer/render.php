<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Renderer\Renderer;

use Mockery;
use LaunchpadRenderer\Renderer\Renderer;
use LaunchpadFilesystem\FilesystemBase;


use LaunchpadRenderer\Tests\Unit\TestCase;

/**
 * @covers \LaunchpadRenderer\Renderer\Renderer::render
 */
class Test_render extends TestCase {

    /**
     * @var FilesystemBase
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $root_directory;

    /**
     * @var Renderer
     */
    protected $renderer;

    public function set_up() {
        parent::set_up();
        $this->filesystem = Mockery::mock(FilesystemBase::class);
        $this->root_directory = '';

        $this->renderer = new Renderer($this->filesystem, $this->root_directory);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->assertSame($expected, $this->renderer->render($config['template'], $config['parameters']));
    }
}
