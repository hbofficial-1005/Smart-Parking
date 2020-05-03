<?php


class Login
{

    public function __construct()
    {
        global $dbStoreObj;
        $this->Init();
        $dbStoreObj = new DBStore();
        $this->AuthenticateUser();
    }

    public function Init()
    {
        require_once '../db/DBStore.php';
        require_once '../security/Tokenization.php';
    }

    public function AuthenticateUser()
    {

        global $dbStoreObj;

        $user_phone = $_POST["user_phone"];
        $user_pass = $_POST["user_pass"];

        $params = [
            "user_phone" => $user_phone,
            "user_pass" => $user_pass
        ];

        $user_id = $dbStoreObj->LoginUser($params);
        
        if ($user_id) {
            $payload = [
                "user_id" => $user_id,
            ];
            $tokenObj = new Tokenization();
            echo json_encode(array("status" => "success", "auth_token" => $tokenObj->CreateAuthToken($payload)));
        } else {
            echo json_encode(array("status" => "error", "auth_token" => "null"));
        }
    }

}
