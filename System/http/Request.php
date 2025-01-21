<?php

namespace learnspace\flash\System\http;

class Request
{
    private string $method;
    private string $uri;
    private array $queryParams;
    private array $body;
    private array $headers;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        $this->queryParams = $_GET ?? [];
        $this->body = $_POST ?? [];
        $this->headers = $this->parseHeaders();
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerName = str_replace('_', '-', strtolower(substr($key, 5)));
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getQueryParam(string $key, $default = null)
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function getBodyParam(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }

    public function getHeader(string $key, $default = null)
    {
        $key = strtolower($key);
        return $this->headers[$key] ?? $default;
    }
}