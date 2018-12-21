<?php

namespace App;

use App\Core\Request\Request;
use App\Core\Routing\Router;
use App\Exceptions\ActionNotExists;
use Closure;
use App\Core\DependencyInjection\Container;
use PDO;

class App
{
    public static $connection;

    public function bootstrap(): void
    {
        $this->initDBConnection();

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
                throw new ActionNotExists('Action does not exists');
            }

            $controller = Container::getContainer()->get($controllerClass);

            $controller->$method($request);
        }
    }

    public function initDBConnection()
    {
        $settings = require dirname(__DIR__).'/config/db.php';

        $host    = $settings['host'];
        $db      = $settings['db'];
        $user    = $settings['user'];
        $pass    = $settings['pass'];
        $charset = $settings['charset'];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
//            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        self::$connection = new PDO($dsn, $user, $pass, $opt);
    }
}