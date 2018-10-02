<?php

namespace App\Middleware;

class AdminMiddleWare extends Middleware
 {

    public function __invoke($request,$response,$next){

        if(!$this->container->auth->admincheck()){

$this->container->flash->addMessage('entryerror','Log in to continue');
return  $response->withRedirect($this->container->router->pathFor('auth.admin.signin'));

   }

$response = $next($request,$response);
return $response;

    }
}
