<?php

namespace App\Models;

// import eloquent
     use Illuminate\Database\Eloquent\Model;

     class UserCv extends Model
// ELOQUENT TAKES THE SINGULAR OF THE CLASSAME AND SEARCHES FOR THE PLURAL VERSION OF YOUR CLASSAME
{

// set this to alter the database
protected $fillable = [

    'email',
    'firstname',
    'lastname',
    'gender',
    'adddress',
    'phonenumber',
    'work-title',
    'company',
    'city-country',
    'company-description',
    'workstart',
    'workstop',
    'iscurrentlyworking',
    'workTasks',
    'skills',
    'studyprogramme',
    'institution',
    'schoolstart',
    'schoolend',
    'city-country-cgpa',
    'course',
    'image',
    'uploaded_by'

];

// use below if class name differs from table name
      protected $table = 'cv' ;


}
