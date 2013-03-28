<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
	$id=$_SESSION["id"];
	$query_users="select user_login, user_email from users where id='$id'";
	$query_profile="select first_name, last_name, dob, department, post, qualification, second_email, phone, mobile, address from profiles where id='$id'";
	$result1=mysql_query($query_users) or die(mysql_error());
	$result2=mysql_query($query_profile) or die(mysql_error());
	$count1=mysql_num_rows($result1);
	$count2=mysql_num_rows($result2);
	$pic=$_SESSION["id"].".jpg";
	if($count1==1){
		$row1=mysql_fetch_array($result1);
		$row2=mysql_fetch_array($result2);
	?>
		<div class="profileCardContainer">
			<img id="dp" src="./profiles/images/<?php if($pic!="" && file_exists("./profiles/images/".$pic)){echo $pic;}else{echo "placeholderImage.jpg";}?>">
			<div id="prof">
				<ul>
					<li><b>First Name :</b><?php echo $row2["first_name"]?></li>
					<li><b>Last Name :</b><?php echo $row2["last_name"]?></li>
					<li><b>Date of Birth :</b><?php echo $row2["dob"]?></li>
					<li><b>Official Email :</b><?php echo $row1["user_email"];?></li>
					<li><b>Personal Email :</b><?php echo $row2["second_email"]?></li>
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
	<?php
	}
}?>