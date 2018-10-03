<?php

namespace App\Controllers\Auth;
//  import view
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\User;

use App\Models\Admin;

use App\Models\UserCv;

use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class AuthController extends Controller

 {
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

    return  $this->view->render($res,'admindashboard.twig');

}





public function getlogout($request,$response){

    $this->auth->logout();
    // reply with a redirect
$this->flash->addMessage('loggedout','Logged Out!');
    return $response->withRedirect($this->router->pathFor('home'));

}

public function getSignUp($request,$response){

    // renders the signup page with the view dependency
// var_dump($request->getAttribute('csrf_value'));

    return $this->view->render($response,'signup.twig');

}

// get-> reply,post->respond
        public function getSignIn($request,$response){

            return $this->view->render($response,'signin.twig');

}



public function adminLogout($req,$res){
      $this->auth->adminlogout();
$this->flash->addMessage('loggedout','Logged Out!');
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


                public function postSignUp($request,$response){

//validating input fields


    $Validation = $this->validator->validate($request,[
// for  email, i set a custom validation called emailAvail()
// check EmailAvail class ;

'email' => v::noWhiteSpace()->notEmpty()->email()->EmailAvail(),
'name' => v::notEmpty()->alpha(),
'password' => v::noWhiteSpace()->notEmpty()

]);





// if valiation failed redirect to the signup page,$Validation->failed() returns true or false,its
//also a method in the respect validator dependency
if($Validation->failed()){

        $this->flash->addMessage('signupfailed',"Opps!,something went wrong");
    return $response->withRedirect($this->router->pathFor('auth.signup'));

}

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
    $mail->addAddress($request->getParam('email'), $request->getParam('name'));     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('ogwugopeople@ogwugo.com', 'Information');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Welcome';
    $mail->Body    = '  Welcome <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();

$directory = $this->user_upload_directory;
       $uploadedFiles = $request->getUploadedFiles();
  $uploadedFile = $uploadedFiles['image'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
         $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    }
// creating a row in databse
$user = User::create([
'email' => $request->getParam('email'),
'name' => $request->getParam('name'),
'image' => $filename,
'password' =>password_hash($request->getParam('password'),PASSWORD_DEFAULT),

 ]);
// sigining in the user after regiistration by just setting starting a user session
$this->auth->verify($user->email,$request->getParam('password'));
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // //Attachments
    //  $mail->addAttachment('/public/img/image');         // Add attachments
    // // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
$this->flash->addMessage('signup',"Welcome to a new World {$request->getParam('name')} ");
 return $response->withRedirect($this->router->pathFor('home'));

} catch (Exception $e) {
    die('Message could not be sent. Mailer Error:'. $mail->ErrorInfo);
}
// redirect method to home page

        }

   };
