<?php

namespace App\Models;

// import eloquent
     use Illuminate\Database\Eloquent\Model;

     class User extends Model
// ELOQUENT TAKES THE SINGULAR OF THE CLASSAME AND SEARCHES FOR THE PLURAL VERSION OF YOUR CLASSAME
{

// set this to alter the database
protected $fillable = [

    'email',
    'name',
    'password',
 'image',
];


public function setPassword($password)
{
    $this->update([
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ]);
}
// use below if class name differs from table name
    //  protected $table = 'users' ;


}
