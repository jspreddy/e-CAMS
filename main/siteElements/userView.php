<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){
	if(isset($_GET["msg"]) && $_GET["msg"]=="block_success"){?>
		<div class="message">
			User status altered successfully.
		</div>
	<?php
	}
	if(isset($_GET["msg"]) && $_GET["msg"]=="delete_success"){?>
		<div class="message">
			User deleted successfully.
		</div>
	<?php
	}
	if(isset($_GET["error"]) && $_GET["error"]=="blockown"){?>
		<div class="ErrorContainer display">
			<b>Admin : </b> You are trying to block your own account.<br>If you want your account blocked, then ask another person with Admin privilages to block your account.
		</div>
	<?php
	}
	if(isset($_GET["error"]) && $_GET["error"]=="admin"){?>
		<div class="ErrorContainer display">
			<b>Admin : </b> Can't change an Administrator Account.
		</div>
	<?php
	}
	if(isset($_GET["error"]) && $_GET["error"]=="NoExist"){?>
		<div class="ErrorContainer display">
			<b>Non Existent User :</b> The user that you are trying to change does not exist, please check again.
		</div>
	<?php
	}
	if(isset($_GET["error"]) && $_GET["error"]=="InternalError"){?>
		<div class="ErrorContainer display">
			Internal error. Try Again. If problem persists, contact the administrator / developer.
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
		$(document).ready(function(){	
			$(".deleteUser").click(function(event){
				var go=confirm("Do you really want to delete the user?");
				event.preventDefault();
				var url=$(this).attr('href');
				if(go==true){
					window.location=url;
				}
			});
			$("#DLPDF").click(function(e){
				e.preventDefault();
				if($('#dlrange1').prop('checked')){
					window.open('./runners/ecams-run-download-contacts.php?dlrange=full&dltype=pdf','_BLANK');
				}
				else{
					window.open('./runners/ecams-run-download-contacts.php?dlrange=filled&dltype=pdf','_BLANK');
				}
			});
			$("#DLCSV").click(function(e){
				e.preventDefault();
				if($('#dlrange1').prop('checked')){
					//alert("CSV file download : Download full");
					window.open('./runners/ecams-run-download-contacts.php?dlrange=full&dltype=csv','_BLANK');
				}
				else{
					//alert("CSV file download : Download Completed contacts");
					window.open('./runners/ecams-run-download-contacts.php?dlrange=filled&dltype=csv','_BLANK');
				}
			});
		});
	</script>
	<div id="DLContactsContainer">
		<div id="DLtitle" title="By default ONLY the completed contacts are downloaded." class="DLtext">Download Contacts</div>
		<div id="DLoptions">
			<label id="DLCheck" for="dlrange1" title="Download even the Incomplete Contacts"><input id="dlrange1" type="checkbox" name="dlrange" value="full">FULL</label>
			<a class="DLLink" id="DLPDF" title="Download in form of a PDF file" href="#">PDF</a>
			<a class="DLLink" id="DLCSV" title="Download in form of a CSV file" href="#">CSV</a>
		</div>
	</div>
	
	<div id="addViewerError" class="ErrorContainer"></div>
	<div id="userViewerContainer" class="userViewerContainer">
		<table>
			<tr>
				<th>Sno</th>
				<th>UserName</th>
				<th>Email</th>
				<th>Registered Date</th>
				<th>Status</th>
				<th>Display Name</th>
				<th>User Type</th>
				<th>edit</th>
				<th>delete</th>
				<th>Profile</th>
			</tr>
			<?php
				$offset=0;
				if(ADMIN_USER_VIEW_PAGE_LENGTH>0){
					$page_length=ADMIN_USER_VIEW_PAGE_LENGTH;
				}
				else{$page_length=10;}
				if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
					$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
				}
				$get_users_query="select id, user_login, user_email, user_registered_date, user_status, display_name, user_type from users order by id ASC limit $offset , $page_length";
				$get_users_result=mysql_query($get_users_query) or die(mysql_error());
				if($get_users_result){
					$i=$offset;
					$user_type_array=array("","Administrator","Principal","HOD","Staff");
					while($row=mysql_fetch_array($get_users_result)){
						$i++;
			?>
			<tr class="userViewRow">
				<td><?php echo $i;?></td>
				<td><a class="contactLink" title="View Contact Card" href="./contacts.php?mode=view&uid=<?php echo $row["id"]?>&offset=<?php echo $offset;?>"><?php echo $row["user_login"];?></a></td>
				<td><?php echo $row["user_email"];?></td>
				<td><?php echo $row["user_registered_date"];?></td>
				<td>
					<?php if($row["user_status"]==1){?>
						<a class="userActive" title="Click to block the user from accessing his account" href="./runners/ecams-run-user-block.php?uid=<?php echo $row["id"];?>&offset=<?php echo$offset;?>">Active</a>
					<?php
					}else{?>
						<a class="userBlocked" title="Click to allow the user" href="./runners/ecams-run-user-block.php?uid=<?php echo $row["id"];?>&offset=<?php echo$offset;?>">Blocked</a>
					<?php
					}?>
				</td>
				<td><?php echo $row["display_name"];?></td>
				<td><?php echo $user_type_array[$row["user_type"]];?></td>
				<td><a class="editUser linkIcon" title="Edit User" href="./contacts.php?mode=view&uid=<?php echo $row["id"]?>&offset=<?php echo $offset;?>"></a></td>
				<td><a class="deleteUser linkIcon" title="Delete User" href="./runners/ecams-run-user-delete.php?uid=<?php echo $row["id"];?>&offset=<?php echo$offset;?>"></a></td>
				<td>
					<?php 
						if(ecams_chk_profile_editable($row["id"])===true){?>
							<a class="profileOpen" title="Profile not started">open</a>
						<?php
						}else if(ecams_chk_profile_editable($row["id"])==true){?>
							<a title="Profile under CountDown" class="profileStarted" >Started</a>
						<?php	
						}else{?>
							<a class="profileClosed" title="click to open the profile edit" href="./runners/ecams-run-profile-opener.php?uid=<?php echo $row["id"];?>&offset=<?php echo$offset;?>&mode=open">Done</a>
						<?php	
						}
					?>
				</td>
			</tr>
			<?php
					}
				}
			?>
		</table>
	</div>
	<div class="pagination">
		<?php
			$count_query="select COUNT(*) as user_count from users";
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
				<a class="paginationLink" href="./User.php?mode=view&offset=<?php echo ($offset-$page_length);?>">Prev</a>
			<?php
			}
			else{
			?>
				<a class="paginationLinkDead">Prev</a>
			<?php
			}
			while($user_count>0){
				?>
				<a class="paginationLink <?php if($current_page==$page_count){echo "active";}?>" href="./User.php?mode=view&offset=<?php echo $displayoffset;?>"><?php echo $page_count;?></a>
			<?php
				$user_count-=$page_length;
				$page_count++;
				$displayoffset+=$page_length;
			}
			if($current_page<$total_pages){
			?>
				<a class="paginationLink" href="./User.php?mode=view&offset=<?php echo ($offset+$page_length);?>">Next</a>
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
}else{
?>
	Access Denied.
<?php
}?>