<?php

namespace learnspace\flash\System;

use RuntimeException;

// Initiate all the services and cache it.
class ServiceManager
{
    private array $serviceCache = [];

    public function __construct(private array $dependencies)
    {
    }

    public function instantiate(string $className): mixed
    {
        try {
            // Check if the service is already cached
            if (isset($this->serviceCache[$className])) {
                return $this->serviceCache[$className];
            }

            // Check if a factory is registered for the class
            if (isset($this->dependencies['factories'][$className])) {
                $service = (new $this->dependencies['factories'][$className])($this);
                $this->serviceCache[$className] = $service;
                return $service;
            }

            // Check if a repository is registered for the class
//            if (isset($this->dependencies['repositories'][$className])) {
//                $service = (new $this->dependencies['repositories'][$className])($this);
//                $this->serviceCache[$className] = $service;
//                return $service;
//            }

            // Handle database models
            if (is_subclass_of($className, DatabaseModel::class)) {
                $this->initializeDatabaseConnection($className);
            }

            // Instantiate the class directly
            if (class_exists($className)) {
                $service = new $className();
                $this->serviceCache[$className] = $service;
                return $service;
            }

            // If class does not exist
            throw new RuntimeException("Class '$className' not found.");
        } catch (\Throwable $e) {
            // Simple error output for debugging
            echo "Error: " . $e->getMessage() . "\n";
            echo "Stack trace:\n" . $e->getTraceAsString();
            exit(1); // Stop execution for critical errors
        }
    }

    private function initializeDatabaseConnection(string $className): void
    {
        $dbConnection = DatabaseConnection::getInstance();

        if ($dbConnection === null) {
            throw new RuntimeException("Failed to initialize database connection for '$className'.");
        }

        $className::setConnection($dbConnection);
    }
}
