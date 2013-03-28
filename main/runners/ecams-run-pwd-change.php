<?php
ob_start();
session_start();
if(!isset($_SESSION["id"])){
	header("Location: ../index.php");
}
else{
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["pwdprev"])&& isset($_POST["pwdnew1"])&& isset($_POST["pwdnew2"]))
	{
		$pwdsetresult=false;
		$id=$_SESSION["id"];
		$enc_pass=ecams_encrypt($_POST["pwdprev"],AUTH_KEY);
		$query="select id from users where id='$id' and user_pass='$enc_pass'";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count==1)
		{
			$enc_newpwd1=ecams_encrypt($_POST["pwdnew1"],AUTH_KEY);
			$enc_newpwd2=ecams_encrypt($_POST["pwdnew2"],AUTH_KEY);
			
			if($enc_newpwd1==$enc_newpwd2){
				$query="update users set user_pass='$enc_newpwd1' where id='$id'";
				$result=mysql_query($query) or die(mysql_error());
				header("Location: ../home.php?pwd=change&result=success");
			}
			else{
				header("Location: ../home.php?pwd=change&result=fail");
			}
		}
		else{
			header("Location: ../home.php?pwd=change&result=fail");
		}
	}
	else{
		header("Location: ../home.php?pwd=forgot&result=fail");
	}
}
ob_flush();
?>