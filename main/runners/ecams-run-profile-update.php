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
	if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["fname"])&& isset($_POST["lname"])&& isset($_POST["dob"]) && isset($_POST["dept"]) && isset($_POST["post"]) && isset($_POST["qual"]) && isset($_POST["mobile"]) && isset($_POST["address"]) && (ecams_chk_profile_editable($_SESSION["id"]) || $_SESSION["user_type"]==1))
	{
		$formError=0;
		$id=$_SESSION["id"];
		$target_path ="../profiles/images/";
		$target_filename=$id.".jpg";
		$editmethod="insert";
		$email2="";
		$phone="";
		$query="";
		$addr="";
		$upload_sucess=false;
		
		$fname = mysql_real_escape_string($_POST["fname"]);
		$lname = mysql_real_escape_string($_POST["lname"]);
		$datearray=explode("-",$_POST["dob"],3);
		if(checkdate($datearray[1],$datearray[2],$datearray[0])){ // input is yyyy-mm-dd, function requirement is mm-dd-yyyy
			$dob=$_POST["dob"];
		}
		else{$formError++;}
		if(isset($_FILES['pic']['name']) && $_FILES['pic']['name']!=""){
			$FileName = $_FILES['pic']['name'];
			$FileSize = $_FILES['pic']['size'];
			$FileType = $_FILES['pic']['type'];
			$FileTmpName = $_FILES['pic']['tmp_name'];
			if(($FileType=="image/jpeg") || ($FileType=="image/pjpeg") || ($FileType=="image/jpg")){
				if(file_exists($target_path.$target_filename)){
					unlink($target_path.$target_filename);
				}
				if(move_uploaded_file($_FILES['pic']['tmp_name'],($target_path.$target_filename))){
					$upload_sucess=true;
				}
				else{
					$formError++;
				}
			}
		}
		$dept_array=array("Administration","Transport","CSE","ECE","EEE","IT","CIVIL","MECH","PG","Other");
		$dept = mysql_real_escape_string($_POST["dept"]);
		if(!in_array($dept,$dept_array, TRUE)){
			$formError++;
		}

		$post = mysql_real_escape_string($_POST["post"]);
		$qual = mysql_real_escape_string($_POST["qual"]);

		if(isset($_POST["email2"]) && $myFilter=filter_input(INPUT_POST,"email2",FILTER_VALIDATE_EMAIL)){
			$email2=$_POST["email2"];
		}
		else if($_POST["email2"]!="" && $myFilter==false){$formError++;}

		if(isset($_POST["phone"]) && $myFilter=filter_input(INPUT_POST,"phone",FILTER_VALIDATE_INT)){
			$phone=$_POST["phone"];
		}
		else if($_POST["phone"]!="" && $myFilter==false){$formError++;}

		if(filter_input(INPUT_POST,"mobile",FILTER_SANITIZE_NUMBER_INT)){
			$mobile=$_POST["mobile"];
		}
		else{$formError++;}

		$addr=mysql_real_escape_string($_POST["address"]);
		
		$last_edit_date=ecams_return_profile_edit_date($_SESSION["id"]); //the date on which the profile was last edited.
		
		if(isset($_POST["logExist"]) && $_POST["logExist"]=="yes"){
			$editmethod="update";
		}
		if(($formError==0) && ($editmethod=="update")){
			$query="update profiles set first_name='$fname', last_name='$lname', dob='$dob', photo='$target_filename', department='$dept', post='$post', qualification='$qual', second_email='$email2', phone='$phone', mobile='$mobile', address='$addr', last_edit_date='$last_edit_date' where id='$id'";
		}
		else if(($formError==0) && ($editmethod=="insert")){
			$query="insert into profiles(id,first_name,last_name,dob,photo,department,post,qualification,second_email,phone,mobile,address,last_edit_date) values('$id','$fname','$lname','$dob','$target_filename','$dept','$post','$qual','$email2','$phone','$mobile','$addr','$last_edit_date')";
		}
		else{
			header("Location: ../home.php?profile=edit&error=formFail");
		}

		if($formError==0){
			$result=mysql_query($query) or die(mysql_error());
			$count=mysql_affected_rows();
			if($count==1){
				header("Location: ../home.php?profile=edit&edit=success");
			}
			else if($upload_sucess){
				header("Location: ../home.php?profile=edit&pic=uploaded");
			}
			else{
				header("Location: ../home.php?profile=edit&error=fatality");
			}
		}
		else{
			header("Location: ../home.php?profile=edit&error=formFail");
		}
	}
	else{
		header("Location: ../home.php?profile=edit&error=hacker");
	}
}
ob_end_flush();
?>