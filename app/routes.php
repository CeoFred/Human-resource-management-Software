<?php

// use App\Middleware\AuthMiddleware;
// use App\Middleware\GuestMiddleware;
use App\Middleware\AdminMiddleWare;
use App\Middleware\TobeAdminMiddelWare;



$app->group('',function() use ($app) {

    $app->get('/auth/admin/login','AuthController:RenderAdminLogin')->setName('auth.admin.signin');
$app->post('/auth/admin/login','AuthController:postAdminSignIn');

})->add(new TobeAdminMiddelWare($container));


// if anyone access any of this routes,Authmiddelware checks if you are logged in and refiects you to the signin page if you a
// are not logged in yet, so all th routes passes through the authcontroller
$app->group('',function(){
    $this->post('/auth/admin/addNewDepartment','AuthController:addNewDepartment')->setName('addDept');
  $this->get('/auth/admin/departments','AuthController:getDepartments')->setName('department');
    $this->post('/auth/admin/formdata/refreeinfo', 'AuthController:updateEmployeeRefreenInformation')->setName('updateEmployeeRefreenInformation');
    $this->post('/auth/admin/formdata/workinfo', 'AuthController:updateEmployeeWorkInfo')->setName('updateEmployeeWorkInfo');
    $this->get('/auth/admin/logout', 'AuthController:adminLogout')->setName('admin.logout');
    $this->get('/auth/admin/', 'AuthController:RenderAdminPanel')->setName('ControlPanel');
    $this->get('/auth/admin/signup', 'AuthController:getAdminSignUp')->setName('auth.admin.signup');
    $this->get('/auth/admin/allusers', 'AuthController:getEmployees')->setName('all.employees');
    $this->post('/auth/admin/signup', 'AuthController:postAdminSignUp');
    $this->get('/auth/admin/addEmployee', 'AuthController:addEmployee')->setName('add.employee');
    $this->post('/auth/admin/addEmployee', 'AuthController:postAddEmployee')->setName('post.employee');
   $this->get('/auth/admin/employee', 'AuthController:viewEmployee')->setName('view.employee');
    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');
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
$this->post('/auth/user/formdata/iinfo', 'AuthController:uploadEmployeePassport')->setName('uploadEmployeePassport');
$this->post('/auth/admin/formdata/updateEmergencyInfo', 'AuthController:updateEmployeeEmergencyInfo')->setName('updateEmployeeEmergencyInfo');
$this->get('/', 'HomeController:index')->setName('home');
$this->get('/auth/admin/employees/search', 'AuthController:searchEmployee')->setName('searchEmployee');
    $this->get('/auth/admin/employees/searchDept', 'AuthController:searchDept')->setName('searchDept');
    $this->get('/auth/admin/birthdays/sendWishes','AuthController:sendBirthdayWishes')->setName('sendBirthdayWishes');
$this->post('/auth/admin/birthday/send','AuthController:sendWish')->setName('post.wish');


})->add(new AdminMiddleWare($container));

// using twig view
// $app->get('/',function($request,$response){
//   return $this->view->render($response,'home.twig');
// });
