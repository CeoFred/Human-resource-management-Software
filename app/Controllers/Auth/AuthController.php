<?php

namespace App\Controllers\Auth;
//  import view

use App\Models\User;

use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class AuthController extends Controller

 {

public function getlogout($request,$response){

    $this->auth->logout();
    // reply with a redirect
$this->flash->addMessage('loggedout','Logged Out!');
    return $response->withRedirect($this->router->pathFor('home'));

}

public function getSignUp($request,$response){

    // renders the signup page with the view dependency
// var_dump($request->getAttribute('csrf_value'));

    return $this->view->render($response,'signup.twig');

}

// get-> reply,post->respond
        public function getSignIn($request,$response){

            return $this->view->render($response,'signin.twig');

}

                public function postSignIn($request,$response){

    $auth = $this->auth->verify(
    $request->getParam('email'),

    $request->getParam('password'));

    if($auth){


        $this->flash->addMessage('signedin',"Welcome Back!");
    return $response->withRedirect($this->router->pathFor('home'));


}
  else{

        $this->flash->addMessage('signinerror',"Opps! {$response->getParam('name')} went wrong");
        return $this->view->render($response,'signin.twig');
}


                }



                public function postSignUp($request,$response){

//validating input fields


    $Validation = $this->validator->validate($request,[
// for  email, i set a custom validation called emailAvail()
// check EmailAvail class ;

'email' => v::noWhiteSpace()->notEmpty()->email()->EmailAvail(),
'name' => v::notEmpty()->alpha(),
'password' => v::noWhiteSpace()->notEmpty()

]);





// if valiation failed redirect to the signup page,$Validation->failed() returns true or false,its
//also a method in the respect validator dependency
if($Validation->failed()){

        $this->flash->addMessage('signupfailed',"Opps! {$response->getParam('name')},something went wrong");
    return $response->withRedirect($this->router->pathFor('auth.signup'));

}


// creating a row in databse
$user = User::create([
'email' => $request->getParam('email'),
'name' => $request->getParam('name'),
'password' =>password_hash($request->getParam('password'),PASSWORD_DEFAULT)
 ]);
// sigining in the user after regiistration by just setting starting a user session
$this->auth->verify($user->email,$request->getParam('password'));

// redirect method to home page
$this->flash->addMessage('signup',"Welcome to a new World {$request->getParam('name')} ");
 return $response->withRedirect($this->router->pathFor('home'));

        }

   };
