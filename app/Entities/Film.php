<?php

namespace App\Entities;

class Film extends AbstractEntity
{
    public const TABLE = 'films';

    public const FIELDS = [
        'id',
        'title',
        'releaseYear',
        'storageFormatId',
    ];

    public const RELATIONS = [
        'storageFormat',
        'actors',
    ];
}