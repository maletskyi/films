<?php

namespace App\Core\DependencyInjection;

use Closure;
use Exception;
use ReflectionClass;

class Container implements ContainerInterface
{
    private $bindings;

    private static $container;

    public $instances = [];

    public static function getContainer(): Container
    {
        if (self::$container === null) {
            self::$container = new self();
        }

        return self::$container;
    }

    private function __construct() {
        $this->bindings = require dirname(__DIR__, 3) . '/bindings.php';
    }

    public function set($abstract, $concrete = null)
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        $this->instances[$abstract] = $concrete;
    }

    public function get($abstract, $parameters = [])
    {
        // if we don't have it, just register it
        if ( ! isset($this->instances[$abstract])) {
            $this->set($abstract);
        }

        return $this->resolve($this->instances[$abstract], $parameters);
    }

    private function resolve($concrete, $parameters)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }

        if (isset($this->bindings[$concrete])) {
            $concrete = $this->bindings[$concrete];
        }

        $reflector = new ReflectionClass($concrete);

        if ( ! $reflector->isInstantiable()) {
            throw new Exception("Class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();
        if ($constructor === null) {
            return $reflector->newInstance();
        }

        $parameters   = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    private function getDependencies($parameters)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if ($dependency === null) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Can not resolve class dependency {$parameter->name}");
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }
}