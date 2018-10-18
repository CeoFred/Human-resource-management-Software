<?php

namespace App\Controllers\Auth;
//  import view
use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

use App\Models\einfo;

use App\Models\User;

use App\Models\Admin;

use App\Controllers\Controller;

use App\Models\department;

use Respect\Validation\Validator as v;

class AuthController extends Controller
 {
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

       $addNewDept = department::create([
            'department' => $req->getParam('dept')
        ]);
        if($addNewDept){
            return 'success';
        }else{
            return 'Failed';
        }

}

public function getDepartments($req, $res){
    $this->view->render($res,'departments.twig');
}

// search for employess
public function searchEmployee($req,$res){
    $name = $req->getParam('query');
 $einfo =   einfo::where('givenname',$name)
 ->orWhere('familyname', $name)
 ->get();

    foreach($einfo as $employee){
       echo "<a href='/public/auth/admin/employee?id={$employee->company_id}' style='color:#000'>";
echo  '<i class="fas fa-user"></i>'.' ' .$employee->familyname.' '.$employee->givenname;
echo '</a>';
echo '<br/>';
    }

}


// update emoloyee refree information
 public function updateEmployeeRefreenInformation($req,$res){
      
    $Validation = $this->validator->validate($req,[

        'fullname' => v::notEmpty()->alpha()
    
    
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

}
// update employee company info
public function updateEmployeeWorkInfo($req,$res) {


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

        $Validation = $this->validator->validate($req,[

            $req->getUploadedFiles() => v::image()

            ]);
    
            if(!$Validation->failed()){
    

        $directory = $this->upload_directory_employees;
        $uploadedFiles = $req->getUploadedFiles();
        $uploadedFile = $uploadedFiles['passport'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
            $filename = sprintf('%s.%0.8s', $basename, $extension);
            $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        $update = einfo::where('company_id', $req->getParam('company_id'))->update([
'image' => $filename

        ]);
        if($update){
            return 'success';
        }else{
            return 'failed';
        }

     }else{
         return $uploadedFile->getError();
     }

    }else{

 return json_encode($_SESSION['errors']);

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

// update user persona info
public function update_pinfo($req,$res) {


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
                'emergency_contact_address'=> v::notEmpty()->alpha(),
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
'adminemail' => v::noWhiteSpace()->notEmpty()->email()->AdminEmailAvail(),
'adminname' => v::notEmpty()->alpha(),
'adminpassword' => v::noWhiteSpace()->notEmpty()
        ]);

        // if validation failed ,redirect
        if($Validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.admin.signup'));
        }

// creating a new row
       $Admin = Admin::create([
'email' => $request->getParam('adminemail'),
'name' => $request->getParam('adminname'),
'password' => password_hash($request->getParam('adminpassword'), PASSWORD_DEFAULT)
          ]);

if($Admin){
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'johnsonmessilo19@gmail.com';                 // SMTP username
    $mail->Password = 'messilo18';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('fredd@ogwugo.com', 'Ogwugo.com');
    $mail->addAddress($request->getParam('adminemail'), $request->getParam('adminname'));     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('ogwugopeople@ogwugo.com', 'Information');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Welcome';
    $mail->Body    = '  Welcome <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

          return $response->withRedirect($this->router->pathFor('ControlPanel'));

} catch (Exception $e) {
    die('Message could not be sent. Mailer Error:'. $mail->ErrorInfo);
}

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

    $auth = $this->auth->averify(
    $request->getParam('email'),

    $request->getParam('password'));

    if($auth){

        $this->flash->addMessage('signedin',"Welcome Back!");
    return $response->withRedirect($this->router->pathFor('ControlPanel'));
}
  else{

        $this->flash->addMessage('signinerror',"Opps! something went wrong");
        return $response->withRedirect($this->router->pathFor('auth.admin.signin'));

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


// //     $Validation = $this->validator->validate($request,[

// // 'email' => v::noWhiteSpace()->notEmpty()->email()->EmailAvail(),
// // 'givenname' => v::notEmpty()->alpha(),
// // 'familyname' => v::alpha()->notEmpty(),
// // 'gender' => v::alpha()->notEmpty(),
// // 'department' => v::alpha()->notEmpty(),

// // ]);


// // // if valiation failed redirect to the signup page,$Validation->failed() returns true or false,its
// // //also a method in the respect validator dependency
// // if($Validation->failed()){

// //     return 'failed validation' ;

// // }else{

// //     return 'all validated';
// }

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {

    //Server settings
//     $mail->SMTPDebug = 0;                                 // Enable verbose debug output
//     $mail->isSMTP();                                      // Set mailer to use SMTP
//     $mail->Host = 'sweetpea.hostnownow.com';  // Specify main and backup SMTP servers
//     $mail->SMTPAuth = true;                               // Enable SMTP authentication
//     $mail->Username = 'activate@yourhomefuto.com.ng';                 // SMTP username
//     $mail->Password = 'messilo18_';                           // SMTP password
//     $mail->SMTPSecure = 'ssl';
//     $mail->SMTPAutoTLS = true;
//     // Enable TLS encryption, `ssl` also accepted
//     $mail->Port = 465;                                    // TCP port to connect to
//     //Recipients

//     $mail->SMTPOptions = array(
//     'ssl' => array(
//         'verify_peer' => false,
//         'verify_peer_name' => false,
//         'allow_self_signed' => true
//     )
// );

//     $mail->setFrom('fredd@ogwugo.com', 'Ogwugo.com');
//     $mail->addAddress($request->getParam('email'), $request->getParam('firstname'));     // Add a recipient
//     // $mail->addAddress('ellen@example.com');               // Name is optional
//     $mail->addReplyTo('ogwugopeople@ogwugo.com', 'Information');
//     $mail->isHTML(true);                                  // Set email format to HTML
//     $mail->Subject = 'Welcome';
//     $mail->Body    = '  Welcome <b>in bold!</b>';
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//     $mail->send();

// creating a row in databse
$company_id = 'OGWUGO' . str_shuffle('123456789');

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
      $new += $new->Members++;

            department::where('department',$request->getParam('department'))->update(['Members' => $new]);
return 'created';

}
 catch (Exception $e) {
    die('Message could not be sent. Mailer Error:'. $mail->ErrorInfo);
return 'bad';

}
// redirect method to home page

        }

   };
