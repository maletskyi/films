<?php

namespace App\Services;

interface ActorServiceInterface
{
    public function getOrCreateActorsFromString(string $actors): array;
}