<?php


namespace App\Models;

// import eloquent
use Illuminate\Database\Eloquent\Model;

class department extends Model
// ELOQUENT TAKES THE SINGULAR OF THE CLASSAME AND SEARCHES FOR THE PLURAL VERSION OF YOUR CLASSAME
{

// set this to alter the database
    protected $fillable = [
'department',
    ];



// use below if class name differs from table name
    protected $table = 'departments';


}


