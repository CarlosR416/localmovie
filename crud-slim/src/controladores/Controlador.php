<?php
namespace App\Controladores;

use Slim\Views\Twig; // Las vistas de la aplicación
use Slim\Router; // Las rutas de la aplicación
/**
 * 
 */
class Controlador
{
	// objeto de la clase Twig
    protected $view;
	
	// objeto de la clase Router
	protected $router;

	protected $container;
	
	function __construct($container)
	{
		$this->view = $container->get('renderer');
		$this->router = $container->get('router');
		$this->container = $container;
	}

}


?>