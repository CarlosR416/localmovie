<?php  
namespace App\Controladores;
use App\Modelos\Pelicula as p;
use App\Modelos\Categoria as ct;
use Respect\Validation\Validator as v;
use App\Modelos\UsersLog as UL;

/**
 * 
 */
class Peliculas extends Controlador
{
	function __construct($container){

		parent::__construct($container);
		$ct = ct::all();
		$totalc = $ct->count();
		$totalp = p::all()->count();
		$this->view->getEnvironment()->addGlobal('categorias', $ct);
		$this->view->getEnvironment()->addGlobal('totalp', $totalp);

	}
    
	function index($request, $response, $args){

		$p = $request->getParam('p');
		$f = $request->getParam('f');
		$c = $request->getParam('c');
		$limit = 16;

		if (!isset($p)) { $p = 1; }

		$inic = ($limit*$p)-$limit;

		if (isset($c)) {

			$param = "&c=".$c;
			
			$peliculas = ct::find($c)->total_p;
			$total = $peliculas->count();
			$i = null;
			
			for($ii=0;$ii<$limit;$ii++){
				$key = $inic+$ii;
				if($key >= $total){
				 break;
				}
				$i[$ii] = $peliculas[$key]->peliculas;
			}
			/*foreach ( as $key => $value) {

				if($key >= $inic+1 && $){
					 = $value->peliculas;
				}
				
				
			}*/
			
		} else if (isset($f)) {
			
			$pdb = p::where('titulo', 'like' ,'%'.$f.'%');
			$total = $pdb->get()->count();
			$i = $pdb->limit($limit)->offset($inic)->orderBy('created_at', 'desc')->get();
			$param = '&f='.$f;
		
		} else {

			$i = p::limit($limit)->offset($inic)->orderBy('created_at', 'desc')->get();
			$param = '';
			$total = p::all()->count();

		}

		
		$total =  $total / $limit;

		if (is_float($total)) {
		 	$val = intval($total);
		 	$val > $total ? $total = $val : $total = $val + 1;
		}

		$pagination = ['total' => $total, 'active' => $p, 'param' => $param];


        return $this->view->render($response, 'peliculas/Peliculas.twig', ['data' => $i, 'pagination' => $pagination]);

	}

	function Ver($request, $response, $args){
		$pelicula = null;
		$reproducir = null;
		if (v::notBlank()->numeric()->validate($args['id'])) {

			$pelicula = p::find($args['id']);

			if (isset($pelicula)) {

				$url_pelicula = '/home/media/peliculas/'.$pelicula->url;

				if (!is_file($url_pelicula)) {
					UL::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id'], 'id_subrcs' => "000000", 'ip' => $this->container->getIP, 'comentario' => 'Archivo de video Inexistente']);
				}else{
					UL::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id'], 'id_subrcs' => "000000", 'ip' => $this->container->getIP, 'comentario' => 'Reproduce pelicula Exitosamente']);
					$reproducir = true;
				}
			}else{
				UL::create(['id_user' => $_SESSION['ID_USER'], 'id_rcs' => $args['id'], 'id_subrcs' => "000000", 'ip' => $this->container->getIP, 'comentario' => 'No se encuentra pelicula en base de datos']);
			}

		}
		
		return $this->view->render($response, 'peliculas/peliculas.ver.twig', ['data' => $pelicula, 'reproducir' => $reproducir]);
	}

	function add($request, $response, $args){
		
		if (is_uploaded_file($_FILES['imgfile']['tmp_name']) | isset($_POST["url_img"])) {

			$param = $request->getParsedBody();

			$valid = [

					v::notBlank()->length(2)->validate($param['titulo']),

					v::notBlank()->length(2)->validate($param['descripcion']),

					v::intType()->validate(intval($param['duracion'])),

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

				}else{

					$type =  str_replace('/', '.', strstr($_FILES['imgfile']['type'], '/'));

					$img = substr($titulo, 0, 55).$type;
				
					copy($_FILES['imgfile']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$url_path.'/assets/imagenes/'.$img);

				}

				$path_pelicula = substr($titulo, 0, 55).'.mp4';

				$r[0] = p::create(['titulo' => $param['titulo'], 'img' => $img, 'descripcion' => $param['descripcion'], 'duracion' => $param['duracion'], 'url' => $path_pelicula]);
				
				return $this->view->render($response, 'peliculas/ficha.twig', ['data' => $r]);

			}else{

	            return json_encode($valid);

	        }

		}

	}

	function edit($request, $response, $args){

		if (v::notBlank()->validate($args['id'])) {
			
			$result = p::find($args['id']);	

			if (isset($result['id'])) {
				
				$param = $request->getParsedBody();

				if (v::notBlank()->validate($param['titulo'])) {
					
					$result->update($param);

				}else{


				}

			}else{
			   $result['error'] = 'No se encuentra la pelicula';
			}
			

		}else{
			$result['error'] = 'Id invalido';
		}

		return json_encode($result);

	}

	function del($request, $response, $args){

		if(v::notBlank()->validate($args['id'])){

			$pelicula = p::find($args['id']);

			if (isset($pelicula)) {

				$pelicula->categorias()->delete();
				$pelicula->delete();

				echo 'pelicula Eliminada con exito <a href="'.$this->router->pathFor('peliculas').'">regresar</a>';
			}

		}

	}

}


?>