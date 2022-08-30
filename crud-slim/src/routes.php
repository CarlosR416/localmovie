<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $response->withRedirect($container->router->pathFor('peliculas'));;

    });

    $app->get('/login', 'Login:index')->setName('login');
    $app->post('/login', 'Login:check')->setName('login.post');
    $app->get('/logout', 'Login:logout')->setName('logout');

    $app->get('/contenido/serie/{search}', 'Contenido:Serie_search')->setName('api.serie.search');
    $app->get('/contenido/serie/select/{id}', 'Contenido:Serie_id')->setName('api.serie.id');
    $app->get('/contenido/pelicula/{search}', 'Contenido:Pelicula_search')->setName('api.pelicula.search');
    $app->get('/contenido/pelicula/select/{id}', 'Contenido:Pelicula_id')->setName('api.pelicula.id');

    $app->group('/series', function($app){

        $app->get('', 'Series:index')->setName('series');

        $app->get('/ver/{id_serie}[/{id}]', 'Series:ver')->setName('series.ver');

        $app->post('/add', 'Series:add')->setName('serie.add')->add('Auth:checkAdmin');

        $app->get('/del/{id}', 'Series:del')->setName('serie.del')->add('Auth:checkAdmin');

    });

    $app->group('/peliculas', function($app){

    	$app->get('', 'Peliculas:index')->setName('peliculas');

    	$app->get('/ver/[{id}]', 'Peliculas:Ver')->setName('pelicula.ver');

        $app->post('/edit/{id}', 'Peliculas:edit')->setName('pelicula.edit')->add('Auth:checkAdmin');

        $app->post('/add', 'Peliculas:add')->setName('pelicula.add')->add('Auth:checkAdmin');

        $app->get('/del/{id}', 'Peliculas:del')->setName('pelicula.del')->add('Auth:checkAdmin');

    });
    

    $app->get('/videos', 'Videos:index')->setName('videos');

    /*$app->get('/pelicula/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'tema2.twig', $args);
    })->setName('pelicula');*/
};
