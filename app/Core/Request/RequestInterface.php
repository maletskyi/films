<?php

namespace App\Core\Request;

interface RequestInterface
{
    public function getUri(): string;

    public function getMethod(): string;

    public function getBody();

    public function getParsedBody();

    public function getQueryParams();

    public function getFiles();
}