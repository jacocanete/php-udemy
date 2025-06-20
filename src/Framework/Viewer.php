<?php

declare(strict_types=1);

namespace Framework;

/**
 * Handles rendering of view templates.
 */
class Viewer
{
    /**
     * Renders a PHP template file with optional data.
     *
     * @param string $template The template file path relative to the views directory.
     * @param array $data Optional associative array of data to extract into the template.
     * @return string The rendered template output.
     */
    public function render(string $template, array $data = array()): string
    {
        extract($data, EXTR_SKIP);

        ob_start();

        require "views/$template";

        return ob_get_clean();
    }
}
