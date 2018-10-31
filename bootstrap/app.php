<?php

use Respect\Validation\Validator as v;
session_start();

require  __DIR__ . '\..\vendor\autoload.php';

\Cloudinary::config(array( 
    "cloud_name" => "ogwugo-people", 
    "api_key" => "884434965257465", 
    "api_secret" => "dk_QJWS3eBrzBWNo_xjN1RHz1AI" 
  ));

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

$container['upload_directory'] = __DIR__ . '\..\public\usercvimage';
$container['user_upload_directory'] = __DIR__ . '\..\public\img\userprofileimg';
$container['upload_directory_employees'] = __DIR__ . '\..\public\img\workdataimg';
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

'date' => date('Y'),
'admincheck' => $container->auth->admincheck(),
'admindetails' => $container->auth->admindetails(),
 'Allusers' => $container->auth->Allusers(),
// // 'cv' => $container->auth->cv(),
// 'Allcvs' => $container->auth->Allcvs(),
// 'counteinfo' => $container->auth->counteinfo(),
// 'countrealworkdata' => $container->auth->countrealworkdata(),
'countUpcomingBirthdays'=> $container->auth->countUpcomingBirthdays(),
        'getUpcomingBirthdays' => $container->auth->getUpcomingBirthdays(),
        'getWishes' => $container->auth->getWishes(),
'adminusers' => $container->auth->adminusers(),
'getNewHires' => $container->auth->getNewHires(),
        'countSoftwareMemebers' => $container->auth->countSoftwareMemebers(),
        'countMarketingDepartment' => $container->auth->countMarketingDepartment(),
        'getDepartments' => $container->auth->getDepartments(),
        'getMarketingDepartment'=>$container->auth->getMarketingDepartment(),
        'getSoftwareMembers' => $container->auth->getSoftwareMembers(),

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

// $container['csrf'] = function ($container) {
//     return new \Slim\Csrf\Guard;
// };

// add all middlewares
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldinputMiddleware($container));
// $app->add(new \App\Middleware\CsrfViewMiddleware($container));


// $app->add($container->csrf);


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
