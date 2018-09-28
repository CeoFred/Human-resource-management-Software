<?php


namespace App\Validation\Rules;

use App\Models\User;

// needs an exception class to rewrite new message,
// check macthespasswrodlException class

use Respect\Validation\Rules\AbstractRule;

class matchespassword extends AbstractRule
// AbstractRule would look for an exception folder for a file with name
// matchespasswordeException and return the new customized message
{
    protected $password;

    public function __construct($password){
$this->password =  $password;

}

    public function validate($input){

        return password_verify($input,$this->password);

    }

}
