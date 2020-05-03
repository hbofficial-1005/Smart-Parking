<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

$action = "";
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} else {
    exit('No direct script access allowed');
}
/*
controls the RESTful services
URL mapping
 */
switch ($action) {

    case "login":
        loadModel("Login");
        break;

    case "register":
        loadModel("Register");
        break;

    case "requestOtp":
        loadModel("RequestOtp");
        break;

    case "registerDevice":
        loadModel("RegisterDevice");
        break;

    case "notifyDevice":
        $mobileRestHandler = new AqiRestHandler();
        $mobileRestHandler->updateDeviceNotifyPermissions();
        break;

    case "":
        die("Permission denied!!");
        break;
}

function loadModel($modelClass)
{
    require '../models/' . $modelClass . ".php";
    new $modelClass();
}
