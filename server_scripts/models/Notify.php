<?php



class Notify
{

    public function __construct()
    {
        global $dbStoreObj, $fireBase;
        $this->Init();
        $dbStoreObj = new DBStore();
        $fireBase = new FireBase();
    }

    public function Init()
    {
        require_once '../db/DBStore.php';
        require_once '../security/Tokenization.php';
        require_once '../notification/FireBase.php';
    }

    public function NotifyDrivers(array $msgBody)
    {
        global $dbStoreObj;

        $availableDrivers = $dbStoreObj->GetAllAvailablesDrivers();

        $this->NotifyDevices($availableDrivers, $msgBody, "driver");

    }

    public function NotifyCustomer(array $msgBody, $customerId)
    {
        global $dbStoreObj;

        $availableDrivers = $dbStoreObj->GetCustomerDeviceId(array("id" => $customerId));

        $this->NotifyDevices($availableDrivers, $msgBody, "subscriber");

    }

    public function NotifyDevices($result, $msgBody, $type)
    {
        global $fireBase;

        $devices = array();
        $devices["android"] = array();
        $devices["ios"] = array();
        $iosCounter = 0;
        $androidConter = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            if ($row["os_type"] == "android") {
                if ($androidConter > 500) {
                    $fireBase->Send($devices["android"], $msgBody, "driver");
                    $androidConter = 0;
                    $devices["android"] = array();
                    $devices["android"][] = $row["registration_id"];
                }
                $devices["android"][] = $row["registration_id"];
                $androidConter++;
            } else if ($row["os_type"] == "ios") {
                if ($iosCounter > 500) {
                    $iosCounter = 0;
                    $devices["ios"] = array();
                    $devices["ios"][] = $row["registration_id"];
                }
                $devices["ios"][] = $row["registration_id"];
                $iosCounter++;
            }
        }

        if (count($devices["android"])) {
            $fireBase->Send($devices["android"], $msgBody, $type);
        }

    }

}
