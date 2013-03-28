<?php
ob_start();
session_start();

if(isset($_SESSION["id"]) && ($_SESSION["user_type"]==1)){
	if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["uid"]) && ($uid=filter_input(INPUT_POST,"uid",FILTER_VALIDATE_INT))!==false && $uid>0 && isset($_POST["offset"]) && ($offset=filter_input(INPUT_POST,"offset",FILTER_VALIDATE_INT))!==false && $offset>=0){	
		require_once("../includes/databaseConnection.php");
		require_once("../config/SystemConstantsConfig.php");
		require_once("../includes/EncryptionFunctions.php");
		require_once("../includes/initialisation.php");
		//initialise the variables
		$formError=0;
		$editmethod="insert";
		$email2="";
		$phone="";
		$mobile="";
		$query_profiles="";
		$addr="";
		$dob="";
		$dept="";
		$target_filename=$uid.".jpg";
		$fname = mysql_real_escape_string($_POST["fname"]);
		$lname = mysql_real_escape_string($_POST["lname"]);
		//if date of birth is recieved
		if($_POST["dob"]!=="" && $_POST["dob"]!=="0000-00-00"){
			$datearray=explode("-",$_POST["dob"],3);

			if(checkdate($datearray[1],$datearray[2],$datearray[0])){ // input is yyyy-mm-dd, function requirement is mm-dd-yyyy
				$dob=$_POST["dob"];
			}
			else{$formError++;}
		}
		//if department is recieved
		if($_POST["dept"]!==""){
			$dept_array=array("Administration","Transport","CSE","ECE","EEE","IT","CIVIL","MECH","PG","Other");
			$dept = mysql_real_escape_string($_POST["dept"]);
			if(!in_array($dept,$dept_array, TRUE)){
				$formError++;
			}
		}
		$post = mysql_real_escape_string($_POST["post"]);
		$qual = mysql_real_escape_string($_POST["qual"]);

		if(isset($_POST["email2"]) && $_POST["email2"]!=""){
			if(filter_input(INPUT_POST,"email2",FILTER_VALIDATE_EMAIL)){
				$email2=$_POST["email2"];
			}else{$formError++;}
		}

		if(isset($_POST["phone"]) && $_POST["phone"]!=""){
			if(filter_input(INPUT_POST,"phone",FILTER_VALIDATE_INT) && strlen($_POST["phone"])==8 ){
				$phone=$_POST["phone"];
			}else{$formError++;}
		}

		if(isset($_POST["mobile"]) && $_POST["mobile"]!=""){
			if(filter_input(INPUT_POST,"mobile",FILTER_VALIDATE_INT) && strlen($_POST["mobile"])==10 ){
				$mobile=$_POST["mobile"];
			}else{$formError++;}
		}
	/*
		if(isset($_POST["email2"]) && $myFilter=filter_input(INPUT_POST,"email2",FILTER_VALIDATE_EMAIL)){
			$email2=$_POST["email2"];
		}
		else if($_POST["email2"]!="" && $myFilter===false){$formError++;}

		if(isset($_POST["phone"]) && $myFilter=filter_input(INPUT_POST,"phone",FILTER_VALIDATE_INT)){
			$phone=$_POST["phone"];
		}
		else if($_POST["phone"]!="" && $myFilter===false){$formError++;}

		if(isset($_POST["mobile"]) && filter_input(INPUT_POST,"mobile",FILTER_SANITIZE_NUMBER_INT)){
			$mobile=$_POST["mobile"];
		}
		else if($_POST["mobile"]!=""){$formError++;}
	*/
		$addr=mysql_real_escape_string($_POST["address"]);

		if(isset($_POST["logExist"]) && $_POST["logExist"]=="yes"){
			$editmethod="update";
		}
		if(($formError==0) && ($editmethod=="update")){
			$query_profiles="update profiles set first_name='$fname', last_name='$lname', dob='$dob', photo='$target_filename', department='$dept', post='$post', qualification='$qual', second_email='$email2', phone='$phone', mobile='$mobile', address='$addr' where id='$uid'";
		}
		else if(($formError==0) && ($editmethod=="insert")){
			$query_profiles="insert into profiles(id,first_name,last_name,dob,photo,department,post,qualification,second_email,phone,mobile,address) values('$uid','$fname','$lname','$dob','$target_filename','$dept','$post','$qual','$email2','$phone','$mobile','$addr')";
		}
		else{
			header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=formFail");
		}

		if($formError==0){
			//$result_profiles=
			mysql_query($query_profiles) or die(mysql_error());
			$count_profiles=mysql_affected_rows();
			if($count_profiles==1){
				header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&edit=success");
			}
			else{
				header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=fatality");
			}
		}
		else{
			header("Location: ../contacts.php?mode=view&uid=$uid&offset=$offset&error=formFail");
		}
	}
	else{
		header("Location: ../contacts.php?mode=view&error=hacker");
	}
}
else{
	header("Location: ../index.php");
}
ob_end_flush();
?>