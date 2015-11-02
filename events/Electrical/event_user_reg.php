<html>
	<head>
	</head>
	<body>
		<center><form action = 'event_user_reg.php' method = 'POST' >
						TathvaID:<input type='text' name='TathvaID'><br>
						CaptainID:<input type='text' name='CaptainID'><br>
						PhoneNumber:<input type='number' name='PhoneNumber' maxlength = 10 ><br>
						Select An Event:
						<select name = 'EventCode'>
							<option value = "" selected></option>
							<?php 
								require 'connectDatabase.php';
								$query = "SELECT * FROM Events";
								if($query_run = mysqli_query($mysql_conn,$query)){
									while($query_row = mysqli_fetch_array($query_run,MYSQLI_NUM)){
										echo "<option value = '$query_row[2]'>$query_row[1]</option>";
									}
								}
							?>
						</select><br>
						<input type="submit" value="Register">
					</form></center>
	</body>
</html>

<?php
	require 'connectDatabase.php';
	$TathvaID = trim(mysqli_real_escape_string($mysql_conn , strtoupper($_POST['TathvaID'])));
	$PhoneNumber = trim(mysqli_real_escape_string($mysql_conn , $_POST['PhoneNumber']));
	$CaptainID = trim(mysqli_real_escape_string($mysql_conn , strtoupper($_POST['CaptainID'])));
	$EventCode = trim(mysqli_real_escape_string($mysql_conn , $_POST['EventCode']));
	
	$flag = 0;
	
	if(empty($PhoneNumber) && isset($_POST['EventCode'])){
		echo "Phone Number Not Set";
		$flag =1;
	}
	else if(!(ctype_digit($PhoneNumber) && strlen($PhoneNumber) == 10 ) && isset($_POST['EventCode'])  ){
		echo "Invalid Phone Number";
		$flag=1;
	}
	
	if(empty($TathvaID) && isset($_POST['EventCode'])){
		echo "TathvaID Not Set";
		$flag =1;
	}
	
	
	if(empty($EventCode) && isset($_POST['EventCode'])){
		echo "EventCode Not Set";
		$flag =1;
	}
	
	if($flag == 0 && isset($_POST['EventCode'])){
		$query = "SELECT * FROM Events WHERE  EventCode = '$EventCode'";
		if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)==0)){
			echo "Event Not Registered";
		}
		else{
			$query = "SELECT * FROM Participants WHERE  TathvaID = '$TathvaID' AND PhoneNumber = '$PhoneNumber'";
			if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)==0)){
				echo "You Are Not Registered";
			}
			else{
				$query = "SELECT * FROM Registration WHERE  TathvaID = '$TathvaID'";
				if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)!=0) && empty($CaptainID)){
					echo "You Are Already Registered For The Event"; 
				}else if(empty($CaptainID)){
					$query = "INSERT INTO Registration (SNo , EventCode, TathvaID, CaptainID) VALUES (NULL , '$EventCode' ,'$TathvaID' ,  '$TathvaID')";
					if($query_run = mysqli_query($mysql_conn,$query)){
						echo "Congratulation You Registered For The Event"; 
					}
					else
						echo "Failure";
				}
				$query = "SELECT * FROM Registration WHERE  TathvaID = '$CaptainID'";
				if(($query_run = mysqli_query($mysql_conn,$query)) && (mysqli_num_rows($query_run)==0) && !empty($CaptainID)){
					echo "Captain Not Registered For The Event"; 
				}else if(!empty($CaptainID)){
					$query = "INSERT INTO Registration (SNo , EventCode, TathvaID, CaptainID) VALUES (NULL , '$EventCode' ,'$TathvaID' ,  '$CaptainID')";
					if($query_run = mysqli_query($mysql_conn,$query)){
						echo "Congratulation You Registered For The Event"; 
					}
					else
						echo "Failure";
				}
			}
		}
	}
?>

