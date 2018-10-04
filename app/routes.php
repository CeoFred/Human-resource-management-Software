<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleWare;
use App\Middleware\TobeAdminMiddelWare;

$app->get('/','HomeController:index')->setName('home');




//only guest can access this routes
$app->group('',function(){


$this->get('/auth/signup','AuthController:getSignUp')->setName('auth.signup');
$this->post('/auth/signup','AuthController:postSignUp');
$this->get('/auth/signin','AuthController:getSignIn')->setName('auth.signin');
$this->post('/auth/signin','AuthController:postSignIn');

})->add(new GuestMiddleware($container));


// view controller for signin page,calls the authcontroller
$app->group('',function(){

$this->get('/auth/admin/logout','AuthController:adminLogout')->setName('admin_logout');
$this->get('/auth/admin/panel','AuthController:RenderAdminPanel')->setName('ControlPanel');

})->add(new AdminMiddleWare($container));


$app->group('',function() use ($app) {
$app->get('/auth/admin/signup','AuthController:getAdminSignUp')->setName('auth.admin.signup');
$app->post('/auth/admin/signup','AuthController:postAdminSignUp');
$app->get('/auth/admin/login','AuthController:RenderAdminLogin')->setName('auth.admin.signin');
$app->post('/auth/admin/login','AuthController:postAdminSignIn');

})->add(new TobeAdminMiddelWare($container));


// if anyone access any of this routes,Authmiddelware checks if you are logged in and refiects you to the signin page if you a
// are not logged in yet, so all th routes passes through the authcontroller
$app->group('',function(){
$this->get('/auth/user/my_cv','AuthController:getUserCv')->setName('Usercv');
$this->post('/auth/user/my_cv','AuthController:postUserCv');
$this->get('/auth/user/password/change','PasswordController:getchangepass')->setName('change.password');
$this->post('/auth/user/password/change','PasswordController:postchangepass');
$this->get('/auth/user/logout','AuthController:getlogout')->setName('logout');
$this->get('/auth/user/formdata','AuthController:getFormdata')->setName('user.formdata');
$this->post('/auth/user/formdata','AuthController:postFormdata');
$this->get('/auth/user/profile','AuthController:getUserProfile')->setName('user.profile');
$this->get('/auth/user/inbox','AuthController:getUserInbox')->setName('user.inbox');
$this->get('/auth/user/formdata/edit','AuthController:getFormdataEdit')->setName('user.update.workdata');
$this->get('/auth/user/formdata/view','AuthController:getFormdataView')->setName('user.view.workdata');

})->add(new AuthMiddleware($container));
// using twig view
// $app->get('/',function($request,$response){
//   return $this->view->render($response,'home.twig');
// });
