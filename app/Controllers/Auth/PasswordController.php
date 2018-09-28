<?php

namespace App\Controllers\Auth;
//  import view

use App\Models\User;

use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class PasswordController extends Controller

 {

   public function getchangepass($request,$response) {

return $this->view->render($response,'Password.twig');

}


public function postchangepass($request,$response){

    $validation = $this->validator->validate($request,[

        'old_password' => v::noWhitespace()->notEmpty()->matchespassword($this->auth->user()->password),

        'new_password' => v::noWhitespace()->notEmpty(),

        ]);



        if($validation->failed()){

            return $response->withRedirect($this->router->pathfor('change.password'));
        }


        // die('change password');

        // call a method on the user model

     $this->auth->user()->setPassword($request->getParam('new_password'));
   $this->flash->addMessage('passwordchange','Password Was successfully changed');
    return  $response->withRedirect($this->router->pathFor('home'));

}
   };
