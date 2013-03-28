<?php
session_start();
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ./index.php?login=fail");
	session_destroy();
}
else{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>e-CAMS : Download Center</title>
		<link type="text/css" rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/CDC_pannel.css">
		<script language="javascript" src="./js/jquery-1.7.1.min.js"></script>
	</head>
	<body>
		<div class="page">
			<div class="headerContainer">
				<?php require("./siteElements/header.php");?>
			</div>
			<?php require("./siteElements/navBar.php");?>
			<div class="contentContainer">
				<?php
				if(isset($_GET["mode"]) && $_GET["mode"]=="add")
					require("./siteElements/CDC_AddDownload.php");
				else if(isset($_GET["mode"]) && $_GET["mode"]=="manage" )
					require("./siteElements/CDC_ManageDownload.php");
				else if(isset($_GET["mode"]) && $_GET["mode"]=="edit")
					require("./siteElements/CDC_EditDownload.php");
				else
					echo "Access Denied.";
				?>
			</div>
			<div class="footerContainer">
				<?php require("./siteElements/footer.php");?>
			</div>
		</div>
	</body>
</html>
<?php 
}?>