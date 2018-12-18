<?php

namespace App\Entities;

class StorageFormat extends AbstractEntity
{
    public const TABLE = 'storage_formats';

    public const FIELDS = [
        'id',
        'name',
    ];

}