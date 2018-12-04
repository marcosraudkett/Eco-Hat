<?php
 require_once("../src/require.php"); //database


/* CURRENT TIME */
date_default_timezone_set('Europe/Helsinki');


if(isset($_POST["type"]) && isset($_POST["selected_device"])) {


$alert_type = htmlspecialchars(isset($_POST["type"]) ? $_POST["type"] : "");
$alert_type = str_replace("'", "&#39;", $alert_type);

$alert_desc = htmlspecialchars(isset($_POST["description"]) ? $_POST["description"] : "");
$alert_desc = str_replace("'", "&#39;", $alert_desc);

$alert_action = htmlspecialchars(isset($_POST["action"]) ? $_POST["action"] : "");
$alert_action = str_replace("'", "&#39;", $alert_action);

$alert_device_secret = htmlspecialchars(isset($_POST["selected_device"]) ? $_POST["selected_device"] : "");
$alert_device_secret = str_replace("'", "&#39;", $alert_device_secret);

$initiation_value = htmlspecialchars(isset($_POST["initiation_value"]) ? $_POST["initiation_value"] : "");
$initiation_value = str_replace("'", "&#39;", $initiation_value);

$initiation_type = htmlspecialchars(isset($_POST["initiation_type"]) ? $_POST["initiation_type"] : "");
$initiation_type = str_replace("'", "&#39;", $initiation_type);

$alert_added = date("Y-m-d H:i:s", time());

	$tsql = "INSERT INTO Alerts 
                           (Alert_type, Alert_description, Alert_action, Alert_created, Alert_device_secret, Alert_initiation_value, Alert_initiation_type) VALUES ('$alert_type', '$alert_desc', '$alert_action', '$alert_added', '$alert_device_secret', '$initiation_value', '$initiation_type')";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));

    header("Location: https://wachaoshat.azurewebsites.net/app/alerts/");
} else {
    header("Location: https://wachaoshat.azurewebsites.net/app/alerts/new-alert.php?error=Please fill out the required fields! (name, device and initiation settings)");
}





 ?> 