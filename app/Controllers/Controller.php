<?php


    namespace App\Controllers;

    class Controller{

    protected $container;

    public function __construct($container){

        $this->container = $container;

    }


//get magic method,takes any property to access
    public function __get($property){
// check if what we are tryig to access exist in our container
        if ($this->container->{$property})
    {
       return $this->container->{$property};
    }

    }

}
