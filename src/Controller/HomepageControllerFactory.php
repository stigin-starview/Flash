<?php

declare(strict_types=1);

namespace learnspace\flash\Controller;

use learnspace\flash\System\ImageService;
use learnspace\flash\System\ServiceManager;

// Creating instances of HomepageController
class HomepageControllerFactory
{

    public function __invoke(ServiceManager $serviceManager): HomepageController
    {
        $imageservice = $serviceManager->instantiate(ImageService::class);
        return new HomepageController($imageservice);
    }
}
