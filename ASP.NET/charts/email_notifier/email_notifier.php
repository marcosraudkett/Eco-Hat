<?php
	
	/* Email notifier for Ecohat */

	require_once("../src/require.php"); //database
	date_default_timezone_set('Europe/Tallinn');

	//$date_mysql = ucwords(strftime('%Y-%m-%d 00:00:00', strtotime($this_date, '-'.$amount.' day')));
    // $date_mysql_2 = ucwords(strftime('%Y-%m-%d 23:59:59', strtotime($this_date, '-'.$amount.' day')));

	/* SELECT DATA */

	$current_fulldate = strftime( '%d.%m.%Y %H:%M:%S' );
	$currentday_mysqlfulldate = strftime( '%Y-%m-%d %H:%M:%S', strtotime($current_testdate. '-5 seconds'));

	$tsql = "SELECT * FROM SenseHat 
			 LEFT JOIN Alerts ON SenseHat.Sense_hat_device_secret = Alerts.Alert_device_secret
			 WHERE Sense_hat_datetime BETWEEN '$current_fulldate' AND '$currentday_mysqlfulldate' 
			 ORDER BY Sense_hat_entry_id DESC";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
	$get_rows = sqlsrv_num_rows($getResults);

	while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

		$alert_type = $row["Alert_initiation_type"];
		$alert_value = $row["Alert_initiation_value"];

		$current_temperature = $row["Sense_hat_temperature"];
		$current_humidity = $row["Sense_hat_humidity"];
		$current_air_pressure = $row["Sense_hat_air_pressure"];

	};

	$email_from = "ecohat@chaos.iot";
	$day = ucwords(strftime("%A"));
	$added_date =  strftime("%d.%m.%Y"); 
    $added_time =  date("H:i:s");

    /* CURRENT TIME */
    $postdate = date("Y-m-d H:i:s", time());

    $dateplustime = $added_date. ' ' .$added_time;
		
	/* user email here! */
	$email_to = 'ogkaaos@gmail.com';

	/* temperature drop to */
	if($alert_type != '')
	{
		if($alert_value >= $current_temperature) {
			/* Email Configure */
			$email_subject = "Temperature has dropped to ".$alert_value.", ".$dateplustime;
			$message_final = '
			The temperature has dropped to '.$alert_value.'; <br><br>Time: <b>'.$day.', '.$dateplustime.'</b>
			<br><br><br>
			<a target="_blank" href="https://wachaoshat.azurewebsites.net/alerts/" style="
			padding: 10px;
			background: #1abc9c;
			/* margin-bottom: 10px; */
			text-decoration: none;
			color: white;
			">Manage Alerts</a>
			<br><br>
			Älä vastaa tähän sähköpostiin.';
		}
	}
	/* temperature drop end */

	/* temperature exceeds */


	$headers = 'From: EcoHat Alert <'.$email_from.">\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'Content-type: text/html; charset=utf-8'."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $message_final, $headers); 

?>