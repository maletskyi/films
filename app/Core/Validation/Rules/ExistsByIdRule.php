<?php

namespace App\Core\Validation\Rules;

use App\Repositories\RepositoryInterface;

class ExistsByIdRule extends AbstractRule
{
    private $repository;

    public function __construct(RepositoryInterface $repository, $value, string $errorMessage)
    {
        parent::__construct((int) $value, $errorMessage);

        $this->repository = $repository;
    }

    public function checkRule(): bool
    {
        return $this->repository->existsById($this->value);
    }
}