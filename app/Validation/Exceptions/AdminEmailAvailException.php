<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

 class AdminEmailAvailException extends ValidationException

 {
// reseting error messages
            public static $defaultTemplates = [
                self::MODE_DEFAULT => [
                    self::STANDARD =>'An admin Already exist with that email',
                ],

            ];

            

 }
