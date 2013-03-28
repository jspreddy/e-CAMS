<?php

/* Checks if there is a user logged in and checks if the user is an admin.
 * Also checks the method type and the required parameters are being passed in the intended format or not.
 * generates the contact embed code.
 * 
 */
ob_start();
session_start();

if(isset($_SESSION["id"]) && isset($_SESSION["user_type"]) && $_SESSION["user_type"]==1 && $_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["uid"]) && filter_input(INPUT_GET,"uid", FILTER_VALIDATE_INT) && ($_GET["uid"]>0)){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	$uid=$_GET["uid"];
	//sleep(3); //sleep for the sake of testing the ajax load functionality
	$query_search="select activation_key from users where id='$uid' limit 1";
	$result_search=mysql_query($query_search) or die(mysql_error());
	$count_search=  mysql_num_rows($result_search);
	if($count_search==1){
		$row=mysql_fetch_array($result_search);
		if($row["activation_key"]==""){
			$key=ecams_gen_key();
			$query_update="update users set activation_key='$key' where id='$uid' limit 1";
			mysql_query($query_update) or die(mysql_error());
			$count_update=mysql_affected_rows();
			if($count_update==1){
				echo "<body><script language='javascript' src='".BASE_INSTALL_LINK."/main/js/jquery-1.7.1.min.js'></script><div id='profLoadContanier$uid'></div><script language='javascript'>$.get('".BASE_INSTALL_LINK."/main/external/ext_send_profile.php?uid=$uid&key=$key',function(data){ $('#profLoadContanier$uid').html(data); });</script></body>";
			}
			else{echo "ERROR : contact developer";}
		}
		else{
			$key=$row["activation_key"];
			echo "<body><script language='javascript' src='".BASE_INSTALL_LINK."/main/js/jquery-1.7.1.min.js'></script><div id='profLoadContanier$uid'></div><script language='javascript'>$.get('".BASE_INSTALL_LINK."/main/external/ext_send_profile.php?uid=$uid&key=$key',function(data){ $('#profLoadContanier$uid').html(data); });</script></body>";
		}
	}
	else{
		echo "Unable to get the code. Check if you are using the application like it should be.";
	}
}
else{
	echo "HACKER ALERT.";
}
ob_end_flush();
?>
