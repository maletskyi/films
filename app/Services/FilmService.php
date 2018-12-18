<?php

namespace App\Services;

use App\Entities\Actor;
use App\Entities\Film;
use App\Repositories\FilmRepositoryInterface;
use App\Repositories\StorageFormatRepositoryInterface;

class FilmService implements FilmServiceInterface
{
    private $formatRepository;
    private $filmRepository;
    private $actorService;

    public function __construct(
        FilmRepositoryInterface $filmRepository,
        StorageFormatRepositoryInterface $formatRepository,
        ActorServiceInterface $actorService
    ) {
        $this->filmRepository   = $filmRepository;
        $this->formatRepository = $formatRepository;
        $this->actorService     = $actorService;
    }

    public function getAllFilms(string $order = 'id', string $destination = 'ASC'): ?array
    {
        return $this->filmRepository->getAll($order, $destination);
    }

    public function getFilmById(int $id): ?Film
    {
        return $this->filmRepository->getById($id);
    }

    public function createFilm(Film $film)
    {
        return $this->filmRepository->create($film);
    }

    public function addActor(Film $film, Actor $actor)
    {
        return $this->filmRepository->attachActor($film, $actor);
    }

    public function importFilmsFromFile($file)
    {
        $filmsFile = fopen($file, 'rb');

        if ( ! $filmsFile) {
            return false;
        }

        $films = [];
        $film  = new Film();
        $actors = [];

        while ( ! feof($filmsFile)) {
            $line = fgets($filmsFile);

            $matches = explode(': ', $line, 2);
            $matches = array_map('trim', $matches);

            if (isset($film->title, $film->releaseYear,
                $film->storageFormatId, $film->storageFormat) && !empty($actors)) {
                $film = $this->filmRepository->create($film);
                if ($film) {
                    $films[] = $film;
                    foreach ($actors as $actor) {
                        $this->filmRepository->attachActor($film, $actor);
                    }
                }

                $film = new Film();
                $actors = [];

                continue;
            }

            switch ($matches[0]) {
                case 'Title':
                    $film->title = $matches[1];
                    break;
                case 'Release Year':
                    $film->releaseYear = $matches[1];
                    break;

                case 'Format':
                    $format = $this->formatRepository->getByName($matches[1]);
                    if ($format === null) {
                        break;
                    }

                    $film->storageFormatId = $format->id;
                    $film->storageFormat   = $format;
                    break;

                case 'Stars':
                    $actors = $this->actorService->getOrCreateActorsFromString($matches[1]);
                    break;
            }
        }

        fclose($filmsFile);

        return $films;
    }

    public function deleteFilmById($id)
    {
        return $this->filmRepository->deleteById($id);
    }

    public function searchFilmByField(string $query, string $field)
    {
        return $this->filmRepository->search($query, $field);
    }

    public function searchFilmByActorField(string $query, string $actorField)
    {
        return $this->filmRepository->searchByActor($query, $actorField);
    }
}