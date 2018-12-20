<?php

namespace App\Core\Routing;

use App\Core\Request\RequestInterface;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private $routes;
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function get($pattern, $name, $handler): void
    {
        $this->addRoute($pattern, ['GET'], $name, $handler);
    }

    public function post($pattern, $name, $handler): void
    {
        $this->addRoute($pattern, ['POST'], $name, $handler);
    }

    public function addRoute($pattern, $methods, $name, $handler): void
    {
        $pattern        = '/^' . str_replace('/', '\/', $pattern) . '$/';
        $this->routes[] = new Route($pattern, $methods, $name, $handler);
    }

    public function match(): Route
    {
        foreach ($this->routes as $route) {
            if (preg_match($route->getPattern(), $this->request->getUri(), $matches)
                && in_array($this->request->getMethod(), $route->getMethods(), true)) {

                $route->setAttributes($matches);

                return $route;
            }
        }

        throw new RouteNotFoundException('Can\'t find route');
    }
}