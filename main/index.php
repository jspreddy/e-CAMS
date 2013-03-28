<?php
	require("./includes/initialisation.php");
	session_start();
	if(isset($_SESSION["id"]) && isset($_SESSION["user_status"]) && isset($_SESSION["display_name"]) && isset($_SESSION["user_type"])){
		header("Location: home.php");
	}
	$formtype="Login";
	if(isset($_GET["pwd"]) && $_GET["pwd"]=="forgot"){
		$formtype="Forgot Password";
	}
	$loginfail=false;
	if(isset($_GET["login"]) && $_GET["login"]=="fail"){
		$loginfail=true;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>e-CAMS -> <?php echo $formtype;?></title>
		<link type="text/css" rel="stylesheet" href="./css/login_style.css" />
		<script language="javascript" src="./js/jquery-1.7.1.min.js"></script>
		<?php if($formtype=="Login"){?>
			<script language="javascript">
				function loginCheck(){
					var d=document.loginForm;
					var errMsg="";
					if(d.uname.value==""){
						errMsg+="<b>UserName:</b> Enter a user name<br>";
					}
					
					if(d.pass.value==""){
						errMsg+="<b>Password:</b> Enter a password<br>";
					}
					
					if(errMsg!=""){
						$('#err_msg').empty().append(errMsg);
						$('#err_msg').css("display","block");
						return false;
					}
					else{
						return true;
					}
				}
			</script>
		<?php 
		}else{
		?>
			<script language="javascript">
				function emailCheck(){
						var d=document.resetForm;
						var errMsg="";
						if(d.email.value==""){
							errMsg+="<b>Email/Username:</b> Enter either username or your registered email<br>";
						}
						if(errMsg!=""){
							$('#err_msg').empty().append(errMsg);
							$('#err_msg').css("display","block");
							return false;
						}
						else{
							return true;
						}
					}
			</script>
		<?php 
		}?>
	</head>
	<body>
		<div class="login">
			<div class="title">e-CAMS</div>
			<?php if($formtype=="Forgot Password"){?>
				<div class="message">
					Please enter your registered username or email address associated with your account. You will receive a reset password via email.
				</div>
				<?php
				if(isset($_GET["reset"]) && $_GET["reset"]=="fail"){
				?>
					<div class="ErrorContainer display">
						No account exists with the given credentials.
					</div>
				<?php
				}
				if(isset($_GET["reset"]) && $_GET["reset"]=="success"){
				?>
					<div class="message">
						your userid and password have been mailed to your registered email id.
					</div>
				<?php 
				}?>
			<?php 
			}?>
			<?php if(isset($_GET["logout"]) && $_GET["logout"]=="true"){?>
				<div class="message">
					You are now logged out.
				</div>
			<?php
			}?>
			<?php if(isset($_GET["mode"]) && $_GET["mode"]=="blocked"){?>
				<div class="ErrorContainer display">
					Your account has been <b>blocked</b> by <b>Administrator</b>.
				</div>
			<?php
			}?>
			<div id="err_msg" class="ErrorContainer <?php if($loginfail){echo " display";}?>">
				<?php if($loginfail){echo"<b>Invalid UserName or password.</b><br>Please try again.";}?>
			</div>
			<div class="loginContainer">
				<?php if($formtype=="Login"){?>
					
					<form name="loginForm" id="loginForm" onsubmit="return loginCheck()" action="./runners/ecams-run-login.php" method="POST">
						<p>
							<label for="username">
								User Name<br>
								<input id="username" class="input" name="uname" type="text" tabindex="1" size="20"/>
							</label>
						</p>
						<p>
							<label for="password">
								Password<br>
								<input id="password" class="input" name="pass" type="password" tabindex="2" size="20"/>
							</label>
						</p>
						<a tabindex="4" href="index.php?pwd=forgot" >Forgot password?</a>
						<input tabindex="3" id="loginButton" type="submit" value="Log In">
					</form>
				<?php 
				}
				else if($formtype=="Forgot Password"){ 
				?>
					
					<form name="resetForm" id="loginForm" onsubmit="return emailCheck()" action="./runners/ecams-run-pwd-reset.php" method="POST">
						<p>
							<label for="email">
								UserName / Email<br>
								<input id="email" class="input" name="email" type="text" tabindex="1" size="20"/>
							</label>
						</p>
						<a id="" href="index.php" >Go to Log in</a>
						<input id="loginButton" type="submit" value="Go">
					</form>
					
				<?php
				}
				?>
			</div>
		</div>
	</body>
</html>