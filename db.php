<?php

	include('config.php');
	// config.php has to define the following variables:
	// $mysql_hostname = "HOST";
	// $mysql_user = "USER";
	// $mysql_password = "PASSWORD";
	// $mysql_database = "DATABASE";
	// $mysql_table = "TABLE";

	$link = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password, $mysql_database) or die("Could not connect to database!");

	// Define Array '$spalten' which is reused several times with table structure!
	$query = "SELECT column_name AS col, character_maximum_length AS max, COLUMN_COMMENT AS comment 
			  FROM information_schema.columns
			  WHERE table_schema = '$mysql_database' AND table_name = '$mysql_table'
			  ORDER BY ordinal_position";
	// mysqli with statement
	if ($stmt = mysqli_prepare($link, $query)) {
	    // execute statement
	    mysqli_stmt_execute($stmt);
	    // bind result variables
	    mysqli_stmt_bind_result($stmt, $col, $max, $comment);
		// fetch values
		while (mysqli_stmt_fetch($stmt)) {
			if ($col != "id") {
				$spalten[] = array('col' => $col, 'max' => $max, 'comment' => $comment);
			}
		}
	}


?>