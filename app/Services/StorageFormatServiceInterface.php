<?php

namespace App\Services;

interface StorageFormatServiceInterface
{
    public function getAllFormats(string $order = 'id', string $destination = 'ASC'): array ;

    public function formatExistsById(int $id): bool;
}