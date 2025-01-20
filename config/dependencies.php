<?php

use learnspace\flash\Controller\HomepageController;
use learnspace\flash\Controller\HomepageControllerFactory;
use learnspace\flash\Controller\MessageBoxFactory;
use learnspace\flash\Controller\MessageBoxController;

// Dependency injection
return [
    'factories' => [
        HomepageController::class => HomepageControllerFactory::class,
        MessageBoxController::class => MessageBoxFactory::class,
    ],
];
