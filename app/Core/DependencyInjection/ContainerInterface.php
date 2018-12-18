<?php

namespace App\Core\DependencyInjection;


interface ContainerInterface
{
    public function get($id);

    public function set($id);
}