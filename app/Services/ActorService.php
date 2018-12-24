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
        $actors = preg_replace('/\s+/', ' ', trim($actors));
        preg_match_all('/([а-яА-ЯЁёіa-zA-Z]{1,50}\s[а-яА-ЯЁёіa-zA-Z]{1,50})/u', $actors, $matches);

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