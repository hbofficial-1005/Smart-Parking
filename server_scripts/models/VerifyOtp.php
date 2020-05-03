<?php

class VerifyOtp {

    private $authKey = "insertyourkey";

    public function __construct() {
    
    }

    public function VerifyOtp(string $mobile, string $otp) {

        $authKey = $this->authKey;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://control.msg91.com/api/verifyRequestOTP.php?authkey=$authKey&mobile=$mobile&otp=$otp",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            $response = json_encode(array("type" => "error"));
            return json_decode($response);
        } else {
            return json_decode($response);
        }
    }

}