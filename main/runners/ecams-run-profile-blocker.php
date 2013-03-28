<?php
//this script blocks the users profile
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
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["uid"]) && $_GET["uid"]>=0){
		$uid=filter_input(INPUT_GET,"uid",FILTER_SANITIZE_NUMBER_INT);
		
		if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
			$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
		}else{$offset=0;}
		
		
	}
	else{
		
	}
}
else{
?>
Access Denied.
<?php
ob_end_flush();
}?>