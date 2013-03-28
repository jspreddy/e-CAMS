<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){
		if(isset($_GET["msg"]) && $_GET["msg"]=="success"){?>
			<div class="message">
				User Added Sucessfully.
			</div>
		<?php
		}
		if(isset($_GET["error"]) && $_GET["error"]=="UExist"){?>
			<div class="ErrorContainer display">
				<b>User Exists :</b> Please choose a different login-ID as the user with the specified ID already Exists.
			</div>
		<?php
		}
		if(isset($_GET["error"]) && $_GET["error"]=="EExist"){?>
			<div class="ErrorContainer display">
				<b>Email Exists :</b> Please choose a different Email-ID as the specified Email-ID is already in use.
			</div>
		<?php
		}
		if(isset($_GET["error"]) && $_GET["error"]=="UExistEExist"){?>
			<div class="ErrorContainer display">
				<b>User, Email Exists :</b> Please choose a different User-ID and Email-ID as the specified User-ID and Email-ID is already in use.
			</div>
		<?php
		}
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
		if(d.uname.value==""){
			errMsg+="<b>Login-ID:</b> Please enter a Login-ID<br>";
		}
		if(d.pwd1.value==""){
			errMsg+="<b>Password:</b> Please enter a password<br>";
		}
		if(d.pwd1.value!==d.pwd2.value){
			errMsg+="<b>Password -No Match:</b> Password and retyped password do not match.<br>";
		}
		if(d.email.value==""){
			errMsg+="<b>Email:</b> Please enter an email address.<br>";
		}
		if(d.email.value!=""){
			if(!( (d.email.value.indexOf("@")>0) && (d.email.value.lastIndexOf(".") > d.email.value.indexOf("@")+1) )){
				errMsg+="<b>Email</b>: Enter a valid email id.<br>";
			}
		}
		if(d.dname.value==""){
			errMsg+="<b>Display Name:</b> Please enter a display name.<br>";
		}
		if(d.type.value==""){
			errMsg+="<b>User Type:</b> Please select a user type.<br>";
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
		<h3>Add User</h3>
		<form name="addUserForm" id="addUserForm" enctype="multipart/form-data" onsubmit="return userFormCheck()" action="./runners/ecams-run-add-user.php" method="POST">
			<p>
				<label for="uname">
					Login ID: <b>*</b>
					<input id="uname" class="input2" name="uname" type="text" tabindex="1"/>
				</label>
			</p>
			<p>
				<label for="pwd1">
					Password: <b>*</b>
					<input id="pwd1" class="input2" name="pwd1" type="password" tabindex="2"/>
				</label>
			</p>
			<p>
				<label for="pwd2">
					Retype Password: <b>*</b>
					<input id="pwd2" class="input2" name="pwd2" type="password" tabindex="3"/>
				</label>
			</p>
			<p>
				<label for="email">
					Official Email ID: <b>*</b>
					<input id="email" class="input2" name="email" type="text" tabindex="4"/>
				</label>
			</p>
			<p>
				<label for="dname">
					Display Name: <b>*</b>
					<input id="dname" class="input2" name="dname" type="text" tabindex="5"/>
				</label>
			</p>
			<p>
				<label for="status">
					Block User? <b></b>
					<span>Yes<input id="status" class="check" name="status" type="checkbox" tabindex="6"/></span>
				</label>
			</p>
			<p>
				<label for="type">
					User Type <b>*</b>
					<select name="type" id="type" class="input2" tabindex="7">
						<option value=""></option>
						<option value="Administrator">Administrator</option>
						<option value="Principal">Principal</option>
						<option value="HOD">HOD</option>
						<option value="Staff">Staff</option>
					</select>
				</label>
			</p>
			<input tabindex="8" id="postButton" type="submit" value="Submit">
			<input tabindex="9" id="postButton" type="reset" onClick="reset_msgs()" value="Reset">
		</form>
	</div>
<?php
}else{
?>
	Access Denied.
<?php
}?>