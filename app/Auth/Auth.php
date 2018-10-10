<?php

namespace App\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\einfo;
use App\Models\UserCv;
class Auth {
    public $userid;
    public $id;
     public $adminName;


// get all users for admin
public function adminusers(){

  return $users =   User::where('id','>', '0')
               ->orderBy('id', 'aesc')
               ->take(10)
               ->distinct()
               ->get();

    }

// checks if formdata is already uploaded
     public function counteinfo(){

          $id = User::find($_SESSION['user'])->id;
        return einfo::where('uploaded_by',$id)->first();
     }

public function countrealworkdata(){

        return count(einfo::where('id','>','0')->get());
}

public function cv(){
$id = User::find($_SESSION['user'])->id;
        return count(UserCv::where('uploaded_by',$id)->first());
    }


    public function user(){
        // returns the user details
          return User::find($_SESSION['user']);

}

        public function admindetails(){
            return Admin::find($_SESSION['admin']);
        }
// returns a count of number of rows on the einfo table
        public function Allworkdata(){
            return count(workdata::where('id','>','0')->get());

        }

        public function Allusers(){
            return count(User::where('id','>','0')->get());
        }
        public function Allcvs(){
            return count(UserCv::where('id','>','0')->get());
        }

    public function check(){

 return isset($_SESSION['user']);
//  returns true or false
    }

    public function admincheck()

    {
return isset($_SESSION['admin']);
    }


    public function averify($email,$password){
// returns the first row and returns true
        $admin = Admin::where('email',$email)->first();

   if($admin){

        if(password_verify($password,$admin->password)){

            $_SESSION['admin'] = $admin->id;

       return true;
       
              } else return false;

        }
        return false;
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

    public function adminlogout(){

        unset($_SESSION['admin']);

    }

}


