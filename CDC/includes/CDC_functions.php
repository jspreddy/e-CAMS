<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function getName($uid=-1){
	if($uid==-1){
		$uid=$_SESSION['id'];
		$query="select first_name, last_name from profiles where id=$uid";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count!=1){
			return $_SESSION['display_name'];
		}
		else{
			$row=mysql_fetch_array($result);
			return $row['first_name'].", ".$row['last_name'];
		}
	}
	else{
		$query="select first_name, last_name from profiles where id=$uid";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count!=1){
			$query="select display_name from users where id=$uid limit 1";
			$result=mysql_query($query) or die(mysql_error());
			return mysql_result($result,0,0);
		}
		else{
			$row=mysql_fetch_array($result);
			return $row['first_name'].", ".$row['last_name'];
		}
	}
}
?>