
<html>
	<head>
		<style>
			.Table {
				margin:0px;padding:0px;
				width:100%;
				box-shadow: 10px 10px 5px #888888;
				border:1px solid #000000;
				
				-moz-border-radius-bottomleft:0px;
				-webkit-border-bottom-left-radius:0px;
				border-bottom-left-radius:0px;
				
				-moz-border-radius-bottomright:0px;
				-webkit-border-bottom-right-radius:0px;
				border-bottom-right-radius:0px;
				
				-moz-border-radius-topright:0px;
				-webkit-border-top-right-radius:0px;
				border-top-right-radius:0px;
				
				-moz-border-radius-topleft:0px;
				-webkit-border-top-left-radius:0px;
				border-top-left-radius:0px;
			}.Table table{
				border-collapse: collapse;
					border-spacing: 0;
				width:100%;
				height:100%;
				margin:0px;padding:0px;
			}.Table tr:last-child td:last-child {
				-moz-border-radius-bottomright:0px;
				-webkit-border-bottom-right-radius:0px;
				border-bottom-right-radius:0px;
			}
			.Table table tr:first-child td:first-child {
				-moz-border-radius-topleft:0px;
				-webkit-border-top-left-radius:0px;
				border-top-left-radius:0px;
			}
			.Table table tr:first-child td:last-child {
				-moz-border-radius-topright:0px;
				-webkit-border-top-right-radius:0px;
				border-top-right-radius:0px;
			}.Table tr:last-child td:first-child{
				-moz-border-radius-bottomleft:0px;
				-webkit-border-bottom-left-radius:0px;
				border-bottom-left-radius:0px;
			}.Table tr:hover td{
				
			}
			.Table tr:nth-child(odd){ background-color:#d4ffaa; }
			.Table tr:nth-child(even)    { background-color:#ffffff; }.Table td{
				vertical-align:middle;
				
				
				border:1px solid #000000;
				border-width:0px 1px 1px 0px;
				text-align:left;
				padding:7px;
				font-size:13px;
				font-family:Arial;
				font-weight:normal;
				color:#000000;
			}.Table tr:last-child td{
				border-width:0px 1px 0px 0px;
			}.Table tr td:last-child{
				border-width:0px 0px 1px 0px;
			}.Table tr:last-child td:last-child{
				border-width:0px 0px 0px 0px;
			}
			.Table tr:first-child td{
					background:-o-linear-gradient(bottom, #007f3f 5%, #007f3f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #007f3f), color-stop(1, #007f3f) );
				background:-moz-linear-gradient( center top, #007f3f 5%, #007f3f 100% );
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#007f3f", endColorstr="#007f3f");	background: -o-linear-gradient(top,#007f3f,007f3f);

				background-color:#007f3f;
				border:0px solid #000000;
				text-align:center;
				border-width:0px 0px 1px 1px;
				font-size:18px;
				font-family:Arial;
				font-weight:bold;
				color:#ffffff;
			}
			.Table tr:first-child:hover td{
				background:-o-linear-gradient(bottom, #007f3f 5%, #007f3f 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #007f3f), color-stop(1, #007f3f) );
				background:-moz-linear-gradient( center top, #007f3f 5%, #007f3f 100% );
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#007f3f", endColorstr="#007f3f");	background: -o-linear-gradient(top,#007f3f,007f3f);

				background-color:#007f3f;
			}
			.Table tr:first-child td:first-child{
				border-width:0px 0px 1px 0px;
			}
			.Table tr:first-child td:last-child{
				border-width:0px 0px 1px 1px;
			}
			body{
				background-color : #add8e6;
			}
			h1{
				font-size: 4em;
			}
			input{
				margin-right: 10em;
				margin-left: 3em;
				margin-bottom:2em;
			}
			.a{
				margin-right: 10em;
			}

			
		</style>
	</head>
	<body>
		<center>
		<h1>Registration Desk</h1>
		<form action = "event_manager.php" method = "POST" >
			Tathva ID:<input type="text" name="TathvaID">
			Phone Number:<input type="number" name="PhoneNumber" maxlength = "10">
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
			<input type="submit" name = "Submit">
		</form><br>
		</center>
		
	</body>
</html>

<?php
	require 'connectDatabase.php';
	$TathvaID = trim(mysqli_real_escape_string($mysql_conn , strtoupper($_POST['TathvaID'])));
	$EventCode = $_POST['EventCode'];
	$PhoneNumber = trim(mysqli_real_escape_string($mysql_conn , $_POST['PhoneNumber']));
	if(isset($_POST['Submit']) && !empty($EventCode)){
		$query = "SELECT @row_number := @row_number +1 AS 'S.No', CaptainID FROM Registration , (SELECT @row_number :=0) AS t WHERE Registration.TathvaID =  Registration.CaptainID AND Registration.EventCode = '$EventCode' ORDER BY SNo";
		if($query_run = mysqli_query($mysql_conn,$query)){
			$query2 = "SELECT EventName FROM Events WHERE EventCode = '$EventCode'";
			$query_run2 = mysqli_query($mysql_conn,$query2);
			$query_row2 = mysqli_fetch_array($query_run2,MYSQLI_NUM);
			echo "<center><h1>$query_row2[0] List</h1></center>";
			echo "<table class='Table'>
					<tr>
						<th>SNo</th>
						<th>Name</th>
						<th>Tathva ID</th>
						<th>College</th>
						<th>Department</th>
						<th>Roll Number</th>
						<th>Email</th>
						<th>PhoneNumber</th>
						<th>Verified?</th>
					</tr>";
					while($query_row = mysqli_fetch_array($query_run,MYSQLI_NUM)){
						$query1 = "SELECT Participants.Name , Participants.TathvaID , Participants.College , Participants.Department , Participants.RollNumber , Participants.Email , Participants.PhoneNumber ,Participants.Verified FROM Participants , Registration WHERE Registration.CaptainID = '$query_row[1]' AND Registration.EventCode = '$EventCode' AND Participants.TathvaID = Registration.TathvaID";
						$query_run1 = mysqli_query($mysql_conn,$query1);
						$Name = "";
						$TathvaID="";
						$College="";
						$Department="";
						$RollNumber="";
						$Email="";
						$Phone="";
						$Verified="";
						while($query_row1 = mysqli_fetch_array($query_run1,MYSQLI_NUM)){
							$Name  .= $query_row1[0].'<br>';
							$TathvaID  .= $query_row1[1].'<br>';
							$College  .= $query_row1[2].'<br>';
							$Department  .= $query_row1[3].'<br>';
							$RollNumber  .= $query_row1[4].'<br>';
							$Email  .= $query_row1[5].'<br>';
							$Phone  .= $query_row1[6].'<br>';
							if($query_row1[7] === true ){
								$Verified .= 'Yes<br>';
							}else{
								$Verified .= 'No<br>';
							}
						}
							echo "<tr>
								<td>$query_row[0]</td>
								<td>$Name</td>
								<td>$TathvaID</td>
								<td>$College</td>
								<td>$Department</td>
								<td>$RollNumber</td>
								<td>$Email</td>
								<td>$Phone</td>
								<td>$Verified</td>
							</tr>";
					}
				echo "</table><br>";
				echo "<center><input type='button' onclick='window.print()' value='Print' /></center>";
		}
	}else if(isset($_POST['Submit']) && !empty($PhoneNumber)){
		$query = "SELECT * FROM Participants WHERE PhoneNumber =  '$PhoneNumber' LIMIT 1";
		$query_run = mysqli_query($mysql_conn,$query);
		if(mysqli_num_rows($query_run)==0){
			echo "<center>Person Not Found</center>";
		}
		else{
			$query_row = mysqli_fetch_array($query_run,MYSQLI_NUM);
			echo "<center><form action = 'event_manager.php?TathvaID=$query_row[1]' method = 'POST' >
					Tathva ID: $query_row[1]<br><br>
					Name:<input type='text' name='Name'  value= '$query_row[2]'><br>
					College:<input type='text' name='College' value= '$query_row[5]'><br>
					Department:<input type='text' name='Department' value= '$query_row[7]'><br>
					Roll Number:<input type='text' name='RollNumber' value= '$query_row[6]'><br>
					Email:<input type='text' name='Email' value= '$query_row[3]'><br>
					Phone Number:<input type='number' name='PhoneNumber' value= '$query_row[4]' maxlength = '10'><br>
					<input type='submit' name = 'Update' value = 'Update'>
					<input type='submit' class = 'a' name = 'Verified' value = 'Verified'>
				</form></center>";
		}
	}else if(isset($_POST['Submit']) && !empty($TathvaID)){
		$query = "SELECT * FROM Participants WHERE TathvaID =  '$TathvaID' LIMIT 1";
		$query_run = mysqli_query($mysql_conn,$query);
		if(mysqli_num_rows($query_run)==0){
			echo "<center>Person Not Found</center>";
		}
		else{
			$query_row = mysqli_fetch_array($query_run,MYSQLI_NUM);
			echo "<center><form action = 'event_manager.php?TathvaID=$query_row[1]' method = 'POST' >
					Tathva ID: $query_row[1]<br><br>
					Name:<input type='text' name='Name'  value= '$query_row[2]'><br>
					College:<input type='text' name='College' value= '$query_row[5]'><br>
					Department:<input type='text' name='Department' value= '$query_row[7]'><br>
					Roll Number:<input type='text' name='RollNumber' value= '$query_row[6]'><br>
					Email:<input type='text' name='Email' value= '$query_row[3]'><br>
					Phone Number:<input type='number' name='PhoneNumber' value= '$query_row[4]' maxlength = '10'><br>
					<input type='submit' name = 'Update' value = 'Update'>
					<input type='submit' class = 'a' name = 'Verified' value = 'Verified'>
				</form></center>";
		}
	}
	else if(isset($_POST['Verified'])){
		$TathvaID = $_GET['TathvaID'];
		$Name = $_POST['Name'];
		$College = $_POST['College'];
		$Department = $_POST['Department'];
		$RollNumber = $_POST['RollNumber'];
		$Email = $_POST['Email'];
		$PhoneNumber = $_POST['PhoneNumber'];
		$query = "UPDATE Participants SET Name = '$Name' , College = '$College', Department = '$Department' , RollNumber = '$RollNumber' , Email = '$Email' , PhoneNumber = '$PhoneNumber' , Verified = 1 WHERE TathvaID =  '$TathvaID'";
		$query_run = mysqli_query($mysql_conn,$query);
		
	}
?>

