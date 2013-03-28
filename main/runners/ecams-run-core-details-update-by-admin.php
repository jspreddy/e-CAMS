<?php
	//used to update the core user details by the admin
ob_start();
session_start();
if(isset($_SESSION["id"]) && ($_SESSION["user_type"]==1) && $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["uid"]) && ($uid=filter_input(INPUT_POST,"uid",FILTER_VALIDATE_INT))!==false && isset($_POST["offset"]) && ($offset=filter_input(INPUT_POST,"offset",FILTER_VALIDATE_INT))!==false && $_POST["uid"]>0 && $_POST["offset"]>=0){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	//initialise the variables
	$formError=0;
	if(isset($_POST["dname"]) && $_POST["dname"]!="" && isset($_POST["email1"]) && $_POST["email1"]!="" && isset($_POST["type"]) && $_POST["type"]!=""){
		$uid=$_POST["uid"];
		$offset=$_POST["offset"];
		$display_name=mysql_real_escape_string($_POST["dname"]);
		if($display_name==""){$formError++;}
		
		if(isset($_POST["email1"]) && filter_input(INPUT_POST,"email1",FILTER_VALIDATE_EMAIL)!=false){
			$email=$_POST["email1"];
		}
		else{$formError++;}
		
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
			$query_search="select id from users where user_email='$email'";
			$result=mysql_query($query_search) or die(mysql_error());
			$email_count=mysql_num_rows($result);
			$row=mysql_fetch_array($result);
			if($email_count==1 && $row["id"]!=$uid){
				header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset?mode=add&error=EExist");
			}
			else if($email_count>1){
				header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset?error=formFail");
			}
			else if($row["id"]==$uid || $email_count==0){
				$update_query="update users set user_email='$email', display_name='$display_name', user_type='$user_type' where id=$uid";
				$update_result=mysql_query($update_query) or die(mysql_error());
				$update_count=mysql_affected_rows();
				if($update_count==1){
					header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&edit=success");
				}
				else{
					header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=fatality");
				}
			}
		}
		else{
			header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=formFail");
		}
	}
	else{
		header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=formFail");
	}
}
else{
	header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=hacker");
}
ob_end_flush();
?>
