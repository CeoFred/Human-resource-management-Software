<?php

namespace App\Auth;

use App\Models\User;

class Auth {


    public function mytime(){



    }
    public function user(){
        // returns the user details
          return User::find($_SESSION['user']);


        }

    public function check(){

 return isset($_SESSION['user']);
//  returns true or false
    }


    public function verify($email,$password){
// returns the first row and returns true
        $user = User::where('email',$email)->first();

   if($user){

        if(password_verify($password,$user->password)){

            $_SESSION['user'] = $user->id;

       return true;
              } else return false;

        }
        return false;
    }

    public function logout(){
        // logout users
        unset($_SESSION['user']);
        unset($_SESSION['errors']);

    }

}


