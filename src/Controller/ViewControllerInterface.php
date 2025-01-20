<?php

namespace learnspace\flash\Controller;

use learnspace\flash\System\ViewService;

// Add more rules/conditions to follow.
interface ViewControllerInterface
{
    public function index(): ViewService;
}