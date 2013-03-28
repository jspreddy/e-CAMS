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
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["d_name"]) && isset($_POST["d_category"]) && isset($_FILES["d_file"])){
		$FileName = $_FILES['d_file']['name'];
		$FileSize = $_FILES['d_file']['size'];
		$FileType = $_FILES['d_file']['type'];
		$FileTmpName = $_FILES['d_file']['tmp_name'];
		$Branch=null;
		$DispName = mysql_real_escape_string($_POST["d_name"]);
		if(isset($_POST["d_b_cse"])) { $Branch .="1"; }
		if(isset($_POST["d_b_ece"])) { $Branch .="2"; }
		if(isset($_POST["d_b_eee"])) { $Branch .="3"; }
		if(isset($_POST["d_b_it"]))  { $Branch .="4"; }
		if(isset($_POST["d_b_civ"])) { $Branch .="5"; }
		if(isset($_POST["d_b_mech"])){ $Branch .="6"; }
		if(isset($_POST["d_b_mtech"])){ $Branch .="7"; }
		if(isset($_POST["d_b_mba"])){ $Branch .="8"; }
		if(isset($_POST["d_b_mca"])){ $Branch .="9"; }
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
		$Date = date("y-m-d");
		$uid=$_SESSION['id'];
		
		$_FILES['d_file']["name"]=preg_replace('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\?\\\ ]/',"_",$_FILES['d_file']["name"]);
		if($FileName!='') 
		{	
			$target_path = "../../CDC/CDC_UploadDocs/";
			$random_name=date('Y-m-d_H-i-s_').rand(00000,99999).basename( $_FILES['d_file']["name"]);
			$target_path = $target_path.$random_name;
			if(move_uploaded_file($_FILES['d_file']['tmp_name'], $target_path)){
				$query = "INSERT INTO cdc_downloads(bid, yid, cid, uid, filename, displayname, size, date) values('$Branch','$Year','$Category','$uid','$random_name','$DispName','$FileSize','$Date')";
				
				$result = mysql_query($query) or die(mysql_error());
				if($result)
					header("Location: ../CDC.php?mode=add&msg=Succ");
				else
					header("Location: ../CDC.php?mode=add&msg=internalError");
			}
			else{
				header("Location: ../CDC.php?mode=add&msg=uploadFail");
			}
		}
		else{
			header("Location: ../CDC.php?mode=add&msg=nullFile");
		}
	}
	else{
		header("Location: ../CDC.php?mode=add&error=hacker");
	}
}
ob_end_flush();
?>