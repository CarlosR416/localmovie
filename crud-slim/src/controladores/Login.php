<?php  
namespace App\Controladores;
use App\Modelos\ModeloUsuario as users;
use Respect\Validation\Validator as v;

/**
 * 
 */
class Login extends Controlador
{

	function index($request, $response, $args){

		//die(var_dump($request->getParam('url')));
        session_destroy();
        return $this->view->render($response, 'login/index.twig');



	}

	function check($request, $response, $args){

		$param = $request->getParsedBody();

		$valid = [
            // verifica que la id sea un entero
            v::stringType()->length(2)->validate($param['user']),
			
            // verifica que se reciba una cadena de al menos longitud 2
            v::notBlank()->validate($param['password']),
            
			// verifica que se reciba un correo
            //v::email()->validate($param['correo']),
            
			// verifica que no esté en blanco la contraseña
            //v::notBlank()->validate($param['clave_acceso'])
        ];

        if (!in_array(false, $valid)) {
        	
        	$user = users::where('user', $param['user'])->first();

        	if ($user['password'] == $param['password']) {

        		$_SESSION['USER'] = $user['user'];
                $_SESSION['ID_USER'] = $user['id'];
                $_SESSION['admin'] = $user['admin'];

        		$response = ['code' => 200, 'error' => ''];

                if ($param['recorder'] == 'true') {
                    
                    $response['codeRecorder'] = 'mmkjl';

                   // generar uno aleatorio
                   //$remember = md5(uniqid(mt_rand(), true));

                   // colocar el tiempo que quieras
                   //setcookie("remember", $response['codeRecorder'], time()+3600, "/");

                }
        	
            }else{

                $response = ['code' => 500, 'error' => 'Contraseña Errada'];
            }

        }else{

            $response = ['code' => 500, 'error' => 'Campos Errados'];

        }
        
		return json_encode($response);
	}

    function logout($request, $response){

        session_destroy();

        return $response->withRedirect($this->router->pathFor('peliculas'));

    }
}


?>