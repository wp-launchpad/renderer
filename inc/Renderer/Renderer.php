<?php

namespace LaunchpadRenderer\Renderer;

use LaunchpadFilesystem\FilesystemBase;

class Renderer
{
    /**
     * @var string
     */
    protected $root_directory;

    /**
     * @param string $root_directory
     */
    public function __construct(FilesystemBase $filesystem, string $root_directory)
    {
        $this->root_directory = $root_directory;
    }

    public function render(string $template, array $parameters = []): string {
        foreach ($parameters as $key => $value) {
            $$key = $value;
        }
        return require_once $this->root_directory . '/' . $template . '.php';

    }
}