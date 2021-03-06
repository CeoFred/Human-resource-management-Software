<?php

namespace App\Controllers\Auth;
//  import view
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

use App\Models\einfo;

use App\Models\User;

use App\Models\Admin;

use App\Models\birthdays;

use App\Controllers\Controller;

use App\Models\department;

use Respect\Validation\Validator as v;

use \Cloudinary\Uploader as uploader;

class AuthController extends Controller
 {

public function uploadEmployeePassportViaUrl($req,$res){

    $file = $req->getParam('Url');
    if (empty($file)) {
        return 'Empty Url';
    }else{

        $img = uploader::upload($file,array("width"=>200, "height"=>200,
         "folder" => "employeePassports","crop"=>"pad","quality"=>"auto:low"));
        $url = $img['secure_url']; 
    }
           
                 
//    return   $url;

$update = einfo::where('company_id', $req->getParam('company_id'))->update([
    'image' => $url
    ]);
            if($update){
                
return 'Upload was successful and uploaded,Reloading.....'; 
                // return $filename;
            }else{
                return 'failed to upload to url';
            }

        }
    


//         // send automated wishes
//         public function sendBirthdayWishesAttempt(){

//             $today = date('Y-m-d') ;
    
//             $check =  einfo::where('date_of_birth',$today)->get();
             
//             if(count($check) > 0){
//             //  return count($check);
//             //     return $check;
//                 $today = date('Y-m-d') ;
    
//             for($i = 0;$i < count($check);$i++){

//                 // check if a row for the celebrant already exists in the birthdays table
//            $checkRow = birthdays::where('date_of_birth',$today)
           
//            ->get();  
//         //    echo count($checkRow);    
//     }

//     if(count($checkRow) > 0){

//         // print count($checkRow);
        
//          for($i = 0;$i < count($checkRow);$i++){

//             $check = $checkRow[$i]->email_sent;
//             // check if email is not sent
//             if($check == 0){
                
//                echo 'email has not been sent for '.$checkRow[$i]->givenname.'<br>';
               
// $mail = new PHPMailer(true);   
//                            // Passing `true` enables exceptions
// try {
    
//     $mail->SMTPDebug = 0;                                 // Enable verbose debug output
// $mail->isSMTP();                                      // Set mailer to use SMTP
// $mail->Host = 'sweetpea.hostnownow.com';  // Specify main and backup SMTP servers
// $mail->SMTPAuth = true;                               // Enable SMTP authentication
// $mail->Username = 'activate@yourhomefuto.com.ng';                 // SMTP username
// $mail->Password = 'messilo18_';                           // SMTP password
// $mail->SMTPSecure = 'ssl';
// $mail->SMTPAutoTLS = true;
// // Enable TLS encryption, `ssl` also accepted
// $mail->Port = 465;                                    // TCP port to connect to
// //Recipients

// $mail->SMTPOptions = array(
// 'ssl' => array(
// 'verify_peer' => false,
// 'verify_peer_name' => false,
// 'allow_self_signed' => true
// )
// );

//             $mail->setFrom('family@ogwugo.com', 'Ogwugo.com');
//             $mail->addAddress($checkRow[$i]->email);     // Add a recipient
//             // $mail->addAddress('ellen@example.com');               // Name is optional
//             $mail->addReplyTo('celebrations@ogwugo.com', 'PartyTime');
//             $mail->isHTML(true);                                  // Set email format to HTML
//             $mail->Subject = 'Happy Birthday!!';
//             $mail->Body    = 'From ogwugo we wish you a happy birthday!Do enjoy your day.';
//             // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//             if($mail->send()){
//             echo 'Hurray!!Wishes were successfully sent to '.$checkRow[$i]->email;
//             birthdays::where('company_id',$checkRow[$i]->company_id)->update([
// 'email_sent' => 1
//             ]);
//             }

//             }
//             catch (Exception $e) {
//             return 'Message could not be sent. Mailer Error:' . $mail->ErrorInfo;
//             }

//                        }else{
//                            echo '<p style="display:none">'.'birthday email alredy sent to '.$checkRow[$i]->givenname.'</p>'.'<br>';
//                        }

//          }
        

//      }elseif(empty($checkRow) == 0){
//         //  return $checkRow;
//         $today = date('Y-m-d') ;
    
//         $cr =  einfo::where('date_of_birth',$today)->get();
    
//             for($i = 0;$i < count($cr);$i++){

//     $newRow =     birthdays::create([
//             'email' => $cr[$i]->email,
//             'department' => $cr[$i]->department,
//             'date_of_birth' => $cr[$i]->date_of_birth,
//             'company_id' => $cr[$i]->company_id,
//             'email_sent' => 0,
//             'sms_sent' => 0,
//             'phone' => $cr[$i]->phonenumber,
//             'givenname' => $cr[$i]->givenname,
//             'familyname' => $cr[$i]->familyname
//             ]);
        
            
//      }

//     }
// }
//     else{
//         echo '<p style="display:none">'.'no birthdays today'.'</p>';
//     }
//         }
    

    public function sendAutpoWishes($req,$res){
$this->view->render($res,'sendWish.twig');
    }

     public function sendWish($req,$res){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'sweetpea.hostnownow.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'activate@yourhomefuto.com.ng';                 // SMTP username
    $mail->Password = 'messilo18_';                           // SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAutoTLS = true;
    // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    //Recipients

    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

    $mail->setFrom('family@ogwugo.com', 'Ogwugo.com');
    $mail->addAddress($req->getParam('email'));     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('celebrations@ogwugo.com', 'PartyTime');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Happy Birthday!!';
    $mail->Body    = $req->getParam('message');
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if($mail->send()){
        return 'Hurray!!Wishes were successfully sent';
    }
    } catch (Exception $e) {
        return 'Message could not be sent. Mailer Error:' . $mail->ErrorInfo;
        }
     }

public function sendBirthdayWishes($req,$res){
$id = $req->getParam('id');
$details = einfo::where('company_id',$id)->first();
        $this->view->getEnvironment()->addGlobal('celebrantsId', $details);
 return   $this->view->render($res,'sendBirthdayWishes.twig');

}
        public function searchDept($req, $res)
    {
        $name = $req->getParam('query');
        $department = department::where('department', $name)->get();
if($department){
        foreach ($department as $department) {
            echo "<p onclick='showMembers($department->id)'>";
            echo '<i class="fas fa-home"></i>' . ' ' . $department->department;
            echo '</p>';
                echo '</br>';
        }
    }

    }


public function addNewDepartment($req,$res){
    
    $Validation = $this->validator->validate($req,[

        'dept' => v::notEmpty()->alpha()
        ]);

        if(!$Validation->failed()){
        
       $addNewDept = department::create([
        'department' => $req->getParam('dept')
    ]);
    if($addNewDept){
        return 'successfully added a new department';
    }else{
        return 'Failed to created a new department';
    }
        }else{
            return json_encode($_SESSION['errors']);
        }


}

public function getDepartments($req, $res){
    $this->view->render($res,'departments.twig');
}

// search for employess
public function searchEmployee($req,$res){

    $name = $req->getParam('query');
 $einfo =   einfo::where('givenname','like', "%$name%")
 ->orWhere('familyname','like' ,"%$name%")
 ->get();
if($einfo){
    foreach($einfo as $employee){
        echo "<a href='/auth/admin/employee?id={$employee->company_id}' style='color:#000'>";
 echo  '<i class="fas fa-user"></i>'.' ' .$employee->familyname.' '.$employee->givenname;
 echo '</a>';
 echo '<br/>';
     }
}
    

}


// update emoloyee refree information
 public function updateEmployeeRefreenInformation($req,$res){
      
    $Validation = $this->validator->validate($req,[

        'fullname' => v::notEmpty()->alpha(),
        'address' => v::notEmpty()->alnum(),
        'phone' => v::notEmpty()->digit('+'),
        'relationship' => v::alpha()->notEmpty()


    
    
        ]);

        if(!$Validation->failed()){
         
    $employeeid = $req->getParam('company_id');

    $update = einfo::where('company_id', $employeeid)->update([

        'refree_contact_name' => $req->getParam('fullname'),
        'refree_contact_address' => $req->getParam('address'),
        'refree_contact_phone' => $req->getParam('phone'),
        'refree_contact_relationship' => $req->getParam('relationship'),

    ]);

    if ($update) {
        return 'success';

    } else {

        return 'failed';
    }
        }
            else{

                return json_encode($_SESSION['errors']);
                
            }

 }


// upadate employee emergency contact info

 public function updateEmployeeEmergencyInfo($req,$res){



 $Validation =   $this->validator->validate($req,[
'fullname' => v::alpha(),
'address' => v::notEmpty()->alnum(),
'phone' => v::notEmpty(),
'relationship' => v::notEmpty()->alpha()
    ]);
    if(!$Validation->failed()){


        $employeeid =  $req->getParam('company_id');

        $update = einfo::where('company_id', $employeeid)->update([

            'emergency_contact_name' => $req->getParam('fullname'),
            'emergency_contact_address' => $req->getParam('address'),
            'emergency_contact_phone' => $req->getParam('phone'),
            'emergency_contact_relationship' => $req->getParam('relationship'),

            ]);

        if ($update) {
            return 'success';

        } else {

            return 'failed';
        }

    }else{
        return json_encode($_SESSION['errors']);
    }
}
// update employee company info
public function updateEmployeeWorkInfo($req,$res) {
        $Validation = $this->validator->validate($req,[
            
        'position' => v::alpha()->notEmpty(),
        'department' => v::alpha()->notEmpty(),
        'dateOfEmployment' => v::notEmpty()->date(), 
        'currenStatus' => v::digit()->notEmpty(),
        'employmentMode' => v::alpha()->notEmpty(),

        ]);
        if(!$Validation->failed()){


            $employeeid = $req->getParam('employee_id');
            $update = einfo::where('company_id', $employeeid)->update([

            'position' => $req->getParam('position'),
                'date_of_start' => $req->getParam('dateOfEmployment'),
                'department' => $req->getParam('department'),
                'currentStatus' => $req->getParam('currenStatus'),
                'employment_mode' => $req->getParam('employmentMode'),
              ]);

            if ($update) {
                return 'success';

            } else {

                return 'failed';
            }

        }else{
            return json_encode($_SESSION['errors']);
        }

}


     public function viewEmployee($req,$res){
    //  var_dump($req->getParam('id'));
        $userid = $req->getParam('id');
$userprofile = einfo::where('company_id',$userid)->first();
$this->view->getEnvironment()->addGlobal('employeedata', $userprofile);
// $_SESSION['currentemployeeid'] = employeedata.company_id;
return $this->view->render($res,'employeedata.twig');

    }


     public function uploadEmployeePassport($req,$res){

    

        $uploadedFiles = $req->getUploadedFiles();
        $uploadedFile = $uploadedFiles['passport'];
    
         $file = $uploadedFiles['passport']->file;

  
   if (empty($file)) {
            return 'No File was selected';
        }
        // if($uploadedFile->getClientMediaType() !== 'image/png' || $uploadedFile->getClientMediaType() !== 'image/jpeg'){
        //     return 'only jpeg and png files are allowed';
        // }
        if($uploadedFile->getSize() > 100000000){
            return 'File too large';
        }elseif ($uploadedFile->getError() === UPLOAD_ERR_OK) {

            $img =   uploader::upload($file, array("width"=>200, "height"=>200, "folder" => "employeePassports","crop"=>"pad","quality"=>"auto:low"));
            
$url = $img['secure_url'];
  
  if($url) {

    $update = einfo::where('company_id', $req->getParam('company_id'))->update([
        'image' => $url
        
                ]);
                if($update){
                    
  return 'Upload was successful,refreshing....'; 
                    // return $filename;
                }else{
                    return 'failed';
                }

  }else{
      return 'could not upload to cloud';
  }
  
            
  
            }    
        

    }

    // UPDATE USER WORK INFO
    public function update_winfo($req,$res){

        $update = einfo::where('uploaded_by', $this->auth->user()->id)->update([

            'department' => $req->getParam('department'),
            'position' => $req->getParam('position'),
            'date_of_start' => $req->getParam('dateOfEmployment'),
            'employment_mode' => $req->getParam('employmenMode'),

            ]);

        if ($update) {
            return 'success from controller';
        } else {
            return 'failedfrom controller';
        }


    }

// update user personal info
public function update_pinfo($req,$res) {
    
$Validation = $this->validator->validate($req,[
'email' => v::notEmpty()->email(),
'state' => v::notEmpty()->alpha(),
'lga' => v::notEmpty()->alpha(),
'dateOfBirth' => v::notEmpty()->date(), 
'address' => v::notEmpty()->alnum(),
'familyname' => v::notEmpty()->alpha(),
'givenname' => v::notEmpty()->alpha(),
'maritalstatus' => v::notEmpty()->alpha(),
'phonenumber' => v::notEmpty()->phone()->digit('+')

]);

if(!$Validation->failed()){
    $employeeid = $req->getParam('employee_id');
    $update = einfo::where('company_id', $employeeid)->update([

        'email' => $req->getParam('email'),
        'givenname' => $req->getParam('givenname'),
        'familyname' => $req->getParam('familyname'),
        'address' => $req->getParam('address'),
        'state' => $req->getParam('state'),
        'lga' => $req->getParam('lga'),
        'phonenumber' => $req->getParam('phonenumber'),
         'date_of_birth' => $req->getParam('dateOfBirth'),
        'maritalstatus' => $req->getParam('maritalstatus')
    ]);

    if ($update) {
        return 'success';

    } else {

        return 'failed';
    }


}else{
    
    return json_encode($_SESSION['errors']);

}
}
    // get all users in the admin panel
public function getEmployees($req,$res){

$this->view->render($res,'allemployees.twig');

}

// rennder view for editing formdata
    public function getFormdataEdit($req,$res){

        $this->flash->addMessage('alertonedit','Hello,you are in editing mode.');
$this->view->render($res,'editworkdata.twig');

    }
    // update information
    public function postFormdataEdit($req,$res){


        // validate data
        $Validation = $this->validator->validate($req,[
                'email' => v::noWhiteSpace()->notEmpty()->email(),
                'givenname' => v::notEmpty()->alpha(),
                'familyname' => v::notEmpty()->alpha(),
                'address' => v::notEmpty(),
                'phonenumber' => v::noWhiteSpace()->notEmpty()->numeric(),
                'gender'=> v::notEmpty(),
                'state' => v::notEmpty()->alpha(),
                'lga' => v::notEmpty()->alpha(),
                'maritalstatus' => v::notEmpty()->alpha(),
                'date_of_birth' => v::date(),
                'department' => v::notEmpty()->alpha(),
                'position' => v::notEmpty()->alpha(),
                'date_of_start' => v::notEmpty()->date(),
                'employment_mode' => v::alpha(),
                'emergency_contact_name' => v::notEmpty()->alpha(),
                'emergency_contact_phone' => v::notEmpty()->numeric(),
                'emergency_contact_relationship' => v::alpha()->notEmpty(),
                 'refree_contact_phone' => v::numeric()->notEmpty(),
                'refree_contact_name' => v::alpha()->notEmpty(),
                'emergency_contact_address'=> v::notEmpty()->alnum(),
                'refree_contact_address' => v::notEmpty()->alpha(),
                'refree_contact_relationship' => v::notEmpty()->alpha(),

]);

if(!$Validation->failed()){

    $directory = $this->upload_directory_employees;
       $uploadedFiles = $req->getUploadedFiles();
  $uploadedFile = $uploadedFiles['image'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
         $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    }

                            $update = einfo::where('uploaded_by', $this->auth->user()->id)->update([
                'givenname' => $req->getParam('givenname'),
                'familyname' => $req->getParam('familyname'),
                'uploaded_by' => $this->auth->user()->id,
                'image' => $filename,
                'phonenumber' => $req->getParam('phonenumber'),
                'gender' => $req->getParam('gender'),
                'state' => $req->getParam('state'),
                'lga'=> $req->getParam('lga'),
                'address' => $req->getParam('address'),
                'maritalstatus' => $req->getParam('maritalstatus'),
                'date_of_birth'=> $req->getParam('date_of_birth'),
                'department'=> $req->getParam('department'),
                'position'=> $req->getParam('position'),
                'date_of_start'=> $req->getParam('date_of_start'),
                'employment_mode'=> $req->getParam('employment_mode'),
                'emergency_contact_name'=> $req->getParam('emergency_contact_name'),
                'emergency_contact_phone'=> $req->getParam('emergency_contact_phone'),
                'emergency_contact_relationship'=> $req->getParam('emergency_contact_relationship'),
                'refree_contact_name'=> $req->getParam('refree_contact_name'),
                'refree_contact_phone'=> $req->getParam('refree_contact_phone'),
                'refree_contact_address'=> $req->getParam('refree_contact_address'),
                'emergency_contact_address'=> $req->getParam('emergency_contact_address'),
                'refree_contact_relationship'=> $req->getParam('refree_contact_relationship'),]);
                if($update){


$this->flash->addMessage('workupdated','Update was successfull');
            return $res->withRedirect($this->router->pathFor('user.formdata'));

                    }else{
$this->flash->addMessage('worknotupdated','Opps! We could not updated your record,try again');
            return $res->withRedirect($this->router->pathFor('user.update.workdata'));

                }

            }else{

$this->flash->addMessage('worknotupdated','Opps! Validation Failed,try again');
            return $res->withRedirect($this->router->pathFor('user.update.workdata'));

            }

            }

// rennder view for formdata
    public function getFormdataView($req,$res){


        $this->flash->addMessage('alertonview','Hello,you are in viewing mode');
$this->view->render($res,'viewworkdata.twig');
    }

    //validate and submit workdata
public function postFormdata($req,$res){
       $Validation = $this->validator->validate($req,[
                'email' => v::noWhiteSpace()->notEmpty()->email(),
                'givenname' => v::notEmpty()->alpha(),
                'familyname' => v::notEmpty()->alpha(),
                'address' => v::notEmpty(),
                'phonenumber' => v::noWhiteSpace()->notEmpty()->numeric(),
                'gender'=> v::notEmpty(),
                'state' => v::notEmpty()->alpha(),
                'lga' => v::notEmpty()->alpha(),
                'maritalstatus' => v::notEmpty()->alpha(),
                'date_of_birth' => v::date(),
                'department' => v::notEmpty()->alpha(),
                'position' => v::notEmpty()->alpha(),
                'date_of_start' => v::notEmpty()->date(),
                'employment_mode' => v::alpha(),
                'emergency_contact_name' => v::notEmpty()->alpha(),
                'emergency_contact_phone' => v::notEmpty()->numeric(),
                'emergency_contact_relationship' => v::alpha()->notEmpty(),
                 'refree_contact_phone' => v::numeric()->notEmpty(),
                'refree_contact_name' => v::alpha()->notEmpty(),
                'emergency_contact_address'=> v::notEmpty()->alpha(),
                'refree_contact_address' => v::notEmpty()->alpha(),
                'refree_contact_relationship' => v::notEmpty()->alpha(),

]);

// if validation failed ,redirect
        if($Validation->failed()){
            return $res->withRedirect($this->router->pathFor('user.formdata'));
        }
else{
         $directory = $this->upload_directory_employees;
       $uploadedFiles = $req->getUploadedFiles();
  $uploadedFile = $uploadedFiles['image'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
         $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    }

       $workdataupload = einfo::create([
'email' => $req->getParam('email'),
'givenname' => $req->getParam('givenname'),
'familyname' => $req->getParam('familyname'),
'uploaded_by' => $this->auth->user()->id,
'image' => $filename,
'phonenumber' => $req->getParam('phonenumber'),
'gender' => $req->getParam('gender'),
'state' => $req->getParam('state'),
'lga'=> $req->getParam('lga'),
'address' => $req->getParam('address'),
'maritalstatus' => $req->getParam('maritalstatus'),
'date_of_birth'=> $req->getParam('date_of_birth'),
'department'=> $req->getParam('department'),
'position'=> $req->getParam('position'),
'date_of_start'=> $req->getParam('date_of_start'),
'employment_mode'=> $req->getParam('employment_mode'),
'emergency_contact_name'=> $req->getParam('emergency_contact_name'),
'emergency_contact_phone'=> $req->getParam('emergency_contact_phone'),
'emergency_contact_relationship'=> $req->getParam('emergency_contact_relationship'),
'refree_contact_name'=> $req->getParam('refree_contact_name'),
'refree_contact_phone'=> $req->getParam('refree_contact_phone'),
'refree_contact_address'=> $req->getParam('refree_contact_address'),
'emergency_contact_address'=> $req->getParam('emergency_contact_address'),
'refree_contact_relationship'=> $req->getParam('refree_contact_relationship'),
          ]);

          if($workdataupload){
$this->flash->addMessage('signedin','Congratualtions! Form was submitted successfully');
              return $res->withRedirect($this->router->pathFor('user.profile'));
        }else{

$this->flash->addMessage('loggedout','Opps! Sorry, something went wrong,try again');
             return $res->withRedirect($this->router->pathFor('user.formdata'));

          }
}
}

public function getFormdata($req,$res){
    $this->view->render($res,'workdata.twig');


}


public function getUserProfile($req,$res){

    $this->view->render($res,'profile.twig');
}

public function postUserCv($req,$res){

        $Validation = $this->validator->validate($req,[
                'email' => v::noWhiteSpace()->notEmpty()->email(),
                'firstname' => v::noWhiteSpace()->notEmpty()->alpha(),
                'lastname' => v::noWhiteSpace()->notEmpty()->alpha(),
                'address' => v::noWhiteSpace()->notEmpty(),
                'phonenumber' => v::noWhiteSpace()->notEmpty()->numeric(),
                'gender'=> v::notEmpty(),
                'worktitle' => v::notEmpty()->alpha(),
                'company' => v::notEmpty()->alpha(),
                'cityCounty' => v::notEmpty()->alpha(),
                'companydescription' => v::alpha(),
                'workstart' => v::notEmpty()->date(),
                'workstop' => v::notEmpty()->date(),
                'workTasks' => v::notEmpty()->alpha(),
                'skills' => v::alpha(),
                'studyprogramme' => v::notEmpty()->alpha(),
                'institution' => v::notEmpty()->alpha(),
                'schoolstart' => v::date()->notEmpty(),
                'schoolend' => v::date()->notEmpty(),
                'course'=> v::notEmpty()->alpha(),
]);

        // if validation failed ,redirect
        if($Validation->failed()){
            return $res->withRedirect($this->router->pathFor('Usercv'));
        }
else {

    // upload cv
      $directory = $this->upload_directory;
       $uploadedFiles = $req->getUploadedFiles();
  $uploadedFile = $uploadedFiles['image'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
         $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    }
       $cvuploaded = UserCv::create([
'email' => $req->getParam('email'),
'firstname' => $req->getParam('firstname'),
'lastname' => $req->getParam('lastname'),
'uploaded_by' => $this->auth->user()->id,
'image' => $filename,
'phonenumber' => $req->getParam('phonenumber'),

          ]);

          if($cvuploaded){

$this->flash->addMessage('loggedout','Congratualtions! Resume was uploaded successfully');
              return $res->withRedirect($this->router->pathFor('Usercv'));
          }


}



}


    public function getUserCv($req,$res){
  return $this->view->render($res,'user_cv.twig');
}


    public function getAdminSignUp($request,$response)

    {
 return $this->view->render($response,'adminsignup.twig');

    }

    public function postAdminSignUp($request,$response){

        $Validation = $this->validator->validate($request,[
'email' => v::noWhiteSpace()->notEmpty()->email()->AdminEmailAvail(),
'fullname' => v::notEmpty()->alpha(),
'password' => v::noWhiteSpace()->notEmpty()
        ]);

        // if validation failed ,redirect
        if($Validation->failed()){
            return json_encode($_SESSION['errors']);
        }
$id = 'UGARSOFT-'.str_shuffle(123456789);
// creating a new row
       $Admin = Admin::create([
'email' => $request->getParam('email'),
'name' => $request->getParam('fullname'),
'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
'UGARSOFT_ID'=> $id,
          ]);

if($Admin){
          return 'Admin account created,try logging in';

 }else{
     return 'Cound not create an admin account!';
 }
    }


public function RenderAdminLogin($req,$res){
return  $this->view->render($res,'admin_login.twig');

}



public function RenderAdminPanel($req,$res){

    return  $this->view->render($res,'home.twig');

}





public function getlogout($request,$response){

    $this->auth->logout();
    // reply with a redirect
$this->flash->addMessage('loggedout','Logged Out!');
    return $response->withRedirect($this->router->pathFor('home'));

}

public function addEmployee($request,$response){

    return $this->view->render($response, 'addEmployee.twig');

}

// get-> reply,post->respond
        public function getSignIn($request,$response){

            return $this->view->render($response,'signin.twig');

}



public function adminLogout($req,$res){

      $this->auth->adminlogout();
// $this->flash->addMessage('loggedout','Logged Out!');
    return $res->withRedirect($this->router->pathFor('auth.admin.signin'));

}

public function postAdminSignIn($request,$response){
if(empty($request->getParam('password'))){
return 'Password field left empty';
}
if(empty($request->getParam('email'))){
    return 'Email field left empty';
    }
    $auth = $this->auth->averify(
    $request->getParam('email'),

    $request->getParam('password'));

    if($auth){

    //     $this->flash->addMessage('signedin',"Welcome Back!");
    // return $response->withRedirect($this->router->pathFor('ControlPanel'));
    return 'Login credentials cofirmed. Redirecting...';
}
  else{

        // $this->flash->addMessage('signinerror',"Opps! something went wrong");
        // return $response->withRedirect($this->router->pathFor('auth.admin.signin'));
        return 'Invalid login credentials';

}

                }


public function postSignIn($request,$response){

    $auth = $this->auth->verify(
    $request->getParam('email'),

    $request->getParam('password'));

    if($auth){


        $this->flash->addMessage('signedin',"Welcome Back!");
    return $response->withRedirect($this->router->pathFor('home'));


}
  else{

        $this->flash->addMessage('signinerror',"Opps! something went wrong");
        return $this->view->render($response,'signin.twig');
}

                }



                public function postAddEmployee($request,$response){

//validating input fields for new users

 
     $Validation = $this->validator->validate($request,[

 'email' => v::noWhiteSpace()->notEmpty()->email()->vail(),
 'givenname' => v::notEmpty()->alpha(),
 'familyname' => v::alpha()->notEmpty(),
 'gender' => v::alpha()->notEmpty(),
 'department' => v::alpha()->notEmpty(),
 'dateOfBirth' => v::notEmpty()->date(),
 
 ]);


 if($Validation->failed()){

    
     return json_encode($_SESSION['errors']) ;

 }else{
 
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {

                                                            // Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'sweetpea.hostnownow.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'activate@yourhomefuto.com.ng';                 // SMTP username
    $mail->Password = 'messilo18_';                           // SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAutoTLS = true;
    // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    //Recipients

    $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

    $mail->setFrom('fredd@ogwugo.com', 'Ogwugo.com');
    $mail->addAddress($request->getParam('email'), $request->getParam('familyname'));     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('ogwugopeople@ogwugo.com', 'Welcome!!');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Welcome';
    $mail->Body    ="Hello,". $request->getParam('givenname').'<br>'."you have been successfully created your profile with us.".'<br>'.'Fred.';
    $mail->AltBody = 'Hello,you have been successfully created your profile with us.';
    $mail->send();

// add employee
$company_id = 'UGARSOFT_ID' . str_shuffle('123456789');

            $workdataupload = einfo::create([

                'email' => $request->getParam('email'),
                'givenname' => $request->getParam('givenname'),
                'familyname' => $request->getParam('familyname'),
                'company_id' => $company_id,
                 'gender' => $request->getParam('gender'),
                 'department' => $request->getParam('department'),
                 'date_of_birth' => $request->getParam('dateOfBirth'),

                 ]);
      
    $new =  department::where('department', $request->getParam('department'))->first();
    $num =   $new->Members;
   $newNum =  ++$num;
          $departmentStatus =  department::where('department',$request->getParam('department'))
          ->update(['Members' => $newNum]);
   return $departmentStatus ?  'success' : 'failed' ;

}
 catch (Exception $e) {
    return 'Failed to send Email';

}   
  }
 
// redirect method to home page

        }

   };
