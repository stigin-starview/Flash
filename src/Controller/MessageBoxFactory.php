<?php

namespace learnspace\flash\Controller;

use learnspace\flash\Repository\MessageBoxRepository;
use learnspace\flash\System\ServiceManager;

class MessageBoxFactory
{
    public function __invoke(ServiceManager $serviceManager)
    {
        // Get the MessageBoxRepository instance from the ServiceManager
        $repository = $serviceManager->instantiate(MessageBoxRepository::class);

        // Return the controller instance, passing the repository as a dependency
        return new MessageBoxController($repository);
    }
}