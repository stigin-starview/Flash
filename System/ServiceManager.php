<?php

namespace learnspace\flash\System;

class ServiceManager
{
    public function __construct(private array $dependencies)
    {
    }

    public function instantiate(string $className): mixed
    {
        // TODO: add try catch
        if (isset($this->dependencies['factories'][$className])) {
            return (new $this->dependencies['factories'][$className])($this);
        }
        if (isset($this->dependencies['repositories'][$className])) {
            return (new $this->dependencies['repositories'][$className])($this);
        }
        // Initialize Database Connection for Database Models
        if (is_subclass_of($className, DatabaseModel::class)) {
            $dbConnection = DatabaseConnection::getInstance();
            // TODO: Handle null pointer exception
            DatabaseModel::setConnection($dbConnection);
        }

//        // If no factory is found, just instantiate the class
        return new $className();
    }
}
