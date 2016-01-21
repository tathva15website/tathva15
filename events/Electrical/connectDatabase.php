<?php
	$mysql_host = 'localhost';
	$mysql_username = '';
	$mysql_password = '</tathva>';
	$mysql_db = '';
	$connection_error = "<h3>No Connection</h3> <br> Please Check Your Internet Connection";
	$mysql_conn = mysqli_connect($mysql_host,$mysql_username,$mysql_password,$mysql_db);
	if(mysqli_connect_errno()){
		die("error");
	}
?>
