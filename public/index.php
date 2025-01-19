<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use learnspace\flash\Controller\BasicControllerInterface;
use learnspace\flash\Controller\ViewControllerInterface;
use learnspace\flash\System\EnvLoader;
use learnspace\flash\System\ServiceManager;
use learnspace\flash\System\ViewService;

// Sanitize the path
$requestedPath = htmlspecialchars($_GET['path'] ?? 'homepage');

// Load .env file
try {
    EnvLoader::load(__DIR__ . '/../.env');
} catch (Exception $e) {
    echo $e->getMessage();
}

// Routers
$routes = include __DIR__ . "/../Config/Routes.php";
$matches = [];
$foundedController = null;
foreach ($routes as $regex => $controller) {
    if (preg_match($regex, $requestedPath, $matches)) {
        $foundedController = $controller;
        break;
    }
}

if (!$foundedController) {
    http_response_code(404);
    echo "Controller not found";
    die;
}

// Service manager
$dependencies = include __DIR__ . "/../Config/dependencies.php";
$serviceManager = new ServiceManager($dependencies);
$controllerObject = $serviceManager->instantiate($foundedController);

// Application
if ($controllerObject instanceof BasicControllerInterface) {
    echo $controllerObject->index($matches);
    die;
}

if ($controllerObject instanceof ViewControllerInterface) {
    $viewService = $controllerObject->index();

    if ($viewService instanceof ViewService) {
        echo $viewService->render(); // Render the View
    } else {
        http_response_code(500);
        echo "Invalid ViewService returned by ViewControllerInterface.";
    }
    die;
}

// Fallback for invalid or unknown controllers
http_response_code(404);
echo "Controller not found or invalid.";
die;

