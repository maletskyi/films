<?php

namespace App\Entities;

abstract class AbstractEntity
{
    public function __construct(array $fields = [])
    {
        foreach ($fields as $field => $value) {
            if (in_array($field, static::FIELDS, true)) {
                $this->$field = $value;
            }
        }
    }

    public function __set($name, $value)
    {
        $name = toCamelCase($name);

        if (in_array($name, static::FIELDS, true) || in_array($name, static::RELATIONS, true)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (in_array($name, static::FIELDS, true) || in_array($name, static::RELATIONS, true)) {
            return $this->$name;
        }

        return null;
    }

    public function __isset($name)
    {
        $name = toCamelCase($name);
        return isset($this->$name);
    }
}