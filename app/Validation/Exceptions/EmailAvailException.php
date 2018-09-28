<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

 class EmailAvailException extends ValidationException

 {
// reseting error messages
            public static $defaultTemplates = [
                self::MODE_DEFAULT => [
                    self::STANDARD =>'Email is Already taken',
                ],

            ];

            

 }
