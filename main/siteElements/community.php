<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
	?>
	<script language="javascript">
		$(document).ready(function(){
			$('#communityExpander').click(function(){
				$('#community').slideToggle('slow');
			});
			$('.communityList').click(function(){
				if($(this).attr('data-profile')!==undefined)
					window.location=$(this).attr('data-profile');
				else
					alert("Action Not Available for resignations");
			});
		});
	</script>
	<div class="communityContainer">
		<h3 id="communityExpander">Community Center<span class=""></span></h3>
		<div id="community">
			<div class="incoming tripleDiv">
				<h5>New Joinings</h5>
			<?php
				$format="Y-m-d H:i:s";
				$baseDate=date ( $format, strtotime ( '-7 day' . date($format) ) );
				$query="SELECT * from users where user_registered_date >= '$baseDate' order by id desc";
				$res=mysql_query($query) or die(mysql_error());
				$count1=mysql_num_rows($res);
				if($count1>0){
					while($row1=mysql_fetch_array($res)){
						$id=$row1["id"];
						$profile_query="select first_name, last_name, photo, department, post from profiles where id=$id";
						$profile_res=mysql_query($profile_query) or die(mysql_error());
						$profile_count=mysql_num_rows($profile_res);
						if($profile_count==1){
							$row2=mysql_fetch_array($profile_res);
							$fname=$row2["first_name"];
							$lname=$row2["last_name"];
							$pic=$row2["photo"];
							$dept=$row2["department"];
							$post=$row2["post"];
						}else{
							$fname="";
							$lname="";
							$pic="";
							$dept="";
							$post="";
						}
						$dname=$row1["display_name"];
						
					?>
						<div data-profile="./contacts.php?mode=view&uid=<?php echo $id;?>" class="communityList">
							<img src="./profiles/images/<?php if($pic!="" && file_exists("./profiles/images/".$pic)){echo $pic;}else{echo "placeholderImage.jpg";}?>">
							<div title="Name" class="userName"><?php if($fname==""){echo $dname;}else{ echo $fname.", ".$lname;}?></div>
							<div title="Department" class="dept"><?php echo $dept;?></div>
							<div title="Designation" class="desig"><?php echo $post;?></div>
						</div>
					<?php
					}
				}
				else{
					echo "No new users";
				}
			?>
			</div>
			<div class="outgoing tripleDiv">
				<h5>Resignations</h5>
			<?php
				$query="SELECT * from user_archive where user_delete_date >= '$baseDate' order by id desc";
				$res=mysql_query($query) or die(mysql_error());
				$count2=mysql_num_rows($res);
				if($count2>0){
					while($row3=mysql_fetch_array($res)){
						$fname=$row3["first_name"];
						$lname=$row3["last_name"];
						$dname=$row3["display_name"];
						$dept=$row3["department"];
						$post=$row3["post"];
						$pic=$row3["photo"];
					?>
						<div class="communityList">
							<img src="./profiles/images/<?php if($pic!="" && file_exists("./profiles/images/".$pic)){echo $pic;}else{echo "placeholderImage.jpg";}?>">
							<div title="Name" class="userName"><?php if($fname==""){echo $dname;}else{ echo $fname.", ".$lname;}?></div>
							<div title="Department" class="dept"><?php echo $dept;?></div>
							<div title="Designation" class="desig"><?php echo $post;?></div>
						</div>
					<?php
					}
				}
				else{
					echo "No users are leaving the organisation";
				}
			?>
			</div>
			<div class="bdays tripleDiv">
				<h5>Today's Birthday's</h5>
			<?php
				$today=date('-m-d');
				$query="SELECT * from profiles where dob like '____$today%' order by id desc";
				$res=mysql_query($query) or die(mysql_error());
				$count3=mysql_num_rows($res);
				if($count3>0){
					while($row4=mysql_fetch_array($res)){
						$id=$row4["id"];
						$fname=$row4["first_name"];
						$lname=$row4["last_name"];
						$dept=$row4["department"];
						$post=$row4["post"];
						$pic=$row4["photo"];
					?>
						<div data-profile="./contacts.php?mode=view&uid=<?php echo $id;?>" class="communityList">
							<img src="./profiles/images/<?php if($pic!="" && file_exists("./profiles/images/".$pic)){echo $pic;}else{echo "placeholderImage.jpg";}?>">
							<div title="Name" class="userName"><?php echo $fname.", ".$lname;?></div>
							<div title="Department" class="dept"><?php echo $dept;?></div>
							<div title="Designation" class="desig"><?php echo $post;?></div>
						</div>
					<?php
					}
				}
				else{
					echo "No birthdays today";
				}
			?>
			</div>
		</div>
	</div>
	<?php
}?>