<?php

namespace App\Core\Routing;

class Route
{
    private $pattern;
    private $methods = [];
    private $attributes = [];
    private $name;

    public function __construct($pattern, $methods, $name, $handler)
    {
        $this->pattern = $pattern;
        $this->methods = $methods;
        $this->name    = $name;
        $this->handler = $handler;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}