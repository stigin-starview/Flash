<?php

namespace learnspace\flash\System;

/**
 * This class will load data from .env file.
 */

class EnvLoader
{
    public static function load(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("Environment file not found at $filePath");
        }

        // Read file line by line
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Ignore comments (lines starting with # or ;)
            if (strpos($line, '#') === 0 || strpos($line, ';') === 0) {
                continue;
            }

            // Split the line into key-value pair
            list($key, $value) = explode('=', $line, 2);

            // Trim spaces around the key and value
            $key = trim($key);
            $value = trim($value);

            // Add to the $_ENV superglobal
            $_ENV[$key] = $value;
        }
    }

}