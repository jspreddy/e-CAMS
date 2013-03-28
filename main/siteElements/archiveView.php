<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1 || $_SESSION["user_type"]==2 || $_SESSION["user_type"]==3){
	if(isset($_GET["error"]) && $_GET["error"]=="hacker"){?>
		<div class="ErrorContainer display">
			<b>HACKER ALERT!!!!</b> : dude, stop hacking my application.
		</div>
	<?php
	}
	?>
	<div class="archivesContainer">
		<script language="javascript">
			$(document).ready(function(){
				$('.userInfo').click(function(){
					alert( $(this).attr('title') + ": \n" + $(this).text() );
				});
				<?php if($_SESSION["user_type"]==1){?>
					$('.deleteUser').click(function(e){
						e.preventDefault();
						if(confirm("Do you really want to delete this user info from archive?")){
							var cross=$(this);
							var crossparent=$(this).parent();
							cross.remove();
							crossparent.html("<img class='archiveDelete' src='./images/throbber.gif'>");
							$.get($(this).attr('href'),function(data){
								if(parseInt(data)==1){
									crossparent.after("<div class='archiveDeletedOverlay'><div class='archiveDeletedText'>DELETED</div></div>");
									crossparent.siblings('.archiveDeletedOverlay').fadeIn('fast');
									crossparent.find('.archiveDelete').remove();
								}
								else{
									$('.contentContainer').prepend(data);
									crossparent.find('.archiveDelete').remove();
								}
							});
						}
					});
				<?php
				}?>
			});
		</script>
		<?php
		$offset=0;
		if(ARCHIVE_PAGE_LENGTH>0){
			$page_length=ARCHIVE_PAGE_LENGTH;
		}
		else{$page_length=10;}
		if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
			$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
		}
		$query="select id, user_login, user_email,user_registered_date, user_delete_date, activation_key, user_status, display_name, user_type, first_name, last_name, dob, photo, department, post, qualification, second_email, phone, mobile, address from user_archive order by id ASC limit $offset, $page_length";
		$res=mysql_query($query) or die(mysql_error());
		
		if($res){
			$i=$offset;
			$user_type_array=array("","Administrator","Principal","HOD","Staff");
			while($row=mysql_fetch_array($res)){
				$i++;
		?>
				<div class="archive_user">
					<img class="archive_user_image" src="./profiles/images/<?php if($row["photo"]!="" && file_exists("./profiles/images/".$row["photo"])){echo $row["photo"];}else{echo "placeholderImage.jpg";}?>" alt="profile pic" title="User Photo">
					<ul>
						<li class="userInfo" title="Name"><?php echo $row["first_name"]." , ".$row["last_name"];?></li>
						<li class="userInfo" title="Department"><?php echo $row["department"];?></li>
						<li class="userInfo" title="Designation"><?php echo $row["post"];?></li>
						<li class="userInfo" title="User Type"><?php echo $user_type_array[$row["user_type"]];?></li>
						<li class="userInfo" title="Login Id"><?php echo $row["user_login"];?></li>
						<li class="userInfo" title="Date of Birth"><?php echo $row["dob"];?></li>
						<li class="userInfo" title="Join date"><?php echo $row["user_registered_date"];?></li>
						<li class="userInfo" title="Resign date"><?php echo $row["user_delete_date"];?></li>
					</ul>
					<ul>
						<li class="userInfo" title="Official Email"><?php echo $row["user_email"];?></li>
						<li class="userInfo" title="Personal Email"><?php echo $row["second_email"];?></li>
						<li class="userInfo" title="Qualification"><?php echo $row["qualification"];?></li>
						<li class="userInfo" title="Phone"><?php echo $row["phone"];?></li>
						<li class="userInfo" title="Mobile"><?php echo $row["mobile"];?></li>
						<li class="userInfo addressContainer" title="Address"><div class="address"><?php echo $row["address"];?></div></li>
					</ul>
					<?php
					if($_SESSION["user_type"]==1){
					?>
						<div class="archiveControlls">
							<a class="deleteUser archiveDelete" title="Delete from archive" href="./runners/ecams-run-archive-delete.php?uid=<?php echo $row["id"];?>&offset=<?php echo $offset;?>"></a>
						</div>
						
					<?php
					}?>
				</div>
	<?php	
			}
		}
	?>
	</div>
	<div class="pagination">
		<?php
			$count_query="select COUNT(*) as user_count from user_archive";
			$result=mysql_query($count_query) or die(mysql_error());
			if($result){
				$row=mysql_fetch_array($result);
				$user_count=$row["user_count"];
			}
			$page_count=1;
			$current_page=1+floor($offset / $page_length);
			$total_pages=ceil($user_count / $page_length);
			$displayoffset=0;

			if($current_page>1 && $current_page<=$total_pages){
			?>
				<a class="paginationLink" href="./archives.php?mode=view&offset=<?php echo ($offset-$page_length);?>">Prev</a>
			<?php
			}
			else{
			?>
				<a class="paginationLinkDead">Prev</a>
			<?php
			}
			while($user_count>0){
				?>
				<a class="paginationLink <?php if($current_page==$page_count){echo "active";}?>" href="./archives.php?mode=view&offset=<?php echo $displayoffset;?>"><?php echo $page_count;?></a>
			<?php
				$user_count-=$page_length;
				$page_count++;
				$displayoffset+=$page_length;
			}
			if($current_page<$total_pages){
			?>
				<a class="paginationLink" href="./archives.php?mode=view&offset=<?php echo ($offset+$page_length);?>">Next</a>
			<?php
			}
			else{
			?>
				<a class="paginationLinkDead">Next</a>
			<?php
			}
		?>
	</div>
<?php
}
else{
	echo "Access Denied";
}?>
