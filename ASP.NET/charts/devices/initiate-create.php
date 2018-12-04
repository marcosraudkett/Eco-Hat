<?php
 require_once("../src/require.php"); //database


/* CURRENT TIME */
date_default_timezone_set('Europe/Helsinki');

function hash_generator($char_amount, $type, $hash_type, $string)
{

    if($hash_type == '')
    {
        $hash_type = 'md5';
    }

    switch($type)
    {
        case "random":
            return substr($hash_type(rand(0,1000).rand(0,1000).rand(0,1000).rand(0,1000)),0, $char_amount);
        break;

        case "string":
            return substr($hash_type($string),0, $char_amount);
        break;
    }

}

if(isset($_POST["name"]) && isset($_POST["type"])) {


$device_name = htmlspecialchars(isset($_POST["name"]) ? $_POST["name"] : "");
$device_name = str_replace("'", "&#39;", $device_name);

$device_desc = htmlspecialchars(isset($_POST["description"]) ? $_POST["description"] : "");
$device_desc = str_replace("'", "&#39;", $device_desc);

$device_type = htmlspecialchars(isset($_POST["type"]) ? $_POST["type"] : "");
$device_type = str_replace("'", "&#39;", $device_type);

$device_secret = hash_generator("12", "random", "md5", "");

$device_added = date("Y-m-d H:i:s", time());

	$tsql = "INSERT INTO Devices 
                           (Device_name, Device_description, Device_type, Device_secret, Device_added) VALUES ('$device_name', '$device_desc', '$device_type', '$device_secret', '$device_added')";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));

    header("Location: https://wachaoshat.azurewebsites.net/app/devices/");
} else {
    header("Location: https://wachaoshat.azurewebsites.net/app/devices/new-device.php?error=Please fill out the required fields! (Name and Type)");
}





 ?> 