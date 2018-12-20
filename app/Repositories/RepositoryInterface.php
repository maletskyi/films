<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll($order = 'id', $destination = 'ASC');

    public function create($entity);

    public function getById(int $id);

    public function deleteById(int $id);

    public function existsById(int $id);

//    public function update(AbstractEntity $entity);
}