<?php

$router->get('/', 'home', 'App\Controllers\FilmController@index');
$router->get('/films/(?<id>\d+)', 'films.show', 'App\Controllers\FilmController@show');
$router->get('/films/create', 'films.create', 'App\Controllers\FilmController@create');
$router->post('/films/save', 'films.save', 'App\Controllers\FilmController@save');
$router->get('/films/import', 'films.import', 'App\Controllers\FilmController@import');
$router->post('/films/load', 'films.load', 'App\Controllers\FilmController@load');
$router->post('/films/(?<id>\d+)/delete', 'films.delete', 'App\Controllers\FilmController@delete');
$router->post('/films/search', 'films.search', 'App\Controllers\FilmController@search');