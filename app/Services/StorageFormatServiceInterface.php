<?php

namespace App\Services;

use App\Entities\StorageFormat;

interface StorageFormatServiceInterface
{
    public function getAllFormats(string $order = 'id', string $destination = 'ASC'): array ;
}