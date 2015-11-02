<?php
	require_once 'connectDatabase.php';
	$Name = trim(mysqli_real_escape_string($mysql_conn , $_POST['Name']));
	$College = trim(mysqli_real_escape_string($mysql_conn , $_POST['College']));
	$Department = trim(mysqli_real_escape_string($mysql_conn , $_POST['Department']));
	$RollNumber = trim(mysqli_real_escape_string($mysql_conn , strtolower($_POST['RollNumber'])));
	$Email = trim(mysqli_real_escape_string($mysql_conn , strtolower($_POST['Email'])));
	$PhoneNumber = trim(mysqli_real_escape_string($mysql_conn , $_POST['PhoneNumber']));
	$flag = 0;
	
	if(empty($PhoneNumber) && isset($_POST['Submit'])){
		echo "<h1>Phone Number Not Set</h1>";
		$flag =1;
	}
	else if(!(ctype_digit($PhoneNumber) && strlen($PhoneNumber) == 10 ) && isset($_POST['Submit'])  ){
		echo "<h1>Invalid Phone Number</h1>";
		$flag=1;
	}
	
	if(empty($Name) && isset($_POST['Submit'])){
		echo "<h1>Name Not Set</h1>";
		$flag =1;
	}
	
	if(empty($College) && isset($_POST['Submit'])){
		echo "<h1>College Not Set</h1>";
		$flag =1;
	}
	
	if(empty($Department) && isset($_POST['Submit'])){
		echo "<h1>Department Not Set</h1>";
		$flag =1;
	}
	
	if(empty($RollNumber) && isset($_POST['Submit'])){
		echo "<h1>Roll Number Not Set</h1>";
		$flag =1;
	}
	
	if(empty($Email) && isset($_POST['Submit'])){
		echo "<h1>Email Not Set</h1>";
		$flag =1;
	}
	else if(!(($pos = strpos($Email,'@') !== false) && strpos($Email , '.' , $pos) !== false) && isset($_POST['Submit']) ){
		echo "<h1>Invalid Email Address</h1>";
		$flag=1;
	}
	
	if(isset($_POST['Submit']) && $flag != 1){
		$query = "SELECT TathvaID , Timestamp FROM Participants WHERE  PhoneNumber = '$PhoneNumber' OR Email = '$Email'";
		if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)!=0)){
			$query_row = mysqli_fetch_array($query_run,MYSQLI_NUM);
			echo "<h1 id='spec'>You are already registered with us. Your TathvaID is <span id='tid'>$query_row[0]</span>. You registered on $query_row[1]</h1>";
		}
		else{
			$TathvaNo = 10000;
			$query = "SELECT SNo FROM Participants ORDER BY SNo DESC LIMIT 1";
			if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)!=0)){
				$query_row = mysqli_fetch_array($query_run,MYSQLI_NUM);
				$TathvaNo += $query_row[0];
			}
			$TathvaNo += 1;
			$TathvaID = "TID".strval($TathvaNo);
			$query = "INSERT INTO Participants (SNo , TathvaID, Name, Email, PhoneNumber, College, RollNumber, Department) VALUES (NULL , '$TathvaID' ,  '$Name', '$Email','$PhoneNumber', '$College', '$RollNumber' ,  '$Department')";
			if($query_run = mysqli_query($mysql_conn,$query)){
				echo "<h1 id='spec'>Congratulations!! Your TathvaID is <span id='tid'>$TathvaID</span></h1>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="modal.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

</head>
<body>

</body>
</html>
