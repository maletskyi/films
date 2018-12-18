<?php

namespace App\Repositories;

use App\Entities\AbstractEntity;
use App\Entities\Actor;
use PDO;
use App\Entities\Film;

class FilmRepository extends AbstractRepository implements FilmRepositoryInterface
{
    private $actorRepository;
    private $formatRepository;

    public function __construct(
        ActorRepositoryInterface $actorRepository,
        StorageFormatRepositoryInterface $formatRepository
    ) {
        parent::__construct();

        $this->actorRepository = $actorRepository;
        $this->formatRepository = $formatRepository;
    }

    public function create($film)
    {
        $statement = $this->pdo->prepare('INSERT INTO ' . Film::TABLE . ' SET title=?, release_year=?, storage_format_id=?');

        $success = $statement->execute([
            $film->title,
            $film->releaseYear,
            $film->storageFormatId,
        ]);

        if ( ! $success) {
            return false;
        }

        $id = $this->pdo->lastInsertId();

        $film->id = $id;

        return $film;
    }

    public function getById(int $id): ?AbstractEntity
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . Film::TABLE . ' WHERE id=?');

        $stmt->execute([$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Film::class);

        $film = $stmt->fetch() ?: null;

        if ($film === null) {
            return null;
        }

        $film->storageFormat = $this->formatRepository->getById($film->storageFormatId);
        $film->actors        = $this->actorRepository->getByFilmId($film->id);

        return $film;
    }

    public function deleteById(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . Film::TABLE . ' WHERE id=?');

        return $stmt->execute([$id]);
    }

    public function getAll($order = 'id', $destination = 'ASC'): array
    {
        $stmt = $this->pdo->query('SELECT * FROM ' . Film::TABLE . ' ORDER BY '.$order.' '.$destination);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Film::class);

        $films = $stmt->fetchAll();

        foreach ($films as $film) {
            $film->storageFormat = $this->formatRepository->getById($film->storageFormatId);
            $film->actors        = $this->actorRepository->getByFilmId($film->id);
        }

        return $films;
    }

    public function attachActor(Film $film, Actor $actor)
    {
        $statement = $this->pdo->prepare('INSERT INTO actor_film SET actor_id=?, film_id=?');

        return $statement->execute([
            $actor->id,
            $film->id,
        ]);
    }

    public function search(string $query, string $field)
    {
        $field = fromCamelCase($field);

        if (!in_array($field, Film::FIELDS, true)) {
            return null;
        }

        $statement   = $this->pdo->prepare('SELECT * FROM ' . Film::TABLE . ' WHERE ' . $field . ' LIKE ? ORDER BY ' . $field);

        $statement->execute([$query . '%']);

        $statement->setFetchMode(PDO::FETCH_CLASS, Film::class);

        $films = $statement->fetchAll();

        foreach ($films as $film) {
            $film->storageFormat = $this->formatRepository->getById($film->storageFormatId);
            $film->actors        = $this->actorRepository->getByFilmId($film->id);
        }

        return $films;
    }

    public function searchByActor(string $query, string $actorField)
    {
        $filmField = toCamelCase($actorField);

        if (!in_array($filmField, Actor::FIELDS, true)) {
            return null;
        }

        $filmField = fromCamelCase($actorField);

        $sql = 'SELECT DISTINCT ' . Film::TABLE . '.* FROM ' . Film::TABLE . ' JOIN actor_film ON films.id = actor_film.film_id JOIN actors ON actors.id = actor_film.actor_id WHERE actors.' . $filmField . ' LIKE ?';

        $statement = $this->pdo->prepare($sql);

        $statement->execute([$query . '%']);

        $statement->setFetchMode(PDO::FETCH_CLASS, Film::class);

        $films = $statement->fetchAll();

        foreach ($films as $film) {
            $film->storageFormat = $this->formatRepository->getById($film->storageFormatId);
            $film->actors        = $this->actorRepository->getByFilmId($film->id);
        }

        return $films;
    }
}