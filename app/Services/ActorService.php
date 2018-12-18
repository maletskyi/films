<?php

namespace App\Services;

use App\Entities\Actor;
use App\Repositories\ActorRepositoryInterface;

class ActorService implements ActorServiceInterface
{
    private $actorRepository;

    public function __construct(ActorRepositoryInterface $actorRepository)
    {
        $this->actorRepository = $actorRepository;
    }

    public function getOrCreateActorsFromString(string $actors): array
    {
        preg_match_all('/\w+\s\w+/', $actors, $matches);

        $actorsResult = [];

        foreach ($matches[0] as $actor) {
            [$firstName, $lastName] = explode(' ', $actor);

            $actor = $this->actorRepository->getByFirstNameAndLastName($firstName, $lastName);

            if ($actor instanceof Actor) {
                $actorsResult[] = $actor;
            } else {
                $actor = $this->actorRepository->create(new Actor([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                ]));

                if ($actor instanceof Actor) {
                    $actorsResult[] = $actor;
                }
            }
        }

        return $actorsResult;
    }
}