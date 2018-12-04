<?php
 require_once("../src/require.php"); //database


/* CURRENT TIME */
date_default_timezone_set('Europe/Helsinki');


if(isset($_GET["device_secret"])) {

    $device_secret = $_GET["device_secret"];

	$tsql = "SELECT * FROM SenseHat
    WHERE Sense_hat_device_secret = '$device_secret'
    ORDER BY Sense_hat_datetime";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));


    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

        $Sense_hat_temperature = $row["Sense_hat_temperature"];
        $Sense_hat_air_pressure = $row["Sense_hat_air_pressure"];
        $Sense_hat_humidity = $row["Sense_hat_humidity"];
        $Sense_hat_datetime = $row["Sense_hat_datetime"];

    }

    $last_date = substr($Sense_hat_datetime,0,-7);
    $current_fulldate = strtotime(strftime( '%Y-%m-%d %H:%M:%S' ));
    $new_last_date = strftime( '%Y-%m-%d %H:%M:%S', strtotime($last_date. '-5 minutes'));

    if($current_fulldate >= $new_last_date)
    {
        $offline = '1';
    } else {
        $offline = '0';
    }

    $newest_data["data"][] = array(
		"Sense_hat_temperature" => $Sense_hat_temperature,
		"Sense_hat_air_pressure" => $Sense_hat_air_pressure,
		"Sense_hat_humidity" => $Sense_hat_humidity,
        "Sense_hat_datetime" => $Sense_hat_datetime,
		"Sense_hat_last_entry" => $new_last_date,
        "Sense_hat_offline" => $offline
	);

	echo json_encode($newest_data);

}

?> 