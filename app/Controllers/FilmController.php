<?php

namespace App\Controllers;

use App\Core\DependencyInjection\Container;
use App\Core\Request\RequestInterface;
use App\Core\Validation\Rules\ExistsByIdRule;
use App\Core\Validation\Rules\MaxValueRule;
use App\Core\Validation\Rules\MinValueRule;
use App\Core\Validation\Rules\RegexRule;
use App\Core\Validation\Validator;
use App\Entities\Actor;
use App\Entities\Film;
use App\Repositories\StorageFormatRepositoryInterface;
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

        $title           = trim($params['title']);
        $releaseYear     = trim($params['release_year']);
        $storageFormatId = trim($params['storage_format_id']);
        $actors          = preg_replace('/\s+/', ' ', trim($params['actors']));

        $currentYear      = (int) date('Y');
        $formatRepository = Container::getContainer()->get(StorageFormatRepositoryInterface::class);

        $titleRegexRule = new RegexRule('/^(.{2,255})$/u', $title, 'Title must be greater than 1 and less than 256 characters');

        $releaseYearRegexRule = new RegexRule('/^([\d]{4})$/', $releaseYear, 'Invalid release year format');
        $releaseYearMinRule   = new MinValueRule(Film::MIN_RELEASE_YEAR, $releaseYear, 'Release year must be greater than ' . Film::MIN_RELEASE_YEAR);
        $releaseYearMaxRule   = new MaxValueRule($currentYear, $releaseYear, 'Release year must be less or equal than ' . $currentYear);

        $formatIdExistsByIdRule = new ExistsByIdRule($formatRepository, $storageFormatId, 'Storage format does not exists');

        $actorsRegexRule = new RegexRule('/([а-яА-ЯЁёіa-zA-Z]{1,50}\s[а-яА-ЯЁёіa-zA-Z]{1,50})/u', $actors, 'Invalid actors string');

        $validator = new Validator();

        $validator
            ->addRule('title', $titleRegexRule)
            ->addRule('release_year', $releaseYearRegexRule)
            ->addRule('release_year', $releaseYearMinRule)
            ->addRule('release_year', $releaseYearMaxRule)
            ->addRule('storage_format_id', $formatIdExistsByIdRule)
            ->addRule('actors', $actorsRegexRule);

        if (!$validator->validate()) {
            $this->redirect('/films/create', [
                'validation' => $validator->getValidationResult(),
            ]);
        }

        $film = new Film([
            'title'           => $title,
            'releaseYear'     => $releaseYear,
            'storageFormatId' => $storageFormatId,
        ]);

        $film = $this->filmService->createFilm($film);

        if (!$film) {
            $this->redirect('/', [
                'messages' => [
                    'error' => 'Sorry, can not create a new film',
                ],
            ]);
        }

        $actors = $this->actorService->getOrCreateActorsFromString($actors);

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

        if (!$films) {
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

        $searchQuery = trim(toCamelCase($params['search-query']));
        $searchField = trim(toCamelCase($params['search-field']));

        $films = [];

        if (in_array($searchField, Film::FIELDS, true)) {
            $films = $this->filmService->searchFilmByField($searchQuery, $searchField);
        } elseif (in_array($searchField, Actor::FIELDS, true)) {
            $films = $this->filmService->searchFilmByActorField($searchQuery, $searchField);
        }

        return $this->render('film/search', ['films' => $films]);
    }
}