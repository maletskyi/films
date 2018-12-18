<?php

namespace App\Services;

use App\Entities\Actor;
use App\Entities\Film;

interface FilmServiceInterface
{
    public function getAllFilms(string $order = 'id', string $destination = 'ASC'): ?array;

    public function getFilmById(int $id): ?Film;

    public function createFilm(Film $film);

    public function addActor(Film $film, Actor $actor);

    public function importFilmsFromFile($file);

    public function deleteFilmById($id);

    public function searchFilmByField(string $query, string $field);

    public function searchFilmByActorField(string $query, string $actorField);
}