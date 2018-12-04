<?php
 require_once("../src/require.php"); //database


/* CURRENT TIME */
date_default_timezone_set('Europe/Helsinki');


if(isset($_POST["alert_id"])) {

    $alert_id = $_POST["alert_id"];

	$tsql = "DELETE FROM Alerts
    WHERE Alert_id = '$alert_id'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));

    header("Location: https://wachaoshat.azurewebsites.net/app/alerts/");
}




 ?> 