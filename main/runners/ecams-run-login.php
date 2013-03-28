<?php
//this script loggs the user into his account by authenticating him aganist the database.
ob_start();
session_start();
if(isset($_SESSION["id"])){
	header("Location: ../home.php");
}
else{
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["uname"]) && isset($_POST["pass"]) && strlen($_POST["uname"])>0 && strlen($_POST["pass"])>0)
	{
		$uname=mysql_real_escape_string($_POST["uname"]);
		$pass=mysql_real_escape_string($_POST["pass"]);
		
		$pass=ecams_encrypt($pass,AUTH_KEY);
		$query="SELECT id, user_status, display_name, user_type from users where user_login='$uname' and user_pass='$pass'";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count==1){
			$row = mysql_fetch_array($result);
			if($row["user_status"]==1){
				$_SESSION["id"]=$row["id"];
				$_SESSION["user_status"]=$row["user_status"];
				$_SESSION["display_name"]=$row["display_name"];
				$_SESSION["user_type"]=$row["user_type"];
				header("Location: ../home.php");
			}
			else{
				session_destroy();
				header("Location: ../index.php?mode=blocked");
			}
		}
		else{
			header("Location: ../index.php?login=fail");
		}
	}
	else{
		header("Location: ../index.php?login=fail");
	}
}
ob_flush();
?>