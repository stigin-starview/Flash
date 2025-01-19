<?php

declare(strict_types=1);

namespace learnspace\flash\Controller;

use learnspace\flash\Repository\MessageBoxRepository;
use learnspace\flash\System\ViewService;
use learnspace\flash\System\Validation;

class MessageBoxController implements ViewControllerInterface
{
    private MessageBoxRepository $repository;

    public function __construct(MessageBoxRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): ViewService
    {

//        $parameters = $this->params() ---- handle any parameters??
        //TODO: Create a param class to handle all params.

        $errors = [];

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validation = new Validation();
            $data = $_POST;

            // Use validation
            if ($validation->validate($data, 'stringValid')) {
                // Save the message if validation passes
                $this->repository->saveMessage($data['content']);

                // Redirect to avoid form resubmission
                header("Location: " . $_SERVER['REQUEST_URI']);
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
