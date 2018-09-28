<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;


$app->get('/','HomeController:index')->setName('home');

//only guest can access this routes
$app->group('',function(){


$this->get('/auth/signup','AuthController:getSignUp')->setName('auth.signup');
$this->post('/auth/signup','AuthController:postSignUp');
$this->get('/auth/signin','AuthController:getSignIn')->setName('auth.signin');
$this->post('/auth/signin','AuthController:postSignIn');

})->add(new GuestMiddleware($container));


// view controller for signin page,calls the authcontroller


// if anyone access any of this routes,Authmiddelware checks if you are logged in and refiects you to the signin page if you a
// are not logged in yet, so all th routes passes through the authcontroller
$app->group('',function(){

$this->get('/auth/password/change','PasswordController:getchangepass')->setName('change.password');
$this->post('/auth/password/change','PasswordController:postchangepass');
$this->get('/auth/logout','AuthController:getlogout')->setName('logout');

})->add(new AuthMiddleware($container));
// using twig view
// $app->get('/',function($request,$response){
//   return $this->view->render($response,'home.twig');
// });
