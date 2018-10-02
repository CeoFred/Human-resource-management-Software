<?php

namespace App\Middleware;

class TobeAdminMiddelWare extends Middleware
 {

    public function __invoke($request,$response,$next){

        if($this->container->auth->admincheck()){

$this->container->flash->addMessage('Oga You cannot perform that action','Log in to continue');
return  $response->withRedirect($this->container->router->pathFor('ControlPanel'));

   }

$response = $next($request,$response);
return $response;

    }
}
