<?php

namespace App\Entities;

class Film extends AbstractEntity
{
    public const MIN_RELEASE_YEAR = 1900;

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