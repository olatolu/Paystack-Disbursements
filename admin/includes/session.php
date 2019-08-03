<?php

class Session{

    private $signed_in = false;

    public $user_id;

    public $message;

    public $count;

    function __construct(){

        session_start();

        $this->check_the_login();

        $this->check_message();

        $this->visitor_count();


    }

    public function visitor_count(){

        if(isset($_SESSION['count'])){

            return $this->count = $_SESSION['count']++;

            //unset($_SESSION['count']);
        }else{

            //$_SESSION['count'] = 1;

            return $this->count = $_SESSION['count'] =1;

        }

    }

    public function message($msg=""){

        if(!empty($msg)){

            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function check_message(){

        if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
        } else {

            $this->message = "";
        }
    }

    public function unset_message(){

        unset($_SESSION['message']);
    }

    // always check for weather user is signed in

    public function is_signed_in(){

        return $this->signed_in;
    }

    //login user
    public function login($user){

        if($user){

            $this->user_id = $_SESSION['user_id'] = $user;
            $this->signed_in = true;

        }
    }

    //logout
    public function logout(){

        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    private function check_the_login(){

        if(isset($_SESSION['user_id'])){

            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        }else{


            unset($this->user_id);
            $this->signed_in = false;
        }

    }





    //END CLASS SESSION
}

$session = new Session();






?>