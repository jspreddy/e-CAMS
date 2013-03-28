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
	require_once("../includes/initialisation.php");
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["rid"]) && filter_input(INPUT_GET, "rid", FILTER_VALIDATE_INT) && $_GET["rid"]>0){
		$rid=  filter_input(INPUT_GET, "rid", FILTER_VALIDATE_INT);
		$uid=$_SESSION["id"];
		if(getUType()==1){
			$extend=" ";
		}
		else{
			$extend=" and uid=$uid";
		}
		$getQuery="SELECT filename from cdc_downloads where rid='$rid'".$extend;
		$result=mysql_query($getQuery) or die(mysql_error());
		$count=  mysql_num_rows($result);
		if($count==1){
			$row = mysql_fetch_array($result);
			$filename=$row["filename"];
			$filePath="../../CDC/CDC_UploadDocs/".$filename;

			if(file_exists($filePath)){
				$del=unlink($filePath);
			}
			else{
				$del=true;
			}
			if($del){
				$delQuery="delete from cdc_downloads where rid='$rid' limit 1";
				$result_del=mysql_query($delQuery) or die(mysql_error());
				$count1=  mysql_affected_rows();
				if($count1==1){
					header("Location: ../CDC.php?mode=manage&msg=Succ");
				}
				else{
					header("Location: ../CDC.php?mode=manage&msg=Error");
				}
			}
			else{
				header("Location: ../CDC.php?mode=manage&msg=Error");
			}
		}
		else{
			header("Location: ../CDC.php?mode=manage&msg=noExist");
		}
	}
	else{
		header("Location: ../CDC.php?mode=manage&error=hacker");
	}
}
ob_end_flush();
?>