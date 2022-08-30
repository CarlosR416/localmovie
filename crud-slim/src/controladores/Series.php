<?php  
namespace App\Controladores;

use App\Modelos\Series as Serie;
use App\Modelos\Capitulos;
use App\Modelos\UsersLog;
use App\Modelos\Categoria;
use Respect\Validation\Validator as v;

/**
 * 
 */
class Series extends Controlador
{

	function __construct($container){
		parent::__construct($container);
		$categoarias = Categoria::all();
		//$C_total = $categoarias->count();
		$S_total = Serie::all()->count();
		$this->view->getEnvironment()->addGlobal('categorias', $categoarias);
		$this->view->getEnvironment()->addGlobal('totalp', $S_total);

	}

	function index($request, $response, $args){

        $pagina = $request->getParam('p');
		$busqueda = $request->getParam('f');
		$categoria_id = $request->getParam('c');
		$limit = 40;

		if (!isset($pagina)) { $pagina = 1; }

		$pagina_inicio = ($limit*$pagina)-$limit;

		if (isset($categoria_id)) {

			$param = "&c=".$categoria_id;

			$categoria = Categoria::find($categoria_id);
			$total_s = $categoria->total_s->count();
			$series = null;
			
			$s = $categoria->total_s;

			for($ii=0;$ii<$limit;$ii++){
				$key = $pagina_inicio+$ii;
				
				if($key >= $total_s){
				 break;
				}
				$series[$ii] = $s[$key]->series;
			}
			/*foreach ( as $key => $value) {

				if($key >= $inic+1 && $){
					 = $value->peliculas;
				}
				
				
			}*/
			
		}else if (isset($busqueda)) {
			
			$sdb = Serie::where('titulo', 'like' ,'%'.$busqueda.'%');
			$total_s = $sdb->get()->count();
			$series = $sdb->limit($limit)->offset($pagina_inicio)->orderBy('created_at', 'desc')->get();
			$param = '&f='.$busqueda;

		}else{
	
			$series = Serie::limit($limit)->offset($pagina_inicio)->orderBy('created_at', 'desc')->get();
			$param = '';
			$total_s = Serie::all()->count();

		}

		$total_s = $total_s / $limit;

		if (is_float($total_s)) {
		 	$val = intval($total_s);
		 	$val > $total_s ? $total_s = $val : $total_s = $val + 1;
		}

		$pagination = ['total' => $total_s, 'active' => $pagina, 'param' => $param];

        return $this->view->render($response, 'Series/Series.twig', ['data' => $series, 'pagination' => $pagination]);

	}

	function ver($request, $response, $args){
		$reproducir = null;
		$data = null;
		$capitulo = null;

		if (v::notBlank()->numeric()->validate($args['id_serie'])) {

			$serie = Serie::find($args['id_serie']);

			
			if (isset($serie)) {
				
				$cap_id = '';
 
				if (v::notBlank()->numeric()->validate(@$args['id'])){

					$cap_id = $args['id'];

					UsersLog::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id_serie'], 'id_subrcs' => $cap_id, 'ip' => $this->container->getIP, 'comentario' => 'se carga capitulo con exito']);
					
					$capitulo = Capitulos::find($args['id']);
					$capitulo['continua'] = false;
					

				}else{

					$user_log = UsersLog::where('id_user', $_SESSION['ID_USER'])->where('id_rcs', $args['id_serie'])->orderBy('updated_at', 'DESC')->first();

					if(isset($user_log)){

						$cap_id = $user_log->id_subrcs;

						$capitulo = $serie->capitulos->find($cap_id);
						UsersLog::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id_serie'], 'id_subrcs' => $cap_id, 'ip' => $this->container->getIP, 'comentario' => 'se carga continuacion de capitulo con exito']);


					}else{

						$capitulo = $serie->capitulos()->first();
						
						isset($capitulo) ? $cap_id = $capitulo->id : $cap_id = "S/C";

						UsersLog::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id_serie'], 'id_subrcs' => $cap_id, 'ip' => $this->container->getIP, 'comentario' => 'se carga primer capitulo de temporada con exito']);
						
						$capitulo['continue'] = true;

					}
					
				}

				
				if (isset($capitulo)) {
					$url_capitulo = '/home/media/series/'.$capitulo->url;

					if (!is_file($url_capitulo)) {

						UsersLog::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id_serie'], 'id_subrcs' => $cap_id, 'ip' => $this->container->getIP, 'comentario' => 'Achivo de video capitulo inexistente']);

					}else{

						UsersLog::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id_serie'], 'id_subrcs' => $cap_id, 'ip' => $this->container->getIP, 'comentario' => 'Reproduce capitulo de temporada con exito']);

						$reproducir = true;
					}

				}else{

					UsersLog::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id_serie'], 'id_subrcs' => $cap_id, 'ip' => $this->container->getIP, 'comentario' => 'No se encuentra capitulo en base de datos']);
				}
					
			}
	
		}
		//die(var_dump(json_encode($serie->capitulos()->first())));

		return $this->view->render($response,'Series/Series.Ver.twig', ['data' => $serie, 'cap' => $capitulo, 'reproducir' => $reproducir]);

	}


	function add($request, $response, $args){
		

		if (is_uploaded_file($_FILES['imgfile']['tmp_name']) | isset($_POST["url_img"])) {

			$param = $request->getParsedBody();

			$valid = [

					v::notBlank()->length(2)->validate($param['titulo']),

					v::notBlank()->length(2)->validate($param['descripcion']),

					v::intType()->validate(intval($param['temporadas'])),

				];


			if (!in_array(false, $valid)) {

				$url_path = $this->router->getbasePath();
				$codigo = md5(trim($param['titulo']));
				$titulo = preg_replace('([^A-Za-z0-9])', '_', $param['titulo']);
				$titulo = $titulo.substr($codigo, 0, 5);
				$img = '';

				if(v::notBlank()->validate($param["url_img"])){

					$img = substr($titulo, 0, 55).'.jpg';
					$url_download = $_SERVER['DOCUMENT_ROOT'].$url_path.'/assets/imagenes/'.$img;

					$this->container->Download->image($url_download ,$param["url_img"]);
				
					// Declaramos la ruta para almacenar los archivos descargados
					

				}else{

					$type =  str_replace('/', '.', strstr($_FILES['imgfile']['type'], '/'));

					$img = substr($titulo, 0, 55).$type;
				
					copy($_FILES['imgfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$url_path.'/assets/imagenes/'.$img);

				}
				
				
				$r[0] = Serie::create(['titulo' => $param['titulo'], 'img' => $img, 'descripcion' => $param['descripcion'], 'temporadas' => $param['temporadas']]);
				
				if (v::notBlank()->validate($param['season'])) {

					$season = json_decode($param['season']);
					$path_serie = substr($titulo, 0, 55);
					$path_serie_mkdir  = '/home/media/series/'.$path_serie;

					if(!is_dir($path_serie_mkdir)){
						mkdir($path_serie_mkdir, 0777, true);
					}

					foreach ($season as $i => $e) {
						

						if (isset($e->poster_path)) {

							$img_season = $param["img_base_url"].'w400'.$e->poster_path;

							$e->poster_path = substr($titulo, 0, 45).'_temp_'.($i+1).'.jpg';

							$url_download = $_SERVER['DOCUMENT_ROOT'].$url_path.'/assets/imagenes/'.$e->poster_path;

							$this->container->Download->image($url_download ,$img_season);

						}else{
							$e->poster_path = $r[0]->img;
						}
						

						foreach ($e->episodes as $key => $value) {

							$id = intval($r[0]->id.($i+1).($key+1));
							$serie_id = $r[0]->id;
							$name = $value->name;
							$img =	$e->poster_path;//$value->still_path;
							$duracion = 0;
							$descripcion = $value->overview;
							
							$url = $path_serie.'/tem'.($i+1).'/cap'.($key+1).'.mp4';

							Capitulos::create([
								'id' => $id,
								'id_serie' => $serie_id,
								'temporada' => ($i+1),
								'capitulo' => ($key+1),
								'nombre' => $name,
								'img' => $img,
								'duracion' => $duracion,
								'descripcion' => $descripcion,
								'url' => $url
							]);

						}

					}

				}

				return $this->view->render($response, 'Series/ficha.twig', ['data' => $r]);

			}else{

				return json_encode($valid);

			}

		}

	}

	function del($request, $response, $args){
	
		if(v::notBlank()->validate($args['id'])){

			$serie = Serie::find($args['id']);
			
			if (isset($serie)) {

				$serie->categorias()->delete();
				$serie->capitulos()->delete();
				$serie->delete();

				echo 'Serie Eliminada con exito <a href="'.$this->router->pathFor('peliculas').'">regresar</a>';
			}

		}

	}
}



?>