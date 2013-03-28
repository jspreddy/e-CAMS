<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){
		if(isset($_GET["error"]) && $_GET["error"]=="formFail"){?>
			<div class="ErrorContainer display">
				Internal error. Try Again. If problem persists, contact the administrator/developer.
			</div>
		<?php
		}
		if(isset($_GET["error"]) && $_GET["error"]=="hacker"){?>
			<div class="ErrorContainer display">
				<b>HACKER ALERT!!!!</b> : dude, stop hacking my application.
			</div>
		<?php
		}?>
<script language="javascript">
	function userFormCheck(){
		var d=document.addUserForm;
		var errMsg="";
		if(d.ufile.value==""){
			errMsg+="<b>CSV-File:</b> Please select a CSV file which contains the user information to upload<br>";
		}
		else if(d.ufile.value.lastIndexOf(".csv")==-1){
			errMsg+="<b>File Format</b>: Upload only \".csv\" files.<br>";
		}
		if(errMsg!=""){
			$('#addUserError').empty().append(errMsg);
			$('#addUserError').css("display","block");
			return false;
		}
		else{
			return true;
		}
	}
	function reset_msgs(){
		$('#addUserError').empty();
		$('#addUserError').css("display","none");
		window.scrollTo(0,0);
	}
</script>
	<div id="addUserError" class="ErrorContainer"></div>
	<div id="userAdderContainer">
		<h3>Add Users in Bulk from a CSV file</h3>
		<form name="addUserForm" id="addUserForm" enctype="multipart/form-data" onsubmit="return userFormCheck()" action="./User.php?mode=bulk" method="POST">
			<p>
				<label for="ufile">
					CSV File: <b>*</b>
					<input id="ufile" class="input2" name="ufile" type="file" tabindex="1"/>
				</label>
			</p>
			<input tabindex="2" id="postButton" type="submit" value="Submit">
			<input tabindex="3" id="postButton" type="reset" onClick="reset_msgs()" value="Reset">
		</form>
	</div>
	<div class="userBulkAddHelp help">
		Steps to use this feature
		<ul>
			<li>You need MS Word (2007+ have been tested)</li>
			<li>Download the Excel template file : <a href="./tmp/userBulkAdd_template.xlsx">Download</a></li>
			<li>Fill the excel sheet with out making any changes to the structure of the document.</li>
			<li>Do NOT use any commas in the fields.</li>
			<li>save file as <b>.CSV (Comma Seperated Values)</b>..(select from drop down in save as dialogue)</li>
			<li>Upload the .CSV file & watch the magic</li>
		</ul>
	</div>
	<div class="userBulkAddNotices">
			<?php
				if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_FILES['ufile']['name']) && $_FILES['ufile']['name']!="" ){
					
					$userBulkAdd_file="./tmp/tempCsvFile_15422100ioisdf45.csv";
					$upload_sucess=false;
					$FileTmpName = $_FILES['ufile']['tmp_name'];
					
					if(file_exists($userBulkAdd_file)){
						unlink($userBulkAdd_file);
					}
					if(move_uploaded_file($_FILES['ufile']['tmp_name'],$userBulkAdd_file)){
						$upload_sucess=true;
					}
					else{
						?>
						<div class="ErrorContainer display">
							<b>File Upload Fail :</b> try again.
						</div>
						<?php
					}
					if($upload_sucess==true){
						$count = -1;
						$added=0;
						$rejected=0;
						
						$user_type_array=array("Administrator","Principal","HOD","Staff","administrator","principal","hod","staff","admin","staf");
						if (($handle = fopen($userBulkAdd_file, "r")) !== FALSE) {
							
							echo "<ol>";
							while (($data = fgetcsv($handle)) !== FALSE) {
								$formError=0;
								$errorMsg="";
								if($count==-1){$count++;continue;}//skipping first row, first row has the headdings
								if(count($data)!==6){
									die("<b class='fail'>file format error, please download the template, fill it up and reupload.<b><br>");
								}
								$count++;
								
								echo "<li>Line No.".($count+1)." : ";
								
								$uname= mysql_real_escape_string($data[0]);
								if($uname==""){$formError++;$errorMsg.="user name field empty, ";}
								
								if($data[1]==NULL){$formError++;$errorMsg.="password field empty, ";}
								else{
									$pwd1=$data[1];
									$enc_pwd1=ecams_encrypt($data[1],AUTH_KEY);
								}
								
								if(filter_var($data[2],FILTER_VALIDATE_EMAIL)!==false && $data[2]!==NULL){
									$email=$data[2];
								}
								else{$formError++;$errorMsg.="Invalid email, ";}
								
								$date=date("Y-m-d H:i:s");
								
								$display_name=mysql_real_escape_string($data[3]);
								if($display_name==""){$formError++;$errorMsg.="Display name empty, ";}
								
								if($data[4]==0){$user_status=0;}
								else{$user_status=1;}
								
								if(in_array($data[5],$user_type_array, TRUE)){
									switch($data[5]){
										case "Administrator"|"admin"|"administrator":$formError++;$errorMsg.="Admin accounts cannot be created in bulk mode for security reasons. ";break;
										case "Principal"|"principal":$user_type=2;break;
										case "HOD"|"hod":$user_type=3;break;
										case "Staff"|"staff"|"staf":$user_type=4;break;
									}
								}else{$formError++;$errorMsg.="Wrong user type, ";}
								
								if($formError==0){
									$query="select id from users where user_login='$uname'";
									$result=mysql_query($query) or die(mysql_error());
									$user_count=mysql_num_rows($result);
									$query="select id from users where user_email='$email'";
									$result=mysql_query($query) or die(mysql_error());
									$email_count=mysql_num_rows($result);
									if($user_count>0 && $email_count>0){
										echo "<b class='fail'>".$uname."</b> : user exists, <b class='fail'>".$email."</b> email in use, ";
									}
									else if($user_count>0){
										echo "<b class='fail'>".$uname."</b> : user exists, ";
									}
									else if($email_count>0){
										echo "<b class='fail'>".$email."</b> : email in use";
									}
									else if($user_count==0 && $email_count==0){
										$query="insert into users (user_login, user_pass,user_email,user_registered_date,user_status,display_name,user_type) values ('$uname','$enc_pwd1','$email','$date','$user_status','$display_name','$user_type')";
										$result=mysql_query($query) or die(mysql_error());
										$insert_count=mysql_affected_rows();
										if($insert_count==1){
											
											$mailto=$email;
											$mail_body = "Your account has been created in the e-CAMS project.<br>Your account details are:-<br>user name: ".$uname."<br>Password: ".$pwd1."<br><br>Login with this password and change your password."; //mail body
											$sender = "admin.e_cams";
											$mailfrom = "admin.e_cams@drkgroup.org";
											$subject = "Account Created : e-CAMS";
											$header="From: ".$sender. "\r\n" . "Reply-To:" .$mailfrom. "\r\n" ."Content-type: text/html\r\n";
											mail($mailto, $subject, $mail_body,$header); //mail command
											echo "<b class='success'>".$uname."</b> : Added successfully ";
										}
										else{
											echo "Internal Error, Contact Developer";
										}
									}
								}
								else{echo "<b class='fail'>".$uname."</b> : ".$errorMsg;}
								
								echo "</li>";
								unset($uname,$enc_pwd1,$pwd1,$email,$date,$display_name,$user_status);
							}
							fclose($handle);
							echo "</ol>";
						}
					}
					if(file_exists($userBulkAdd_file)){
						unlink($userBulkAdd_file);
					}
				}
			?>
	</div>
<?php
}else{
?>
	Access Denied.
<?php
}?>