<?php

return [
    App\Services\FilmServiceInterface::class                 => App\Services\FilmService::class,
    App\Services\StorageFormatServiceInterface::class        => App\Services\StorageFormatService::class,
    App\Services\ActorServiceInterface::class                => App\Services\ActorService::class,
    App\Repositories\FilmRepositoryInterface::class          => App\Repositories\FilmRepository::class,
    App\Repositories\StorageFormatRepositoryInterface::class => App\Repositories\StorageFormatRepository::class,
    App\Repositories\ActorRepositoryInterface::class         => App\Repositories\ActorRepository::class,
];