<?php

namespace App\Repositories;

use App\Entities\Actor;

interface ActorRepositoryInterface extends RepositoryInterface
{
    public function getByFilmId(int $filmId): array ;

    public function getByFirstNameAndLastName(string $firstName, string $lastName): ?Actor;
}