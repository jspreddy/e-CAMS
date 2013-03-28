<?php
/****************************************************************************************
* Function : ecams_encrypt()
* used for encrypting the passwords
* input : takes the user provided password and the key from the system configuration file
* output: returns the encrypted password in a hexadecimal format.
*****************************************************************************************
*/
	function ecams_encrypt($pass,$key){
		$iv="testtest";//the size of initialisation vector should be 8.
		$pass=mcrypt_encrypt(MCRYPT_DES,$key,$pass,MCRYPT_MODE_CBC,$iv);
		return bin2hex($pass);
	}
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/


/**********************************************
* Function : ecams_alphanumericPass()
* used to generate random password of length 6
* input : void
* output: random alpha numeric password
***********************************************
*/
	function ecams_alphanumeric_pass()
	{
		// Do not modify anything below here
		$underscores = 2; // Maximum number of underscores allowed in password
		$length = 6; // Length of password
		$p ="";
		for ($i=0;$i<$length;$i++)
		{   
			$c = mt_rand(1,10);
			switch ($c)
			{
				case ($c<=2):
					// Add a number
					$p .= mt_rand(0,9);   
				break;
				case ($c<=4):
					// Add an uppercase letter
					$p .= chr(mt_rand(65,90));   
				break;
				case ($c<=6):
					// Add a lowercase letter
					$p .= chr(mt_rand(97,122));   
				break;
				case ($c<=10):
					 $len = strlen($p);
					if ($underscores>0&&$len>0&&$len<($length-1)&&$p[$len-1]!="_")
					{
						$p .= "_";
						$underscores--;   
					}
					else
					{
						$i--;
						continue;
					}
				break;       
			}
		}
		return $p;
	}
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/

/****************************************************************************************
* Function	: ecams_gen_key()
* used for	: generating the key for a user
* input		: none
* dependency: uses the functions alphanumericpass() , ecams_encrypt()
* output	: returns a key for a user. this can be used when authenticating
*			  access for an external site to get contact details.
*			  size	:168 bytes
*			  length	:48 chars
*****************************************************************************************
*/
	function ecams_gen_key(){
		$base_key="";
		for($lc=0;$lc<4;$lc++){
			$base_key.=ecams_alphanumeric_pass();
		}
		//echo $base_key."<br>";
		//$start=  memory_get_usage();
		$enc_key=ecams_encrypt($base_key, "1@eo0&");
		//echo memory_get_usage()-$start."<br>";
		//echo $enc_key."<br>";
		//echo strlen($enc_key)."<br>";
		return $enc_key;
	}

/****************************************************************************************************************************************/
/****************************************************************************************************************************************/


/******************************************
* function: ecams_chk_profile_editable()
* used to check if the profile is editable
* input : user id
* output: boolean false if not editable
*		  boolean true if editable
*		  string start date if started
*******************************************
*/	
	function ecams_chk_profile_editable($uid){
		
		$query="select last_edit_date from profiles where id='$uid'"; //get the last edited date of the user profile
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		
		if($count==1){ //profile has been edited ie there is an entry in the profile for the user
			$row=mysql_fetch_array($result);
			
			$currentdate=date("Y-m-d H:i:s"); //current date
			$last_edit_date=$row["last_edit_date"];
			if($last_edit_date=="0000-00-00 00:00:00"){
				return true; // for backward compatibility with the previous database
			}
			else{
				$diff = abs(strtotime($currentdate) - strtotime($last_edit_date)); //get the difference between the dates
				$days = floor(($diff)/ (60*60*24)); // floor the difference to days
				if($days==0){
					return $last_edit_date; //the time since last edit is with in one day and so the profile is editable, so return edit date
				}
				else{
					return false; //the time since last edit is more than one day  and so the profile is locked
				}
			}
		}
		else{ //profile was never edited
			return true; //return that the profile can be edited now
		}
	}

/****************************************************************************************************************************************/
/****************************************************************************************************************************************/



/******************************************
* function: ecams_return_profile_countdown()
* used to return the javascript format date for the count down functionality
* input : user id
* output: boolean false if not exists / editable
*		  last edit date if editable
*******************************************
*/	
	function ecams_return_profile_countdown($uid){
		
		$query="select last_edit_date from profiles where id='$uid'"; //get the last edited date of the user profile
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		
		if($count==1){ //profile has been edited ie there is an entry in the profile for the user
			$row=mysql_fetch_array($result);
			
			$last_edit_date=$row["last_edit_date"];
			if($last_edit_date=="0000-00-00 00:00:00"){
				return false; // for backward compatibility with the previous database, never edited the profile
			}
			else{
				$da=str_split($last_edit_date);
				$date_year=intval($da[0].$da[1].$da[2].$da[3]);
				
				$date_month=intval($da[5].$da[6])-1;
				
				$date_day=intval($da[8].$da[9])+1;
				$date=$date_year.", ".$date_month.", ".$date_day.", ".$da[11].$da[12].", ".$da[14].$da[15].", ".$da[17].$da[18];
				return $date;
			}
		}
		else{ //profile was never edited
			return false; //return that the profile can be edited now
		}
	}
	
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/

/******************************************
* function: ecams_return_profile_edit_date()
* used to return a date to enter into the profile table on update
* input : user id
* output: return the profile edit date if exists
*		  return the current date if the profile is being edited for the first time
*******************************************
*/	
	function ecams_return_profile_edit_date($uid){
		
		$query="select last_edit_date from profiles where id='$uid'"; //get the last edited date of the user profile
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		
		if($count==1){ //profile has been edited ie there is an entry in the profile for the user
			$row=mysql_fetch_array($result);
			$last_edit_date=$row["last_edit_date"];
			if($last_edit_date=="0000-00-00 00:00:00"){ //if the edit date is zero then return current date
				return date("Y-m-d H:i:s"); //return current date
			}
			else{
				return $last_edit_date;
			}
		}
		else{ //profile was never edited
			return date("Y-m-d H:i:s"); //return current date
		}
	}

/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
	
/****************************************************************************************************************************************/

	function getUType(){
		if(isset($_SESSION["user_type"]))
			return $_SESSION["user_type"];
		else
			die("The session doesn't contain the userType data.");
	}
	function getUid(){
		if(isset($_SESSION["id"]))
			return $_SESSION["id"];
		else
			die("The session doesn't contain the U-ID data.");
	}
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
/****************************************************************************************************************************************/
/****************************************************************************************************************************************/
?>