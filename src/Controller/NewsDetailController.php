<?php

declare(strict_types=1);

namespace learnspace\flash\Controller;

class NewsDetailController implements BasicControllerInterface
{
    public function index(array $matches): string
    {
        return 'Example Controller' . $matches[1];
    }
}
