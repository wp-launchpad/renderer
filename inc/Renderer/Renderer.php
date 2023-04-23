<?php

namespace LaunchpadRenderer\Renderer;

class Renderer
{
    /**
     * @var string
     */
    protected $root_directory;

    /**
     * @param string $root_directory
     */
    public function __construct(string $root_directory)
    {
        $this->root_directory = $root_directory;
    }

    public function render(string $template, array $parameters = []): string {
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include $this->root_directory . '/' . $template . '.php';
        return ob_get_clean();
    }
}