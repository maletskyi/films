<?php

namespace App\Controllers;

use App\Core\Request\RequestInterface;
use App\Entities\Actor;
use App\Entities\Film;
use App\Services\ActorServiceInterface;
use App\Services\FilmServiceInterface;
use App\Services\StorageFormatServiceInterface;

class FilmController extends Controller
{
    private $filmService;
    private $formatService;
    private $actorService;

    public function __construct(
        FilmServiceInterface $filmService,
        StorageFormatServiceInterface $formatService,
        ActorServiceInterface $actorService
    ) {
        $this->filmService   = $filmService;
        $this->formatService = $formatService;
        $this->actorService  = $actorService;
    }

    public function index()
    {
        return $this->render('home', [
            'films' => $this->filmService->getAllFilms('title', 'ASC'),
        ]);
    }

    public function show(RequestInterface $request)
    {
        $id   = $request->getAttribute('id');
        $film = $this->filmService->getFilmById($id);

        return $this->render('film/show', ['film' => $film]);
    }

    public function create()
    {
        return $this->render('film/create', [
            'formats' => $this->formatService->getAllFormats(),
        ]);
    }

    public function save(RequestInterface $request)
    {
        $params = $request->getParsedBody();

        $title           = $params['title'];
        $releaseYear     = $params['release_year'];
        $storageFormatId = $params['storage_format_id'];
        $actorsString    = $params['actors'];

//       TODO: do validation

        $film = new Film([
            'title'           => $title,
            'releaseYear'     => $releaseYear,
            'storageFormatId' => $storageFormatId,
        ]);

        $film = $this->filmService->createFilm($film);

        if ( ! $film) {
            $this->redirect('/', [
                'messages' => [
                    'error' => 'Sorry, can not create a new film',
                ],
            ]);
        }

        $actors = $this->actorService->getOrCreateActorsFromString($actorsString);

        foreach ($actors as $actor) {
            $this->filmService->addActor($film, $actor);
        }

        $this->redirect('/', [
            'messages' => [
                'success' => 'New film successfully created',
            ],
        ]);
    }

    public function import()
    {
        return $this->render('film/import');
    }

    public function load(RequestInterface $request)
    {
        $files = $request->getFiles();

        $films = $this->filmService->importFilmsFromFile($files['films-file']['tmp_name']);

        if ( ! $films) {
            $this->redirect('/', [
                'messages' => [
                    'error' => 'Can not read the file',
                ],
            ]);
        }

        $filmsCount = count($films);

        if ($filmsCount) {
            $this->redirect('/', [
                'messages' => [
                    'success' => count($films) . ' films successfully imported',
                ],
            ]);
        } else {
            $this->redirect('/', [
                'messages' => [
                    'error' => 'Can not import films',
                ],
            ]);
        }
    }

    public function delete(RequestInterface $request)
    {
        $id = $request->getAttribute('id');

        if ($this->filmService->deleteFilmById($id)) {
            $this->redirect('/', [
                'messages' => [
                    'success' => 'Film with id ' . $id . ' successfully deleted',
                ],
            ]);
        } else {
            $this->redirect('/', [
                'messages' => [
                    'error' => 'Can not delete film with id ' . $id,
                ],
            ]);
        }
    }

    public function search(RequestInterface $request)
    {
        $params = $request->getParsedBody();

        $searchQuery = toCamelCase($params['search-query']);
        $searchField = toCamelCase($params['search-field']);

        $films = [];

        if (in_array($searchField, Film::FIELDS, true)) {
            $films = $this->filmService->searchFilmByField($searchQuery, $searchField);
        } elseif (in_array($searchField, Actor::FIELDS, true)) {
            $films = $this->filmService->searchFilmByActorField($searchQuery, $searchField);
        }

        return $this->render('film/search', ['films' => $films]);
    }
}