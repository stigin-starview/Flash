<?php

declare(strict_types=1);

namespace learnspace\flash\Controller;

use learnspace\flash\Repository\MessageBoxRepository;
use learnspace\flash\System\http\Request;
use learnspace\flash\System\http\Response;
use learnspace\flash\System\Validation;
use learnspace\flash\System\ViewService;

class MessageBoxController implements ViewControllerInterface
{
    private MessageBoxRepository $repository;
    private Request $request;
    private Response $response;

    public function __construct(MessageBoxRepository $repository)
    {
        $this->repository = $repository;
        $this->response = new Response();
        $this->request = new Request();

    }

    public function index(): ViewService
    {

        //TODO: Create a param class to handle all params.

        $errors = [];

        // Handle form submission
        if ($this->request->getMethod() === 'POST') {
            $validation = new Validation();
            $data = $_POST;

            // Use validation
            if ($validation->validate($data, 'stringValid')) {
                // Save the message if validation passes
                $this->repository->saveMessage($data['content']);

                // Redirect to avoid form resubmission
                header("Location: " . $this->request->getUri());
                exit;
            }

            // Capture validation errors if validation fails
            $errors = $validation->errors();
        }

        // Fetch all messages
        $messages = $this->repository->getAllMessages();

        // Use the View helper to render the View
        return new ViewService('messageBoxView', [
            'messages_box' => $messages,
            'errors' => $errors,
        ]);
    }
}
