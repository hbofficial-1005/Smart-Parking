<?php


class RequestOtp
{

    public function __construct()
    {
        global $dbStoreObj, $sendOtpObj;
        $this->Init();
        $dbStoreObj = new DBStore();
        $sendOtpObj = new SendOtp();
        $this->SendOtp();
    }

    public function Init()
    {
        require_once '../db/DBStore.php';
        require_once 'SendOtp.php';
    }

    public function SendOtp()
    {
        global $sendOtpObj;

        $user_phone = $_POST["user_phone"];

        if (!$this->IsUserExist($user_phone)) {
            $result = $sendOtpObj->SendOtp($user_phone);
            if ($result->type == "success") {
                echo json_encode(array("status" => "success", "msg" => "Messgae Sent"));
            }else{
                echo json_encode(array("status" => "error", "msg" => "Please verify your number"));
            }
        } else {
            echo json_encode(array("status" => "error", "msg" => "User Already Exist!"));
        }
    }

    public function IsUserExist($user_phone): bool
    {
        global $dbStoreObj;
        $params = array("user_phone" => $user_phone);
        return $dbStoreObj->IsUserExist($params);
    }

}
