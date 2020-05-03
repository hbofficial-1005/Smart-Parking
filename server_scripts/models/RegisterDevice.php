<?php

class RegisterDevice
{

    public function __construct()
    {
        global $dbStoreObj;
        $this->Init();
        $dbStoreObj = new DBStore();
        $this->RegisterDevice();
    }

    public function Init()
    {
        require_once '../db/DBStore.php';
        require_once '../security/Tokenization.php';
    }

    public function RegisterDevice()
    {
        global $dbStoreObj;

        $auth_token = $_POST["auth_token"];
        $device_id = $_POST["device_id"];
        $registration_id = $_POST["registration_id"];
        $os_type = $_POST["os_type"];

        $tokenObj = new Tokenization();

        $user_id = 0;
        $data = $tokenObj->VerifyAuthToken($auth_token);

        if ($data == null) {
            echo json_encode(array("status" => "error", "msg" => "Unauthorized Request"));
            return;
        } else {
            $user_id = $data->user_id;
        }

        $params = [
            "user_id" => $user_id,
            "device_id" => $device_id,
            "registration_id" => $registration_id,
            "os_type" => $os_type,
        ];

        if ($dbStoreObj->RegisterUserDevice($params) && $dbStoreObj->RegisterNotificationDevice($params)) {
            echo json_encode(array("status" => "success", "msg" => "Device Registration Done!"));
            return;
        }else{
            echo json_encode(array("status" => "error", "msg" => "null"));
        }

    }

}
