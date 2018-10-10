<?php


namespace App\Models;

// import eloquent
     use Illuminate\Database\Eloquent\Model;

     class einfo extends Model
// ELOQUENT TAKES THE SINGULAR OF THE CLASSAME AND SEARCHES FOR THE PLURAL VERSION OF YOUR CLASSAME
{

// set this to alter the database
protected $fillable = [
'company_id',
    'email',
    'givenname',
 'familyname',
 'phonenumber',
 'gender',
 'state',
 'lga',
 'image',
 'address',
 'maritalstatus',
 'date_of_birth',
 'department',
 'position',
 'date_of_start',
 'employment_mode',
 'emergency_contact_name',
 'emergency_contact_phone',
 'emergency_contact_relationship',
 'refree_contact_name',
 'refree_contact_phone',
 'refree_contact_address',
 'emergency_contact_address',
 'refree_contact_relationship',
 'uploaded_by',
];



// use below if class name differs from table name
      protected $table = 'einfo' ;


}


