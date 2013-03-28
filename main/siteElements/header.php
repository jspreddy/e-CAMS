<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
?>
<div class="headerLogo">e-CAMS</div>
<div class="header">
	<?php
		$user_type_array=array("","Admin","Principal","HOD","Staff");
		require_once("./includes/databaseConnection.php");
		require_once("./config/SystemConstantsConfig.php");
		require_once("./includes/EncryptionFunctions.php");
		require_once("./includes/initialisation.php");
	?>
	<div class="welcome"><b>Welcome | <?php echo $user_type_array[$_SESSION["user_type"]];?> | <?php echo $_SESSION["display_name"];?> </b></div>
	<ul>
		<li><a href="./runners/ecams-run-logout.php">Logout</a></li>
		<li><a href="./home.php?pwd=change">Change Password</a></li>
		<li><a href="./home.php?profile=edit">Edit Profile</a></li>
	</ul>
</div>
<?php
}?>