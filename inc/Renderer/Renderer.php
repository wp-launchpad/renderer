<?php

namespace LaunchpadRenderer\Renderer;

class Renderer
{
    /**
     * Templates root directory.
     *
     * @var string
     */
    protected $root_directory;

    /**
     * Instantiate the renderer.
     *
     * @param string $root_directory Templates root directory.
     */
    public function __construct(string $root_directory)
    {
        $this->root_directory = $root_directory;
    }

    /**
     * Render a template.
     *
     * @param string $template Template to render.
     * @param array $parameters Parameters to pass to the renderer.
     *
     * @return string
     */
    public function render(string $template, array $parameters = []): string {
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include $this->root_directory . '/' . $template . '.php';
        return ob_get_clean();
    }
}