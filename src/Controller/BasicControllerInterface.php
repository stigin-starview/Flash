<?php

namespace learnspace\flash\Controller;

interface BasicControllerInterface
{
    public function index(array $matches): string;
}
