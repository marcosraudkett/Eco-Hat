<?php
 require_once("../src/require.php"); //database


/* CURRENT TIME */
date_default_timezone_set('Europe/Helsinki');


if(isset($_POST["device_id"])) {

    $device_id = $_POST["device_id"];

	$tsql = "DELETE FROM Devices
    WHERE Device_id = '$device_id'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));

    header("Location: https://wachaoshat.azurewebsites.net/app/devices/");
} else {
    header("Location: https://wachaoshat.azurewebsites.net/app/devices/new-device.php?error=Please fill out the required fields! (Name and Type)");
}





 ?> 