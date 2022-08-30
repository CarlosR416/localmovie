<?php  
namespace App\Controladores;

use App\Modelos\Series as S;
use App\Modelos\Capitulos as C;
use App\Modelos\UsersLog as UL;

/**
 * 
 */
class Contenido extends Controlador
{	
	protected $client;
	protected $configuration;


	function __construct($container){
		parent::__construct($container);

		$token = new \Tmdb\ApiToken('429ec4c425b0a7a762462ce16b7a82b7');
		$this->client = new \Tmdb\Client($token, ['secure' => false]);
		$this->configuration = $this->client->getConfigurationApi()->getConfiguration();
		
	}

	function Serie_search($request, $response, $args){

		$url_img = $this->configuration['images']['base_url'];

		if (isset($args['search'])) {

			$search = $args['search'];
			$result = $this->client->getSearchApi()->searchTv($search, array('language' => 'es'));


			if (count($result['results']) > 0) {

				$resp = json_encode($result['results']);

				//Se maneja ahora en js
				/*foreach ($result['results'] as $key => $value) {
				
					echo '<option data-titulo="'.$value['id'].'" value="'.$value['name'].'"></option>';
					
					if ($key>3) {
						break;
					}
				}*/

			}else{

				$resp = 'null';

			}
			

		}
		
		//d($result);

		return $resp;
	}

	function Serie_id($request, $response, $args){

		if (isset($args['id'])) {

			$tvShow = $this->client->getTvApi()->getTvshow($args['id'], array('language' => 'es'));
			$tvShow['base_url_image'] = $this->configuration['images']['base_url'];
			$season = [];

			for ($i=0; $i < $tvShow['number_of_seasons']; $i++) {

				$season[$i] = $this->client->getTvSeasonApi()->getSeason($args['id'], $i+1, array('language' => 'es'));

			}
			
			$tvShow['season'] = $season;

		}else{



		}


		return json_encode($tvShow);
		
	}

	function Pelicula_search($request, $response, $args){

		$url_img = $this->configuration['images']['base_url'];

		if (isset($args['search'])) {

			$search = $args['search'];
			$result = $this->client->getSearchApi()->searchMovies($search, array('language' => 'es'));


			if (count($result['results']) > 0) {

				$resp = json_encode($result['results']);

				//Se maneja ahora en js
				/*foreach ($result['results'] as $key => $value) {
				
					echo '<option data-titulo="'.$value['id'].'" value="'.$value['name'].'"></option>';
					
					if ($key>3) {
						break;
					}
				}*/

			}else{

				$resp = 'null';
				
			}
			

		}else{
			$resp = 'null';
		}
		

		return $resp;
	}

	function Pelicula_id($request, $response, $args){

		if (isset($args['id'])) {

			$movie = $this->client->getMoviesApi()->getMovie($args['id'], array('language' => 'es'));
			$movie['base_url_image'] = $this->configuration['images']['base_url'];

			
		}else{



		}

		return json_encode($movie);
		
	}
}