<?php


class Register
{

    public function __construct()
    {
        global $dbStoreObj, $verifyOtpObj;
        $this->Init();
        $dbStoreObj = new DBStore();
        $verifyOtpObj = new VerifyOtp();
        $this->RegisterUser();
    }

    public function Init()
    {
        require_once '../db/DBStore.php';
        require_once '../security/Tokenization.php';
        require_once 'VerifyOtp.php';
    }

    public function RegisterUser()
    {
        global $dbStoreObj, $verifyOtpObj;

        $user_name = $_POST["user_name"];
        $user_phone = $_POST["user_phone"];
        $user_pass = $_POST["user_pass"];
        $otp = $_POST["otp"];

        $params = [
            "user_name" => $user_name,
            "user_phone" => $user_phone,
            "user_pass" => $user_pass,
            "otp" => $otp
           
        ];
//        echo json_encode($params);
//        exit();

        $result = $verifyOtpObj->VerifyOtp($user_phone, $otp);

        if ($result->type == "success") {
            $lastInsertedID = $dbStoreObj->RegisterUser($params);
        } else {
            $lastInsertedID = 0;
//            echo json_encode(array("status" => "error2", "auth_token" => "null"));
//            exit();
        }

        if ($lastInsertedID) {
            $payload = [
                "user_id" => $lastInsertedID,
            ];
            $tokenObj = new Tokenization();
            echo json_encode(array("status" => "success", "auth_token" => $tokenObj->CreateAuthToken($payload)));
        } else {
            echo json_encode(array("status" => "error", "auth_token" => "null"));
        }

    }

}
