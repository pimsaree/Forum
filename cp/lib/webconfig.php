<?php
	require("../lib/webconfig.php");
	
	$mysqli = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$mysqli->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
?>
