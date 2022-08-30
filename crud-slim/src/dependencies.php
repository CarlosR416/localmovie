<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    
    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
    
        $twig = new \Slim\Views\Twig($settings['template_path'], $settings['config']);

        $twig->addExtension(new \Slim\Views\TwigExtension($c->router, $c->request->getUri()));

        //$twig->addExtension(new \Slim\Views\Twig_Extension_Debug());

        $twig->getEnvironment()->addGlobal('Session', $_SESSION);

        return $twig;
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container['getIP'] = function () {
    	
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    };

    $container['Download'] = function ($container) {
        
        return new \App\Helpers\Download($container);

    };

    $container['db'] = function ($container) {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container['settings']['db']);
        return $capsule;
    };

    $container['Login'] = function($container){

        return new \App\Controladores\Login($container);

    };

    $container['Series'] = function($container){

        return new \App\Controladores\Series($container);

    };

    $container['Peliculas'] = function($container){

        return new \App\Controladores\Peliculas($container);

    };

    $container['Videos'] = function($container){

        return new \App\Controladores\Videos($container);

    };

    $container['Contenido'] = function($container){

        return new \App\Controladores\Contenido($container);

    };
};
