<?php

// use App\Middleware\AuthMiddleware;
// use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleWare;
use App\Middleware\TobeAdminMiddelWare;



$app->group('',function() use ($app) {

    $app->get('/login','AuthController:RenderAdminLogin')->setName('auth.admin.signin');
$app->post('/auth/admin/login','AuthController:postAdminSignIn')->setName('admin.signin');

})->add(new TobeAdminMiddelWare($container));


// if anyone access any of this routes,Authmiddelware checks if you are logged in and refiects you to the signin page if you a
// are not logged in yet, so all th routes passes through the authcontroller
$app->group('',function(){
    $this->post('/upload/image/via/url','AuthController:uploadEmployeePassportViaUrl')->setName('uploadEmployeePassportViaUrl');
    $this->get('/birthday/sendwishes','AuthController:sendAutpoWishes');
    $this->post('/addNewDepartment','AuthController:addNewDepartment')->setName('addDept');
    $this->get('/departments','AuthController:getDepartments')->setName('department');
    $this->post('/updateRefreeinfo', 'AuthController:updateEmployeeRefreenInformation')->setName('updateEmployeeRefreenInformation');
    $this->post('/updateEmployeeinfo', 'AuthController:updateEmployeeWorkInfo')->setName('updateEmployeeWorkInfo');
    $this->get('/logout', 'AuthController:adminLogout')->setName('admin.logout');
    $this->get('/home', 'AuthController:RenderAdminPanel')->setName('ControlPanel');
    $this->get('/signup', 'AuthController:getAdminSignUp')->setName('auth.admin.signup');
    $this->get('/allusers', 'AuthController:getEmployees')->setName('all.employees');
    $this->post('/signupAdmin', 'AuthController:postAdminSignUp');
    $this->get('/addEmployee', 'AuthController:addEmployee')->setName('add.employee');
    $this->post('/admin/addEmployee', 'AuthController:postAddEmployee')->setName('post.employee');
    $this->get('/admin/employee', 'AuthController:viewEmployee')->setName('view.employee');
    $this->get('/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/signin', 'AuthController:postSignIn');
    $this->get('/auth/user/my_cv','AuthController:getUserCv')->setName('Usercv');
    $this->post('/auth/user/my_cv','AuthController:postUserCv');
    $this->get('/auth/user/password/change','PasswordController:getchangepass')->setName('change.password');
    $this->post('/auth/user/password/change','PasswordController:postchangepass');
    $this->get('/auth/user/logout','AuthController:getlogout')->setName('logout');
    $this->get('/auth/user/formdata','AuthController:getFormdata')->setName('user.formdata');
    $this->get('/auth/user/profile','AuthController:getUserProfile')->setName('user.profile');
    $this->get('/auth/user/inbox','AuthController:getUserInbox')->setName('user.inbox');
    $this->get('/auth/user/formdata/edit','AuthController:getFormdataEdit')->setName('user.update.workdata');
    $this->post('/auth/user/formdata/edit','AuthController:postFormdataEdit');
    $this->get('/auth/user/formdata/view','AuthController:getFormdataView')->setName('user.view.workdata');
    $this->post('/auth/user/formdata/winfo','AuthController:update_winfo')->setName('update.workinfo');
    $this->post('/auth/user/formdata', 'AuthController:update_pinfo')->setName('form');
    $this->post('/update/user/passport', 'AuthController:uploadEmployeePassport')->setName('uploadEmployeePassport');
    $this->post('/auth/admin/formdata/updateEmergencyInfo', 'AuthController:updateEmployeeEmergencyInfo')->setName('updateEmployeeEmergencyInfo');
    $this->get('/', 'HomeController:index')->setName('home');
    $this->get('/employees/search', 'AuthController:searchEmployee')->setName('searchEmployee');
    $this->get('/employees/searchDept', 'AuthController:searchDept')->setName('searchDept');
    $this->get('/birthdays/sendWishes','AuthController:sendBirthdayWishes')->setName('sendBirthdayWishes');
$this->post('/auth/admin/birthday/send','AuthController:sendWish')->setName('post.wish');


})->add(new AdminMiddleWare($container));

// using twig view
// $app->get('/',function($request,$response){
//   return $this->view->render($response,'home.twig');
// });
