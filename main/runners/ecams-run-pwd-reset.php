<?php
ob_start();
@session_start();
if(isset($_SESSION["id"])){
	header("Location: ../home.php");
}
else{
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["email"]))
	{
		$inputvalid=false;
		$sender = "admin.e_cams";
		$mailfrom = "admin.e_cams@drkgroup.org";
		$subject = "Reset Password : e-CAMS";
		$header="From: ".$sender. "\r\n" . "Reply-To:" .$mailfrom. "\r\n" ."Content-type: text/html\r\n";
		if((strpos($_POST["email"],"@")===false) && (strpos($_POST["email"],".")===false)){ //got a username via the post.
			$uname=mysql_real_escape_string($_POST["email"]);
			$query="select id, user_login, user_email from users where user_login='$uname'";
			$inputvalid=true;
		}
		else if((strpos($_POST["email"],"@")>0) && ( strpos($_POST["email"],".")>strpos($_POST["email"],"@") )){ //got an email id through post
			$email=mysql_real_escape_string($_POST["email"]);
			$query="select id, user_login, user_email from users where user_email='$email'";
			$inputvalid=true;
		}
		else{$inputvalid=false;}
		$mailsent=false;
		if($inputvalid==true){
			$result=mysql_query($query) or die(mysql_error());
			$count=mysql_num_rows($result);
			if($count==1)
			{
				$row=mysql_fetch_array($result);
				$uname=$row["user_login"];
				$mailto=$row["user_email"];
				$id=$row["id"];
				$pass=ecams_alphanumeric_pass();
				$enc_pass=ecams_encrypt($pass,AUTH_KEY);
				$mail_body = "Your password for your account has been reset.<br>user name: ".$uname."<br>Password: ".$pass."<br><br>Login with this password and change your password."; //mail body
				$query2="update users set user_pass='$enc_pass' where id='$id'";
				$result2=mysql_query($query2) or die(mysql_error());
				$count2=mysql_affected_rows();
				if($count2==1){
					mail($mailto, $subject, $mail_body,$header); //mail command
					$mailsent=true;
				}
			}
		}
		if($mailsent==true){
			header("Location: ../index.php?pwd=forgot&reset=success");
		}
		else{
			header("Location: ../index.php?pwd=forgot&reset=fail");
		}
	}
	else{
		header("Location: ../index.php?pwd=forgot&reset=fail");
	}
}
ob_flush();
?>