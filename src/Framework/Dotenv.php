<?php

declare(strict_types=1);

namespace Framework;

class Dotenv
{
    public function load(string $path): void
    {
        if (!file_exists($path)) {
            return; // Silently return if file doesn't exist
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            return; // Silently return if file can't be read
        }

        foreach ($lines as $line) {
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Check if line contains '='
            if (strpos($line, '=') === false) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);

            $_ENV[trim($name)] = trim($value);
        }
    }
}
