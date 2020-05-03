<?php

set_include_path('/var/www/html/bxlair/');
require_once("ApiResponseCode.php");
require_once("AqiData.php");
require_once("PushNotifications.php");

class RestHandler extends ResponseCode {

    function __construct() {
        
    }

    public function error($errMsg) {
        $statusCode = 406;
        if (isset($_REQUEST['action'])) {
            $requestContentType = $_SERVER['HTTP_ACCEPT'];
            $this->setHttpHeaders($requestContentType, $statusCode);
        }
        echo json_encode(array('error' => $errMsg));
        exit;
    }

    public function success($success) {
        $statusCode = 200;
        if (isset($_REQUEST['action'])) {
            $requestContentType = $_SERVER['HTTP_ACCEPT'];
            $this->setHttpHeaders($requestContentType, $statusCode);
        }
        echo json_encode(array("success" => $success));
    }

    public function registerNotificationDevices() {
        $pushNotification = new PushNotifications();
        $pushNotification->register_notification_devices();
    }

    public function updateDevicesLanguage() {
        $pushNotification = new PushNotifications();
        $pushNotification->update_notification_devices();
    }

    public function updateDeviceNotifyPermissions() {
        $pushNotification = new PushNotifications();
        $pushNotification->allow_block_notification();
    }

    function saveData() {
        $aqiData = new AqiData();
        $aqiData->saveAqiData();
    }

    function getAllData() {
        $aqiData = new AqiData();
        $response = $aqiData->getAqiData();
        //echo "<pre>".$response."</pre>";
        echo $response;
    }

    public function getSingleData($id) {

        $aqiData = new AqiData();
        $rawData = $aqiData->getSingleData();

        if (strpos($requestContentType, 'application/json') !== false) {
            $response = $this->encodeJson($rawData);
            echo $response;
        } else if (strpos($requestContentType, 'text/html') !== false) {
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if (strpos($requestContentType, 'application/xml') !== false) {
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }

    public function encodeHtml($responseData) {
        $htmlResponse = "<table border='1'>";
        foreach ($responseData as $key => $value) {
            $htmlResponse .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;
    }

    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }

    public function encodeXml($responseData) {
        // creating object of SimpleXMLElement
        $xml = new SimpleXMLElement('<?xml version="1.0"?><mobile></mobile>');
        foreach ($responseData as $key => $value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }

}
