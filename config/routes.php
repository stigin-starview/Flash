<?php
use learnspace\flash\Controller\HomepageController;
use learnspace\flash\Controller\NewsDetailController;
use learnspace\flash\Controller\MessageBoxController;

// Add routes here and direct to controllers
return [
    '/homepage/' => HomepageController::class,
    '/^news\/(\d{2,5})\/details$/' => NewsDetailController::class,
    '/message/' => MessageBoxController::class,

];
