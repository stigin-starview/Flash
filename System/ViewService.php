<?php

declare(strict_types=1);

/**
 * Reusable View class
 * This will make the controller cleaner
 */
namespace learnspace\flash\System;

class ViewService
{
    private string $view;
    private array $data;

    // Constructor to accept the View name and data
    public function __construct(string $view, array $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    // Instance method to render the View
    public function render(): string
    {
        // Extract data to variables for use in the View
        extract($this->data);

        // Build the full path to the View
        $viewPath = __DIR__ . '/../src/View/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("File not found: " . $viewPath);
        }

        // Start output buffering
        ob_start();

        // Include the View file
        include $viewPath;

        // Get the buffered content as a string
        return ob_get_clean();
    }
}