<?php

namespace App\Repositories;

use App\Entities\StorageFormat;

interface StorageFormatRepositoryInterface extends RepositoryInterface
{

    public function getByName(string $name): ?StorageFormat;
}