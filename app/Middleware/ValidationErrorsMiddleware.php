<?php


namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware


   {


public function __invoke($request, $response, $next)

   {
// setting a session globally to all our , attaching errors to all our views
$this->container->view->getEnvironment()->addGlobal('errors',$_SESSION['errors']);
unset($_SESSION['errors']);

// return the possible next middleware
$response = $next($request,$response);
return $response;

    }

}
