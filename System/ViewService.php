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

    public function __construct(string $view, array $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    // Instance method to render the View
    public function render(): string
    {
        // Extract data to variable forr use in the View
        extract($this->data);

        //path of the view
        $viewPath = __DIR__ . '/../src/View/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("File not found: " . $viewPath);
        }

        // Start output buffering
        ob_start();

        // Include the View file
        include $viewPath;

        // Get the buffered content
        return ob_get_clean();
    }
}