<?php
require_once("initdb.php");
$msg = "";
	if (isset($_POST["signin"])) 
	{
		$user = $mysqli->real_escape_string($_POST['username']);
		$pass = $mysqli->real_escape_string($_POST['password']);
		if ($user == $u_ad && $pass == $p_ad) 
		{
			$_SESSION['type'] = 0;
			$_SESSION['uname'] = 'admin';
			$_SESSION['page'] = $ad_page;
			$_SESSION['login'] = 1;
			header("Location:".$ad_page);
			_exit();
		} else if ($user == $u_ml && $pass == $p_ml) {
			$_SESSION['uname'] = 'mailer';
			$_SESSION['type'] = 'ML';
			$_SESSION['page'] = $ml_page;
			$_SESSION['login'] = 1;
			header("Location:".$ml_page);
			_exit();
		} else if ($user == $u_cl && $pass == $p_cl) {
			$_SESSION['type'] = 'CL';
			$_SESSION['uname'] = 'collegelist';
			$_SESSION['page'] = $cl_page;
			$_SESSION['login'] = 1;
			header("Location:".$cl_page);
			_exit();
		} else if ($user == $u_pl && $pass == $p_pl) {
			$_SESSION['uname'] = 'publist';
			$_SESSION['type'] = 'PL';
			$_SESSION['page'] = $pl_page;
			header("Location:".$pl_page);
			$_SESSION['login'] = 1;
			_exit();
		}
		$res = $mysqli->query("select eventcode, validate from users where username='$user' and password='$pass'");
		if ($res->num_rows == 0)
		{

			$msg = "Invalid Username or Password!";
			//header("Location:login.php");
		}
		else
		{
			$row = $res->fetch_assoc();
			if ($row['validate'] == 0)
			{
				$msg = "Your account needs to be validated!";
				$erlist = $row['eventcode'];
				if ($erlist == '-pr') $erlist = '';
			} 
			else 
			{
				$_SESSION['uname'] = $user;
				if ($row['eventcode'] == '-pr') 
				{
					$_SESSION['type'] = 'PR';
					$_SESSION['usertype'] = 'PROOFREADER';
					$_SESSION['page']=$pr_page;
				} else if ($row['eventcode'] == '-mk') 
				{
					$_SESSION['type'] = 'MK';
					$_SESSION['usertype'] = 'MARKETING MANAGER';
					$_SESSION['page']=$mk_page;

				} else if ($row['eventcode'] == '-nu') 
				{
					$_SESSION['type'] = 'NU';
					$_SESSION['usertype'] = 'REGULAR USER';
					$_SESSION['page']=$nu_page;
				} 
				else 
				{
					$_SESSION['type'] = 'MN';
					$_SESSION['ecode'] = $row['eventcode'];
					$_SESSION['usertype'] = 'EVENT MANAGER';
					$_SESSION['page']=$mn_page;
				}
				$_SESSION['login'] = 1;
				session_start();
				header("Location:".$_SESSION['page']);
				$res->free();
				_exit();
			}
		}
	}
?>	