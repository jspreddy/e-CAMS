<?php
ob_start();
session_start();
if(!isset($_SESSION["id"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["uname"]) && isset($_POST["pwd1"]) && isset($_POST["pwd2"]) && isset($_POST["email"]) && isset($_POST["dname"]) && isset($_POST["type"])){
		$formError=0;
		
		$uname= mysql_real_escape_string($_POST["uname"]);
		if($uname==""){$formError++;}
		
		$enc_pwd1=ecams_encrypt($_POST["pwd1"],AUTH_KEY);
		$enc_pwd2=ecams_encrypt($_POST["pwd2"],AUTH_KEY);
		if( ($enc_pwd1!=$enc_pwd2) || ($enc_pwd1=="") ){
			$formError++;
		}
		else{$pwd1=$_POST["pwd1"];}
		
		if(isset($_POST["email"]) && filter_input(INPUT_POST,"email",FILTER_VALIDATE_EMAIL)!=false){
			$email=$_POST["email"];
		}
		else{$formError++;}
		
		$date=date("Y-m-d H:i:s");
		
		$display_name=mysql_real_escape_string($_POST["dname"]);
		if($display_name==""){$formError++;}
		
		if(isset($_POST["status"])){$user_status=0;}
		else{$user_status=1;}
		
		$user_type_array=array("Administrator","Principal","HOD","Staff");
		if(in_array($_POST["type"],$user_type_array, TRUE)){
			switch($_POST["type"]){
				case "Administrator":$user_type=1;break;
				case "Principal":$user_type=2;break;
				case "HOD":$user_type=3;break;
				case "Staff":$user_type=4;break;
			}
		}else{$formError++;}
		
		if($formError==0){
			$query="select id from users where user_login='$uname'";
			$result=mysql_query($query) or die(mysql_error());
			$user_count=mysql_num_rows($result);
			$query="select id from users where user_email='$email'";
			$result=mysql_query($query) or die(mysql_error());
			$email_count=mysql_num_rows($result);
			if($user_count>0 && $email_count>0)
			{
				header("Location: ../User.php?mode=add&error=UExistEExist");
			}
			else if($user_count>0)
			{
				header("Location: ../User.php?mode=add&error=UExist");
			}
			else if($email_count>0){
				header("Location: ../User.php?mode=add&error=EExist");
			}
			else if($user_count==0 && $email_count==0){
				$query="insert into users (user_login, user_pass,user_email,user_registered_date,user_status,display_name,user_type) values ('$uname','$enc_pwd1','$email','$date','$user_status','$display_name','$user_type')";
				$result=mysql_query($query) or die(mysql_error());
				$count=mysql_affected_rows();
				if($count==1){
					
					$mailto=$email;
					$mail_body = "Your account has been created in the e-CAMS project.<br>Your account details are:-<br>user name: ".$uname."<br>Password: ".$pwd1."<br><br>Login with this password and change your password."; //mail body
					$sender = "admin.e_cams";
					$mailfrom = "admin.e_cams@drkgroup.org";
					$subject = "Account Created : e-CAMS";
					$header="From: ".$sender. "\r\n" . "Reply-To:" .$mailfrom. "\r\n" ."Content-type: text/html\r\n";
					mail($mailto, $subject, $mail_body,$header); //mail command
					header("Location: ../User.php?mode=add&msg=success");
				}
				else{
					header("Location: ../User.php?mode=add&error=formFail");
				}
			}
		}
		else{
			header("Location: ../User.php?mode=add&error=formFail");
		}
	}
	else{
		header("Location: ../User.php?mode=add&error=hacker");
	}
}
else{
?>
Access Denied.
<?php
ob_end_flush();
}?>