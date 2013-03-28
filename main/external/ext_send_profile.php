<?php 
header('Access-Control-Allow-Origin: *');
if(isset($_GET["uid"]) && isset($_GET["key"]) && $_GET["uid"]>=0){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	$id=$_GET["uid"];
	$key=$_GET["key"];
	if($key==""){
		echo "error getting profile; contact admin or developer.";
	}else{
		$auth_query="select id from users where id='$id' and activation_key='$key' limit 1";
		$auth_result=mysql_query($auth_query) or die(mysql_error());
		$res_count=mysql_num_rows($auth_result);
		if($res_count==1){
			$query_users="select user_login, user_email from users where id='$id'";
			$query_profile="select first_name, last_name, dob, department, post, qualification, second_email, phone, mobile, address from profiles where id='$id'";
			$result1=mysql_query($query_users) or die(mysql_error());
			$result2=mysql_query($query_profile) or die(mysql_error());
			$count1=mysql_num_rows($result1);
			$count2=mysql_num_rows($result2);
			$pic=$id.".jpg";
			if($count1==1){
				$row1=mysql_fetch_array($result1);
				$row2=mysql_fetch_array($result2);
			?><html>
				<head>
					<link rel="stylesheet" type="text/css" href='<?php echo BASE_INSTALL_LINK;?>/main/external/profileStyle.css'>
				</head>
				<body>
					<div class="profileCardContainer">
						<img id="dp" src='<?php echo BASE_INSTALL_LINK;?>/main/profiles/images/<?php if($pic!="" && file_exists("../profiles/images/".$pic)){echo $pic;}else{echo "placeholderImage.jpg";}?>'>
						<div id="prof">
							<ul>
								<li><b>First Name :</b><?php echo $row2["first_name"]?></li>
								<li><b>Last Name :</b><?php echo $row2["last_name"]?></li>
								<li><b>Date of Birth :</b><?php echo $row2["dob"]?></li>
								<li><b>Primary Email :</b><?php echo $row1["user_email"];?></li>
								<li><b>Secondary Email :</b><?php echo $row2["second_email"]?></li>
							</ul>
						</div>
						<div id="prof">
							<ul>
								<li><b>Department :</b><?php echo $row2["department"]?></li>
								<li><b>Qualification :</b><?php echo $row2["qualification"]?></li>
								<li><b>Phone :</b><?php echo $row2["phone"]?></li>
								<li><b>Mobile :</b><?php echo $row2["mobile"]?></li>
								<li><b>Address :</b><div><?php echo $row2["address"]?></div></li>
							</ul>
						</div>
					</div>
				</body>
			</html>
			<?php
			}
		}
		else{
			echo "error getting profile; contact admin or developer.";
		}
	}
}
else{
	echo "error getting profile; contact admin or developer";
}
?>