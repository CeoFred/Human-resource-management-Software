<?php


 namespace App\Controllers;
//  import view

 use Slim\Views\Twig as View;


 class HomeController extends Controller

 {


    public function index($request,$response)

        {
// accessing the view container
return $this->view->render($response,'home.twig');

        }

    };
