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
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["d_rid"]) && filter_input(INPUT_POST, "d_rid", FILTER_VALIDATE_INT) && $_POST["d_rid"]>0
			 && isset($_POST["d_name"]) && isset($_POST["d_category"]) && isset($_POST["d_date"])){
		$rid=  filter_input(INPUT_POST, "d_rid", FILTER_VALIDATE_INT);
		$uid=$_SESSION["id"];
		$validationQuery="select count(*) as count from cdc_downloads where rid=$rid and uid=$uid";
		$validationResult=mysql_query($validationQuery) or die(mysql_error());
		$row=mysql_fetch_array($validationResult);
		if(($row['count']==1) || (getUType()==1)){
			$Branch=null;
			$DispName = mysql_real_escape_string($_POST["d_name"]);
			if(isset($_POST["d_b_cse"])) { $Branch .="1"; } 
			if(isset($_POST["d_b_ece"])) { $Branch .="2"; } 
			if(isset($_POST["d_b_eee"])) { $Branch .="3"; } 
			if(isset($_POST["d_b_it"]))  { $Branch .="4"; } 
			if(isset($_POST["d_b_civ"])) { $Branch .="5"; }
			if(isset($_POST["d_b_mech"])){ $Branch .="6"; }
			if(isset($_POST["d_b_mtech"])){ $Branch .="7";}
			if(isset($_POST["d_b_mba"])) { $Branch .="8"; }
			if(isset($_POST["d_b_mca"])) { $Branch .="9"; }
			$category_array=array("Mid Exams","University Exams","Assignments","Project Docs","Others");
			$Category = $_POST["d_category"];
			if(!in_array($Category,$category_array, TRUE)){
				$Category="Others";
			}
			$Year=null;
			if(isset($_POST["d_y_1"])) { $Year .="1"; }
			if(isset($_POST["d_y_2"])) { $Year .="2"; }
			if(isset($_POST["d_y_3"])) { $Year .="3"; }
			if(isset($_POST["d_y_4"])) { $Year .="4"; }
			if($_POST["d_date"]=="new"){
				$Date = date("y-m-d");
				$query="UPDATE cdc_downloads SET displayname='$DispName', bid='$Branch', yid='$Year', cid='$Category', date='$Date' where rid='$rid' limit 1";
			}
			else{
				$query="UPDATE cdc_downloads SET displayname='$DispName', bid='$Branch', yid='$Year', cid='$Category' where rid='$rid' limit 1";
			}
			$result = mysql_query($query) or die(mysql_error());
			$count=  mysql_affected_rows();

			if($count==1)
				header("Location: ../CDC.php?mode=edit&rid=$rid&msg=Succ");
			else
				header("Location: ../CDC.php?mode=edit&rid=$rid&msg=Error");
		}
		else
			header("Location: ../CDC.php?mode=manage&error=hacker");
	}
	else{
		header("Location: ../CDC.php?mode=manage&error=hacker");
	}
}
ob_end_flush();
?>