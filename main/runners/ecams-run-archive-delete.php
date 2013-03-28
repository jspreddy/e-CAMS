<?php
ob_start();
session_start();

if(isset($_SESSION["id"]) && ($_SESSION["user_type"]==1)){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	//initialise the variables
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["uid"]) && ($uid=filter_input(INPUT_GET,"uid",FILTER_VALIDATE_INT))!==false && $uid>0 && isset($_GET["offset"]) && ($offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT))!==false && $offset>=0){
		//echo "user id is : ".$_GET["uid"];
		//echo "<br> offset is : ".$_GET["offset"];
		//sleep(3);
		$query="SELECT photo from user_archive where id=$uid";
		$res1=mysql_query($query) or die(mysql_error());
		$row=mysql_fetch_array($res1);
		if($row["photo"]!=""){
			$pic="../profiles/images/".$row["photo"];
			if(file_exists($pic)){
				unlink($pic);
			}
		}
		$query="delete from user_archive where id=$uid";
		$res2=mysql_query($query) or die(mysql_error());
		$count=  mysql_affected_rows();
		if($count==1){
			echo 1;
		}
		else{
			echo "<div class='ErrorContainer display'>
				<b>Internal error</b> Try Again. If problem persists, contact the administrator/developer.
				</div>";
		}
		
	}
	else{
		echo"<div class='ErrorContainer display'>
			<b>HACKER ALERT!!!!</b> : dude, stop hacking my application.
			</div>";
	}
}
else{
	header("Location: ../index.php");
}
ob_end_flush();
?>