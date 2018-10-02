<?php

namespace App\Controllers\Auth;
//  import view
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Models\User;

use App\Models\Admin;

use App\Controllers\Controller;

use Respect\Validation\Validator as v;

class AuthController extends Controller

 {


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
$this->flash->addMessage('ConfirmPassword',"Welcome Admin{$request->getParam('adminname')} ");
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


// creating a row in databse
$user = User::create([
'email' => $request->getParam('email'),
'name' => $request->getParam('name'),
'password' =>password_hash($request->getParam('password'),PASSWORD_DEFAULT)
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
