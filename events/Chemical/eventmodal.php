<!DOCTYPE html>
<html>
<head>
	
	<title></title>

	<link rel="stylesheet" type="text/css" href="modal.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>


</head>
<body>

	<?php
		require_once 'connectDatabase.php';
		$TathvaID = trim(mysqli_real_escape_string($mysql_conn , strtoupper($_POST['TathvaID'])));
		$PhoneNumber = trim(mysqli_real_escape_string($mysql_conn , $_POST['PhoneNumber']));
		$EventCode = trim(mysqli_real_escape_string($mysql_conn , $_GET['EventCode']));
		
		$flag = 0;
			
		if(empty($PhoneNumber) && isset($_POST['Register'])){
			echo "<h1>Phone Number Not Set</h1>";
			$flag =1;
		}
		else if(!(ctype_digit($PhoneNumber) && strlen($PhoneNumber) == 10 ) && isset($_POST['EventCode'])  ){
			echo "<h1>Invalid Phone Number</h>";
			$flag=1;
		}
		
		if(empty($TathvaID) && isset($_POST['Register'])){
			echo "<h1>TathvaID Not Set</h1>";
			$flag =1;
		}
		
		if(empty($EventCode) && isset($_POST['Register'])){
			echo "<h1>EventCode Not Set</h1>";
			$flag =1;
		}
		
		if($flag == 0 && isset($_POST['Register'])){
			$query = "SELECT * FROM Events WHERE  EventCode = '$EventCode'";
			if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)==0)){
				echo "<h1>Event Not Registered</h1>";
			}
			else{
				$query = "SELECT * FROM Participants WHERE  TathvaID = '$TathvaID' AND PhoneNumber = '$PhoneNumber'";
				if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)==0)){
					echo "<h1>You Are Not Registered</h1>";
				}
				else{
					$query = "SELECT * FROM Registration WHERE  TathvaID = '$TathvaID' AND EventCode = '$EventCode'";
					if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)!=0)){
						echo "<h1>You Are Already Registered For The Event</h1>"; 
					}else{
						$query = "INSERT INTO Registration (SNo , EventCode, TathvaID, CaptainID) VALUES (NULL , '$EventCode' ,'$TathvaID' ,  '$TathvaID')";
						if($query_run = mysqli_query($mysql_conn,$query)){
							echo "<h1>Congratulations!! You are now registered for the event</h1>"; 
						}
						else
							echo "<h1>Failure</h1>";
					}
				}
			}
		}
	?>

	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<div class="logo"> Register for the event </div>
	<div class="login-block">
	    <form action = 'eventmodal.php?EventCode=<?php echo $EventCode?>' method = 'POST' >
			<input type='text' value="" placeholder="TATHVA ID" name='TathvaID'><br>
			<input type='number' value="" placeholder="PHONE NUMBER" name='PhoneNumber' maxlength = 10 ><br>
			<input type='submit' name='Register' placeholder="SUBMIT" value='Register'>
		</form>
		<div class="logo"> <a href="modal.html"> Get a Tathva ID </a></div>
	</div>

</body>
</html>