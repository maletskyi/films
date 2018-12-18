<?php

namespace App\Services;

use App\Entities\StorageFormat;
use App\Repositories\StorageFormatRepositoryInterface;

class StorageFormatService implements StorageFormatServiceInterface
{
    private $formatRepository;

    public function __construct(StorageFormatRepositoryInterface $formatRepository)
    {
        $this->formatRepository = $formatRepository;
    }

    public function getAllFormats(string $order = 'id', string $destination = 'ASC'): array
    {
        return $this->formatRepository->getAll($order, $destination);
    }
}