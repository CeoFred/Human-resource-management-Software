<?php

namespace App\Middleware;

class OldinputMiddleware extends Middleware


   {


public function __invoke($request, $response, $next)

{

$this->container->view->getEnvironment()->addGlobal('old',$_SESSION['old']);
$_SESSION['old'] = $request->getParams();



// return the possible next middleware
$response = $next($request,$response);
return $response;


    }

}
