<?php  
namespace App\Middleware;
/**
 * 
 */
class Auth extends Middleware 
{
	
	public function __invoke($request, $response, $next)
	{
		$route = $request->getAttribute('route');

        if (isset($route)) {
        	$routeName = $route->getName();
	        $groups = $route->getGroups();
	        $methods = $route->getMethods();
	        $arguments = $route->getArguments();
        }
        
        
        # Define routes that user does not have to be logged in with. All other routes, the user
        # needs to be logged in with.
        $publicRoutesArray = array(
                '',
                'login',
                'post-login',
                'register',
                'forgot-password',
                'register-post',
                'peliculas',
                'series',
                'login.post'
            );

        $adminRoutesArray = array(
                'add.contenido',
                'pelicula.add',
                'pelicula.del'
            );

            if (!isset($_SESSION['USER']) && !in_array(@$routeName, $publicRoutesArray) && isset($route))
            {
                // redirect the user to the login page and do not proceed.
               
                if (isset($routeName)) {
                    if (isset($arguments)) {
                        $url = $this->router->pathFor('login')."?url=".$this->router->pathFor($routeName, $arguments);
                    }else{
                        $url = $this->router->pathFor('login')."?url=".$this->router->pathFor($routeName);
                    }
                    
                }else{
                    $url = $this->router->pathFor('login');
                }
                
                $response = $response->withRedirect($url);
            }
            else
            {   

                if (@$_SESSION['admin'] == 0 && in_array(@$routeName, $adminRoutesArray)) {
                    
                    $response = $response->withRedirect($this->router->pathFor('login'));
                    
                }else{

                    // Proceed as normal...
                    $response = $next($request, $response);

                }
                
            }

            return $response;
	}

	public function checkAdmin($request, $response, $next){

			if (@$_SESSION['admin'] == 0) {
                    
                $response = $response->withRedirect($this->router->pathFor('login'));
                    
            }else{

                    // Proceed as normal...
              	$response = $next($request, $response);

            }

           	return $response;
	}

}

?>