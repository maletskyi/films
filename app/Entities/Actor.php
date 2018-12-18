<?php

namespace App\Entities;

class Actor extends AbstractEntity
{
    public const TABLE = 'actors';

    public const FIELDS = [
        'id',
        'firstName',
        'lastName',
    ];

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}