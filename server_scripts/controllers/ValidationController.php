<?php


class ValidationController
{

    public function __construct()
    {

    }

    public function RegisterUser($params)
    {
        if (!(isset($_POST["user_name"]) && isset($_POST["user_phone"]) && isset($_POST["user_pass"]) && isset($_POST["otp"]))) {
            
        }
        
    }

    public function LoginUser($params)
    {
        $user_phone = $_POST["user_phone"];
        $user_pass = $_POST["user_pass"];

    }

}
