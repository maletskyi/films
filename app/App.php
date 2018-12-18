<?php

namespace App;

use App\Core\Request\Request;
use App\Core\Routing\Router;
use Closure;
use App\Core\DependencyInjection\Container;
use RuntimeException;

class App
{
    public function bootstrap(): void
    {
        $request = new Request();

        $router = new Router($request);

        require dirname(__DIR__) . '/routes.php';

        $route = $router->match();

        $request->setAttributes($route->getAttributes());

        $handler = $route->getHandler();

        if ($handler instanceof Closure) {
            $handler($request);
        } else {
            [$controllerClass, $method] = explode('@', $handler);
            if ( ! class_exists($controllerClass) || ! method_exists($controllerClass, $method)) {
                throw new RuntimeException('Controller or method does not exists');
            }

            $controller = Container::getContainer()->get($controllerClass);

            $controller->$method($request);
        }
    }
}