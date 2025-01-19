<?php

namespace learnspace\flash\Controller;

use learnspace\flash\System\ViewService;

interface ViewControllerInterface
{
    public function index(): ViewService;
}