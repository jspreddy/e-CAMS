<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
		if(isset($_GET["result"]) && $_GET["result"]=="success"){?>
			<div class="message">
				Password change successfull.
			</div>
		<?php
		}
		if(isset($_GET["result"]) && $_GET["result"]=="fail"){?>
			<div class="ErrorContainer display">
				Wrong current password.
			</div>
		<?php
		}?>
<script language="javascript">
	function pwdChangeCheck(){
		var d=document.pwdChangeForm;
		var pwdErrMsg="";
		if(d.pwdprev.value==""){
			pwdErrMsg+="<b>Current Password</b>: Enter current password<br>";
		}
		if(d.pwdnew1.value==""){
			pwdErrMsg+="<b>New Password</b>: Enter New password<br>";
		}
		if(d.pwdnew2.value==""){
			pwdErrMsg+="<b>Retype Password</b>: Retype new password<br>";
		}
		if((d.pwdnew1.value)!==(d.pwdnew2.value)){
			pwdErrMsg+="<b>Password - No Match</b>: Password and retyped password do not match<br>";
		}
		if(pwdErrMsg!=""){
			$('#pwd_error').empty().append(pwdErrMsg);
			$('#pwd_error').css("display","block");
			return false;
		}
		else{
			return true;
		}
	}
</script>
<div id="pwd_error" class="ErrorContainer"></div>
<div id="pwdChangeContainer">
	<h3>Change Password</h3>
	<form name="pwdChangeForm" id="pwdChangeForm" onsubmit="return pwdChangeCheck()" action="./runners/ecams-run-pwd-change.php" method="POST">
		<p>
			<label for="pwdprev">
				Current Password<br>
				<input id="pwdprev" class="input" name="pwdprev" type="password" tabindex="1" size="20"/>
			</label>
		</p>
		<p>
			<label for="pwdnew1">
				New Password<br>
				<input id="pwdnew1" class="input" name="pwdnew1" type="password" tabindex="2" size="20"/>
			</label>
		</p>
		<p>
			<label for="pwdnew2">
				Retype Password<br>
				<input id="pwdnew2" class="input" name="pwdnew2" type="password" tabindex="3" size="20"/>
			</label>
		</p>
		<input tabindex="4" id="loginButton" type="submit" value="Change">
	</form>
</div>
<?php
}?>