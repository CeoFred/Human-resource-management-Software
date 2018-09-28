<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

 class matchespasswordException extends ValidationException

 {
// reseting error messages
            public static $defaultTemplates = [
                self::MODE_DEFAULT => [
                    self::STANDARD =>'Password does not match',
                ],

            ];



 }
