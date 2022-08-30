<?php

use Slim\App;

return function (App $app) {

    $container = $app->getContainer();

    $container['Auth'] = function($container){

        return new \App\Middleware\Auth($container);

    };

    $app->add('Auth');

};
