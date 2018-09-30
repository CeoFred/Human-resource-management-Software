<?php

namespace App\Validation\Rules;
  use App\Models\Admin;
use Respect\Validation\Rules\AbstractRule;
 
class AdminEmailAvail extends AbstractRule
// AbstractRule would look for an exception folder for a file with name
// EmailAvailableException and return the new customized message
{

    //   this function name is a constant,recieves the input value autommatically
    public function validate($input){
        // check if an email already exist
        return Admin::where('email', $input)->count() === 0;


    }

}
