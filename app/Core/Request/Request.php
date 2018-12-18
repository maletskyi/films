<?php

namespace App\Core\Request;

class Request implements RequestInterface
{
    private $attributes;

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttribute($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function getParsedBody()
    {
        return $_POST ?: null;
    }

    public function getBody()
    {
        return file_get_contents('php://input');
    }

    public function getFiles()
    {
        return $_FILES;
    }
}