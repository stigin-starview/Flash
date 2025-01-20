<?php

declare(strict_types=1);

namespace learnspace\flash\Tests\Controller;

use learnspace\flash\Controller\MessageBoxController;
use learnspace\flash\Repository\MessageBoxRepository;
use learnspace\flash\System\Validation;
use learnspace\flash\System\ViewService;
use PHPUnit\Framework\TestCase;

class MessageBoxControllerTest extends TestCase
{
    private MessageBoxController $controller;
    private $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(MessageBoxRepository::class);
        $this->controller = new MessageBoxController($this->repositoryMock);
    }

    public function testIndexWithGetRequest(): void
    {
        // Simulate GET request
        $_SERVER['REQUEST_METHOD'] = 'GET';

        // Mock repository to return some messages
        $this->repositoryMock->expects($this->once())
            ->method('getAllMessages')
            ->willReturn(['Message 1', 'Message 2']);

        $viewService = $this->controller->index();

        $this->assertInstanceOf(ViewService::class, $viewService);
        $this->assertEquals('messageBoxView', $viewService->getViewName());
        $this->assertEquals(['Message 1', 'Message 2'], $viewService->getData()['messages_box']);
        $this->assertEmpty($viewService->getData()['errors']);
    }

    public function testIndexWithPostRequestAndValidData(): void
    {
        // Simulate POST request with valid data
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['content' => 'Valid Message'];

        // Mock validation to return true
        $validationMock = $this->createMock(Validation::class);
        $validationMock->expects($this->once())
            ->method('validate')
            ->with(['content' => 'Valid Message'], 'stringValid')
            ->willReturn(true);

        // Mock repository to save the message
        $this->repositoryMock->expects($this->once())
            ->method('saveMessage')
            ->with('Valid Message');

        // Replace header function to prevent redirection
        $this->expectOutputString('');
        $this->controller->index();
    }

    public function testIndexWithPostRequestAndInvalidData(): void
    {
        // Simulate POST request with invalid data
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['content' => ''];

        // Mock validation to return false and provide errors
        $validationMock = $this->createMock(Validation::class);
        $validationMock->expects($this->once())
            ->method('validate')
            ->with(['content' => ''], 'stringValid')
            ->willReturn(false);

        $validationMock->expects($this->once())
            ->method('errors')
            ->willReturn(['content' => 'Content cannot be empty']);

        $viewService = $this->controller->index();

        $this->assertInstanceOf(ViewService::class, $viewService);
        $this->assertEquals('messageBoxView', $viewService->getViewName());
        $this->assertEquals(['content' => 'Content cannot be empty'], $viewService->getData()['errors']);
    }
}
