<?php

namespace App\Repositories;

use App\Entities\Actor;
use App\Entities\Film;

interface FilmRepositoryInterface extends RepositoryInterface
{
    public function attachActor(Film $film, Actor $actor);

    public function search(string $query, string $field);

    public function searchByActor(string $query, string $filmField);
}