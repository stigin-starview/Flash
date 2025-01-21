<?php

declare(strict_types=1);

include __DIR__ . '/../vendor/autoload.php';

use learnspace\flash\Controller\BasicControllerInterface;
use learnspace\flash\Controller\ViewControllerInterface;
use learnspace\flash\System\EnvLoader;
use learnspace\flash\System\ServiceManager;
use learnspace\flash\System\ViewService;
use learnspace\flash\System\http\Response;
use learnspace\flash\System\http\Request;

// implement request and response classes
$response = new Response();
$request = new Request();

// Sanitize the path
$requestedPath = htmlspecialchars($_GET['path'] ?? 'homepage');

// Load .env file
try {
    EnvLoader::load(__DIR__ . '/../.env');
} catch (Exception $e) {
    echo $e->getMessage();
}

// Loading routers
$routes = include __DIR__ . "/../config/Routes.php";
$matches = [];
$foundedController = null;
foreach ($routes as $regex => $controller) {
    if (preg_match($regex, $requestedPath, $matches)) {
        $foundedController = $controller;
        break;
    }
}

if (!$foundedController) {
    $response->setStatus(404);
    $response->setBody("Controller not found");
    $response->send();
    die;
}

// Loads dependencies through service manager
$dependencies = include __DIR__ . "/../config/dependencies.php";
$serviceManager = new ServiceManager($dependencies);
$controllerObject = $serviceManager->instantiate($foundedController);

// load called interface
if ($controllerObject instanceof BasicControllerInterface) {
    echo $controllerObject->index($matches);
    die;
}

if ($controllerObject instanceof ViewControllerInterface) {
    $viewService = $controllerObject->index();

    if ($viewService instanceof ViewService) {
        try {
            echo $viewService->render();
        } catch (Exception $e) {
            $response->setStatus(404);
            $response->setBody("Error rendering view");
            $response->send();
        }
    } else {
        $response->setStatus(500);
        $response->setBody("Invalid ViewService returned by ViewControllerInterface.");
        $response->send();
    }
    die;
}

$response->setStatus(404);
$response->setBody("Controller Error or invalid");
$response->send();
die;

