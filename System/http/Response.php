<?php

declare(strict_types=1);

namespace learnspace\flash\System\http;

class Response
{
    private int $status = 200;
    private array $headers = [];
    private string $body = '';

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function send(): void
    {
        // Set the status code
        http_response_code($this->status);

        // Set headers
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }

        // Output the body
        echo $this->body;
    }
}