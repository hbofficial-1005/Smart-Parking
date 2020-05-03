<?php

class SendOtp
{

    private $authKey = "insertyourkey";

    public function __construct()
    {
    }

    public function SendOtp($mobile)
    {
        $authKey = $this->authKey;
        $otp = rand(1000, 9999);
        $message = "Your OTP for Transpo is : $otp";
        $sender = "TRANSPO";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://control.msg91.com/api/sendotp.php?template=&otp_length=&authkey=$authKey&message=$message&sender=$sender&mobile=$mobile&otp=$otp&otp_expiry=&email=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
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
