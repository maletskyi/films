<?php

namespace App\Repositories;

use App\Entities\StorageFormat;
use PDO;

class StorageFormatRepository extends AbstractRepository implements StorageFormatRepositoryInterface
{
    public function getAll($order = 'id', $destination = 'ASC')
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . StorageFormat::TABLE . ' ORDER BY ' . $order . ' ' . $destination);

        $stmt->setFetchMode(PDO::FETCH_CLASS, StorageFormat::class);

        return $stmt->fetchAll();
    }

    public function create($format): void
    {
        // TODO: Implement create() method.
    }

    public function getById(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . StorageFormat::TABLE . ' WHERE id=?');

        $statement->execute([$id]);

        $statement->setFetchMode(PDO::FETCH_CLASS, StorageFormat::class);

        return $statement->fetch() ?: null;
    }

    public function deleteById(int $id)
    {
        // TODO: Implement deleteById() method.
    }

    public function getByName(string $name): ?StorageFormat
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . StorageFormat::TABLE . ' WHERE name=?');

        $statement->execute([$name]);

        $statement->setFetchMode(PDO::FETCH_CLASS, StorageFormat::class);

        return $statement->fetch() ?: null;
    }
}