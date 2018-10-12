<?php


namespace App\Validation;

use Respect\Validation\Validator as Respect;

use Respect\Validation\Exceptions\NestedValidationException;


class Validator {
    public $errors;

    public function validate($request, array $rules){

        foreach($rules as $field => $rule){

            try{

                $rule->setName($field)->assert($request->getParam($field));

        }

catch(NestedValidationException $e){
    $this->errors[$field] = $e->getMessages();
            }
        }
// setting errorrs for middlware to render to our views
        // $_SESSION['errors'] = $this->errors;

return $this;


    }
// checks for errors possible
    public function failed(){

    return !empty($this->errors);
}

}
