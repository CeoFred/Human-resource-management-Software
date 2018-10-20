<?php


namespace App\Models;

// import eloquent
use Illuminate\Database\Eloquent\Model;

class birthdays extends Model
// ELOQUENT TAKES THE SINGULAR OF THE CLASSAME AND SEARCHES FOR THE PLURAL VERSION OF YOUR CLASSAME
{


// set this to alter the database
    protected $fillable = [
'department',
'familyname',
'givenname',
'company_id',
'email_sent',
'date_of_birth',
'sms_sent',
'email',
'phonenumber',

    ];



// use below if class name differs from table name
    protected $table = 'birthdays';


}


