<?php

use Respect\Validation\Validator as v;
session_start();

require  __DIR__ . '\..\vendor\autoload.php';

// create new app with changaes to configuration settings
$app = new \Slim\App([
    'setting' => [

        'displayErrorDetails'=>true,
        // database connection
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slim_app',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ]
]);

// creating a container to fetch dependencies
$container = $app->getContainer();

// adding flashmessages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['auth'] = function($container){
    //pass view dependecy to Home controller constuctor function
    return new \App\Auth\Auth;
};

$container['PasswordController'] = function($container){
    return new  \App\Controllers\Auth\PasswordController($container);
};
//bind view to slims container, fetching view dependency
$container['view'] =  function ($container) {
// thr first argumaents tells where to fetch our view,the other is addition developement settings
// creating a slim view Twig instace to use its methods
$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[
        'cache' => false,]);

//extension generates urls to different routes within out view
    $view->addExtension(new \Slim\Views\TwigExtension(
        // router to generate url for links within our views
        $container->router,
        // pull in the currrent url
        $container->request->getUri()

    ));
// setting auth class to the global scope ,making it
// an accessible view variable in our views templates
    $view->getEnvironment()->addGlobal('auth',[

        // checks if a session is stored
        // on our view templates, it  basically returns true or false, nothing serious
'check' => $container->auth->check(),
        // querying the database once and setting it to check global view variable too be used on
        // our views template,to access it in our twig templates, use auth.user.{row}
'user' => $container->auth->user(),
'date' => date('Y')

// 'welcome' => 'Welcome Back dummy! the time is',
// 'time' => '17:20pm'

]);
    // add flash to global to be used on our twig
    $view->getEnvironment()->addGlobal('flash',$container->flash);


    return $view;
  };



$container['HomeController'] = function($container){
    //pass view dependecy to Home controller constuctor function
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
    //pass view dependecy to Home controller constuctor function
    return new \App\Controllers\Auth\AuthController($container);
};

$container['Auth'] = function($container){
    //pass view dependecy to Home controller constuctor function
    return new \App\Auth\Auth($container);
};

$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};

// add all middlewares
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldinputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));


$app->add($container->csrf);


// start eloquent

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['setting']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){

    return $capsule;
};

// Respect/validator dependency made available to other dependencies
$container['validator'] = function($container){
    return new App\Validation\Validator;
};




/*

SIMPLE ROUTE INSTEAD OF USING CONTROLLER
$app->get('/', function($request,$response){
return 'Home';
}
})
*/


// setting our personal validation rules
v::with('App\\Validation\\Rules\\');
require __DIR__ . '\..\app\routes.php';
