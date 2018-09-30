<?php

namespace App\Middleware;

class OldinputMiddleware extends Middleware


   {


public function __invoke($request, $response, $next)

{

// user inputs are stored inside the old variable and is accessible in our views
    $this->container->view->getEnvironment()->addGlobal('old',$_SESSION['old']);
// ANY SUBMITTED FORMS DATA ARE GOTTEN FROM ANNYWHERE IN OUR VIEWUSING GETPARAMS() IT 
//GLOBAL VARIABLE
    $_SESSION['old'] = $request->getParams();



// return the possible next middleware
$response = $next($request,$response);
return $response;


    }

}
