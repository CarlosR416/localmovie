<?php  
namespace App\Controladores;

/**
 * 
 */
class Videos extends Controlador
{

	function index($request, $response, $args){

        
        return $this->view->render($response, 'Videos.twig', $args);

	}
}


?>