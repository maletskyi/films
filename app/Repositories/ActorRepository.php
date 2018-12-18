<?php

namespace App\Repositories;

use App\Entities\Actor;
use PDO;

class ActorRepository extends AbstractRepository implements ActorRepositoryInterface
{
    public function getAll($order = 'id', $destination = 'ASC')
    {
        // TODO: Implement getAll() method.
    }

    public function create($actor)
    {
        $statement = $this->pdo->prepare('INSERT INTO ' . Actor::TABLE . ' SET first_name=?, last_name=?');

        $success = $statement->execute([
            $actor->firstName,
            $actor->lastName,
        ]);

        if ( ! $success) {
            return false;
        }

        $id = $this->pdo->lastInsertId();

        $actor->id = $id;

        return $actor;
    }

    public function getById(int $id)
    {
        // TODO: Implement getById() method.
    }

    public function deleteById(int $id)
    {
        // TODO: Implement deleteById() method.
    }

    public function getByFilmId(int $filmId): array
    {
        $stmt = $this->pdo->prepare('SELECT ' . Actor::TABLE . '.* FROM ' . Actor::TABLE . ' JOIN actor_film ON actors.id = actor_film.actor_id WHERE film_id=?');

        $stmt->execute([$filmId]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Actor::class);

        return $stmt->fetchAll();
    }

    public function getByFirstNameAndLastName(string $firstName, string $lastName): ?Actor
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . Actor::TABLE . ' WHERE first_name=? AND last_name=?');

        $stmt->execute([$firstName, $lastName]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Actor::class);

        return $stmt->fetch() ?: null;
    }
}