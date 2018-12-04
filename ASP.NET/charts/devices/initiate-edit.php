<?php
 require_once("../src/require.php"); //database


/* CURRENT TIME */
date_default_timezone_set('Europe/Helsinki');


if(isset($_POST["name"]) && isset($_POST["type"])) {

$device_id = $_POST["device_id"];

$device_name = htmlspecialchars(isset($_POST["name"]) ? $_POST["name"] : "");
$device_name = str_replace("'", "&#39;", $device_name);

$device_desc = htmlspecialchars(isset($_POST["description"]) ? $_POST["description"] : "");
$device_desc = str_replace("'", "&#39;", $device_desc);

$device_type = htmlspecialchars(isset($_POST["type"]) ? $_POST["type"] : "");
$device_type = str_replace("'", "&#39;", $device_type);

	$tsql = "UPDATE Devices SET 
    Device_name = '$device_name', 
    Device_description = '$device_desc', 
    Device_type = '$device_type'
    WHERE Device_id = '$device_id'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));

    header("Location: https://wachaoshat.azurewebsites.net/app/devices/");
} else {
    header("Location: https://wachaoshat.azurewebsites.net/app/devices/new-device.php?error=Please fill out the required fields! (Name and Type)");
}





 ?> 