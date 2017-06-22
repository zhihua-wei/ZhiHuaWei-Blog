<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Home_Controller
{

    public function index()
    {
        $this -> load -> view('index.html');

    }

    public function test()
    {

        echo 11115555111;

        //$this -> load -> view('welcome.html');

    }

}