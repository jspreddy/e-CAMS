<?php
ob_start();
session_start();
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){ // if accessor is an admin
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["uid"]) && $_GET["uid"]>=0){ // if the access methoid is valid and not a hack attempt
		$uid=filter_input(INPUT_GET,"uid",FILTER_SANITIZE_NUMBER_INT);
		
		if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
			$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
		}else{$offset=0;}
		
		//user get query
		$query="select * from users where id='$uid'";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count==1){ //if user exists
			$row=mysql_fetch_array($result);
			if($row["user_type"]!=1){ // if the user to be deleted is not an admin
				$id=$row["id"];
				$user_login=  mysql_escape_string($row["user_login"]);
				$user_pass=mysql_escape_string($row["user_pass"]);
				$user_email=mysql_escape_string($row["user_email"]);
				$user_registered_date=mysql_escape_string($row["user_registered_date"]);
				$activation_key=mysql_escape_string($row["activation_key"]);
				$user_status=mysql_escape_string($row["user_status"]);
				$display_name=mysql_escape_string($row["display_name"]);
				$user_type=mysql_escape_string($row["user_type"]);
				
				//profile get query
				$query="select * from profiles where id='$uid'";
				$result=mysql_query($query) or die(mysql_error());
				$count_profile=mysql_num_rows($result);
				
				if($count_profile==1){ //if profile exists
					$row=mysql_fetch_array($result);
					$first_name=mysql_escape_string($row["first_name"]);
					$last_name=mysql_escape_string($row["last_name"]);
					$dob=mysql_escape_string($row["dob"]);
					$photo=mysql_escape_string($row["photo"]);
					$department=mysql_escape_string($row["department"]);
					$post=mysql_escape_string($row["post"]);
					$qualification=mysql_escape_string($row["qualification"]);
					$second_email=mysql_escape_string($row["second_email"]);
					$phone=mysql_escape_string($row["phone"]);
					$mobile=mysql_escape_string($row["mobile"]);
					$address=mysql_escape_string($row["address"]);
					$last_edit_date=mysql_escape_string($row["last_edit_date"]);
				}
				else{
					//initialising the profile variables if profile entry does not exist
					$first_name="";
					$last_name="";
					$dob="";
					$photo="";
					$department="";
					$post="";
					$qualification="";
					$second_email="";
					$phone="";
					$mobile="";
					$address="";
					$last_edit_date="";
					//profile variables initialised
				}
				date_default_timezone_set("Asia/Calcutta"); //setting the time zone
				$user_delete_date=date("Y-m-d H:i:s"); // date of deletion of the user
				// got all the data of the user
				
				$insert_query="INSERT INTO `user_archive` (`id`, `user_login`, `user_pass`, `user_email`, `user_registered_date`, `user_delete_date`,
								`activation_key`, `user_status`, `display_name`, `user_type`, `first_name`, `last_name`, `dob`, `photo`, `department`, `post`,
								`qualification`, `second_email`, `phone`, `mobile`, `address`,`last_edit_date`)
								VALUES ('$id', '$user_login', '$user_pass', '$user_email', '$user_registered_date', '$user_delete_date',
								'$activation_key', '$user_status', '$display_name', '$user_type', '$first_name', '$last_name', '$dob', '$photo', '$department', '$post',
								'$qualification', '$second_email', '$phone', '$mobile', '$address','$last_edit_date')";
				$insert_result=mysql_query($insert_query) or die(mysql_error());
				$insert_count=mysql_affected_rows();
				if($insert_count==1){
					$delete_query_users="delete from users where id='$id' limit 1";
					
					$result_delete_users=mysql_query($delete_query_users) or die(mysql_error());
					if($count_profile==1){
						$delete_query_profiles="delete from profiles where id='$id' limit 1";
						$result_delete_profiles=mysql_query($delete_query_profiles) or die(mysql_error());
					}else{$result_delete_profiles=true;}
					if($result_delete_users && $result_delete_profiles){
						header("Location: ../User.php?mode=view&offset=$offset&msg=delete_success");
					}
					else{
						header("Location: ../User.php?mode=view&offset=$offset&error=InternalError");
					}
				}
				else{
					header("Location: ../User.php?mode=view&offset=$offset&error=InternalError");
				}
			}
			else{
				header("Location: ../User.php?mode=view&offset=$offset&error=admin");
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