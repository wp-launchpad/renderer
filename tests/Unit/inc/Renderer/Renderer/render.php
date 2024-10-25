<?php

namespace LaunchpadRenderer\Tests\Unit\inc\Renderer\Renderer;

use LaunchpadRenderer\Tests\Unit\FilesystemTestCase;
use League\Plates\Engine;
use Mockery;
use LaunchpadRenderer\Renderer\Renderer;
use LaunchpadFilesystem\FilesystemBase;

/**
 * @covers \LaunchpadRenderer\Renderer\Renderer::render
 */
class Test_render extends FilesystemTestCase {

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
        $this->root_directory = $this->rootVirtualUrl;

        $this->renderer = new Engine($this->root_directory);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->assertSame($this->format_the_html($expected), $this->format_the_html($this->renderer->render($config['template'], $config['parameters'])));
    }
}
