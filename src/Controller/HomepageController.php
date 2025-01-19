<?php

declare(strict_types=1);

namespace learnspace\flash\Controller;


use learnspace\flash\System\ImageService;

class HomepageController implements BasicControllerInterface
{
    public function __construct(private ImageService $imageService)
    {
    }

    public function index(array $matches): string
    {
        return 'Welcome - ' . $this->imageService->getMe();
    }
}
