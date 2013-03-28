<?php
ob_start();
session_start();
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["uid"]) && $_GET["uid"]>=0){
		$uid=filter_input(INPUT_GET,"uid",FILTER_SANITIZE_NUMBER_INT);
		
		if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
			$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
		}else{$offset=0;}
		
		$query="select user_status, user_type from users where id='$uid'";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count==1){
			$row=mysql_fetch_array($result);
			if($_GET["uid"]!==$_SESSION["id"]){
				if($row["user_status"]==1){
					$query2="update users set user_status='0' where id='$uid'";
				}
				else if($row["user_status"]==0){
					$query2="update users set user_status='1' where id='$uid'";
				}
				$result=mysql_query($query2) or die(mysql_error());
				$count2=mysql_affected_rows();
				if($count2==1){
					header("Location: ../User.php?mode=view&offset=$offset&msg=block_success");
				}
				else{
					header("Location: ../User.php?mode=view&offset=$offset&error=InternalError");
				}
			}
			else{
				header("Location: ../User.php?mode=view&offset=$offset&error=blockown");
			}
		}
		else{
			header("Location: ../User.php?mode=view&offset=$offset&error=NoExist");
		}
	}
	else{
		header("Location: ../User.php?mode=view&offset=$offset&error=hacker");
	}
}
else{
	header("Location: ../home.php");
}
ob_end_flush();
?>