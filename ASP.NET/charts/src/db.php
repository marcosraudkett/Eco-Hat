<?php 
	
	include ("config.php");

	
	/* MySQL Database */
	/*
	$conn = mysqli_connect($db_host, $db_user, $db_pass) or die(mysqli_error()); 
	mysqli_select_db($conn, $db_name) or die(mysqli_error()); 

	*/

	/* Azure SQL Database */
    $serverName = $db_host;
	$connectionOptions = array(
	    "Database" => $db_name,
	    "Uid" => $db_user,
	    "PWD" => $db_pass
	);

	$conn = sqlsrv_connect($serverName, $connectionOptions);
?>