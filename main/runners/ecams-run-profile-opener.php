<?php
//this script unlocks/opens the user's profile for 24 hours.
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
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["uid"]) && $_GET["uid"]>=0 && isset($_GET["mode"]) && $_GET["mode"]=="open"){
		$uid=filter_input(INPUT_GET,"uid",FILTER_SANITIZE_NUMBER_INT);
		
		if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
			$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
		}else{$offset=0;}
		
		if(ecams_chk_profile_editable($uid)===false){
			$currentdate=date("Y-m-d H:i:s"); //current date
			$query="update profiles set last_edit_date='$currentdate' where id=$uid limit 1";
			$result=mysql_query($query) or die(mysql_error());
			$count=mysql_affected_rows();
			if($count==1){
				header("Location: ../User.php?mode=view&offset=$offset&msg=success");
			}
			else{
				header("Location: ../User.php?mode=view&offset=$offset&error=internal");
			}
		}
		else{
			header("Location: ../User.php?mode=view&offset=$offset&error=TimeOut");
		}
	}
	else{
		header("Location: ../User.php?mode=view&offset=$offset&error=hacker");
	}
}
else{
?>
Access Denied.
<?php
ob_end_flush();
}?>