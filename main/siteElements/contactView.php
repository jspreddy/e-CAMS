<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else if(isset($_GET["uid"]) && filter_input(INPUT_GET,"uid",FILTER_VALIDATE_INT) && $_GET["uid"]>=0){
	if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
		$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
	}else{$offset=0;}
	?>
		<div class="backLinkContainer">
			<script language="javascript">
				$(document).ready(function(){
					$('#backLink').click(function(){
						window.history.back();
					});
				});
			</script>
			<a class="backLink" id="backLink" >Back</a>
		</div>
	<?php
	$uid=$_GET["uid"];
	$query_users="select user_login, user_email, display_name, user_type from users where id='$uid'";
	$query_profile="select first_name, last_name, dob, photo, department, post, qualification, second_email, phone, mobile, address from profiles where id='$uid'";
	$result1=mysql_query($query_users) or die(mysql_error());
	$result2=mysql_query($query_profile) or die(mysql_error());
	$count1=mysql_num_rows($result1);
	$count2=mysql_num_rows($result2);
	$pic="placeholderImage.jpg";
	if($count1==1){
		$row1=mysql_fetch_array($result1);
		$row2=mysql_fetch_array($result2);
		$pic=$row2["photo"];
	?>
		<?php if($_SESSION["user_type"]==1){ ?>
		<h3>User Name : <?php echo $row1["user_login"]?></h3>
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
		<?php }
		if($_SESSION["user_type"]==2 || $_SESSION["user_type"]==3){
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
		}if($_SESSION["user_type"]==4){
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
				</ul>
			</div>
		</div>
		<?php
		}?>
		
		<?php if($_SESSION["user_type"]==1){
			if(isset($_GET["edit"]) && $_GET["edit"]=="success"){?>
			<div class="message">
				Profile Updated Successfully.
			</div>
			<?php
			}
			if(isset($_GET["error"]) && $_GET["error"]=="fatality"){?>
				<div class="ErrorContainer display">
					<b>FATAL error</b> : Nothing to update.
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
			}
			if(isset($_GET["error"]) && $_GET["error"]=="EExist"){?>
				<div class="ErrorContainer display">
					<b>Email Exists :</b> Please choose a different Email-ID as the specified Email-ID is already in use.
				</div>
			<?php
			}
		
			$fname="";$lname="";$dob="";$dept="";$post="";$qual="";$email2="";$phone="";$mobile="";$address="";$logExist="no";
			if($count2==1){
				$logExist="yes";
			}
			$fname=$row2['first_name'];
			$lname=$row2['last_name'];
			$dob=$row2['dob'];
			$dept=$row2['department'];
			$post=$row2['post'];
			$qual=$row2['qualification'];
			$email2=$row2['second_email'];
			$phone=$row2['phone'];
			$mobile=$row2['mobile'];
			$address=$row2['address'];
			?>
			<link type="text/css" rel="stylesheet" href="./css/smoothness/jquery-ui-1.8.17.custom.css">
			<script language="javascript" src="./js/jquery-ui-1.8.17.custom.min.js"></script>
			<script language="javascript">
				function profileCheck(){
					var d=document.adminProfileEditForm;
					var profileErrMsg="";
					if(d.email2.value!=""){
						if(!( (d.email2.value.indexOf("@")>0) && (d.email2.value.lastIndexOf(".") > d.email2.value.indexOf("@")+1) )){
							profileErrMsg+="<b>Secondary Email</b>: Enter a valid secondary email id.<br>";
						}
					}
					if(d.mobile.value!=""){
						if(isNaN(d.mobile.value) || (d.mobile.value.length!=10)){
							profileErrMsg+="<b>Mobile</b>: Enter a valid mobile number \(length = 10 digits\).<br>";
						}
					}
					if(d.phone.value!=""){
						if(isNaN(d.phone.value) || (d.phone.value.length!=8)){
							profileErrMsg+="<b>Phone</b>: Enter a valid phone number \(length = 8 digits\).<br>";
						}
					}
					
					if(profileErrMsg!=""){
						$('#profile_error').empty().append(profileErrMsg);
						$('#profile_error').css("display","block");
						window.scrollTo(0,0);
						return false;
					}
					else{
						return true;
					}
				}
				function reset_msgs(){
					$('#profile_error').empty();
					$('#profile_error').css("display","none");
					window.scrollTo(0,0);
				}
				$(function() {
					$('#dob').attr("readOnly",true);
					$( '#dob' ).datepicker({ changeYear: true, changeMonth: true, yearRange: '1900:2012', dateFormat: 'yy-mm-dd' });
				});
			</script>
		
			<div id="profile_error" class="ErrorContainer"></div>
			<div id="profileEditContainer">
				<h3>Edit Profile</h3>
				<form name="adminProfileEditForm" id="adminProfileEditForm" enctype="multipart/form-data" onsubmit="return profileCheck()" action="./runners/ecams-run-profile-update-by-admin.php" method="POST">
					<p>
						<label for="fname">
							First Name: <b>*</b>
							<input id="fname" class="input2" name="fname" type="text" tabindex="1" value="<?php echo $fname;?>"/>
						</label>
					</p>
					<p>
						<label for="lname">
							Last Name: <b>*</b>
							<input id="lname" class="input2" name="lname" type="text" tabindex="2"value="<?php echo $lname;?>"/>
						</label>
					</p>
					<p>
						<label for="dob">
							Date of Birth: <b>*</b>
							<input id="dob" class="input2" name="dob" type="text" tabindex="3" value="<?php echo $dob;?>"/>
						</label>
					</p>
					<p>
						<label for="dept">
							Department: <b>*</b>
							<select id="dept" name="dept" class="input2" tabindex="4">
								<option></option>
								<option <?php if($dept=="Administration"){echo "selected=\"true\"";}?> value="Administration">Administration</option>
								<option <?php if($dept=="Transport"){echo "selected=\"true\"";}?> value="Transport">Transport</option>
								<option <?php if($dept=="CSE"){echo "selected=\"true\"";}?> value="CSE">CSE</option>
								<option <?php if($dept=="ECE"){echo "selected=\"true\"";}?> value="ECE">ECE</option>
								<option <?php if($dept=="EEE"){echo "selected=\"true\"";}?> value="EEE">EEE</option>
								<option <?php if($dept=="IT"){echo "selected=\"true\"";}?> value="IT">IT</option>
								<option <?php if($dept=="CIVIL"){echo "selected=\"true\"";}?> value="CIVIL">CIVIL</option>
								<option <?php if($dept=="MECH"){echo "selected=\"true\"";}?> value="MECH">MECH</option>
								<option <?php if($dept=="PG"){echo "selected=\"true\"";}?> value="PG">PG</option>
								<option <?php if($dept=="Other"){echo "selected=\"true\"";}?> value="Other">Other</option>
							</select>
						</label>
					</p>
					<p>
						<label for="post">
							Designation: <b>*</b>
							<input id="post" class="input2" name="post" type="text" tabindex="5" value="<?php echo $post;?>"/>
						</label>
					</p>
					<p>
						<label for="qual">
							Qualification: <b>*</b>
							<input id="qual" class="input2" name="qual" type="text" tabindex="6" value="<?php echo $qual;?>"/>
						</label>
					</p>
					<p>
						<label for="email2">
							Personal email:
							<input id="email2" class="input2" name="email2" type="text" tabindex="7" value="<?php echo $email2;?>"/>
						</label>
					</p>
					<p>
						<label for="phone">
							Phone No.:
							<input id="phone" class="input2" name="phone" type="text" tabindex="8" value="<?php echo $phone;?>"/>
						</label>
					</p>
					<p>
						<label for="mobile">
							Mobile No.: <b>*</b>
							<input id="mobile" class="input2" name="mobile" type="text" tabindex="9" value="<?php echo $mobile;?>"/>
						</label>
					</p>
					<p>
						<label for="address">
							Address: <b>*</b>
							<textarea id="address" class="input2" name="address" tabindex="10" ><?php echo $address;?></textarea>
						</label>
					</p>
					<input type="hidden" name="logExist" value="<?php echo$logExist;?>">
					<input type="hidden" name="uid" value="<?php echo $uid;?>">
					<input type="hidden" name="offset" value="<?php echo $offset;?>">
					<input tabindex="11" id="postButton" type="submit" value="Submit">
					<input tabindex="12" id="postButton" type="reset" onClick="reset_msgs()" value="Reset">
				</form>
			</div>
			<div class="rightHalfContainer">
				<h3>Core Details</h3>
				<script language="javascript">
					function coreDetailCheck(){
						var d=document.Admin_UserCoreEditFrom;
						var errMsg="";
						
						if(d.email1.value==""){
							errMsg+="<b>Primary Email:</b> Please enter an email address.<br>";
						}
						if(d.email1.value!=""){
							if(!( (d.email1.value.indexOf("@")>0) && (d.email1.value.lastIndexOf(".") > d.email1.value.indexOf("@")+1) )){
								errMsg+="<b>Primary Email</b>: Enter a valid email id.<br>";
							}
						}
						if(d.dname.value==""){
							errMsg+="<b>Display Name:</b> Please enter a display name.<br>";
						}
						if(d.type.value==""){
							errMsg+="<b>User Type:</b> Please select a user type.<br>";
						}
						if(errMsg!=""){
							$('#profile_error').empty().append(errMsg);
							$('#profile_error').css("display","block");
							return false;
						}
						else{
							return true;
						}
					}
				</script>
				<form name="Admin_UserCoreEditFrom" id="Admin_UserCoreEditFrom" enctype="multipart/form-data" onsubmit="return coreDetailCheck()" action="./runners/ecams-run-core-details-update-by-admin.php" method="POST">
					<p>
						<label for="dname">
							Display Name: <b>*</b>
							<input id="dname" class="input2" name="dname" type="text" tabindex="13" value="<?php echo$row1["display_name"]?>" >
						</label>
					</p>
					<p>
						<label for="email1">
							Official Email: <b>*</b>
							<input id="email1" class="input2" name="email1" type="text" tabindex="14" value="<?php echo$row1["user_email"]?>" >
						</label>
					</p>
					<p>
						<label for="type">
							User Type <b>*</b>
							<select name="type" id="type" class="input2" tabindex="15">
								<option value=""></option>
								<option <?php if($row1["user_type"]==1){echo "selected=\"true\"";}?> value="Administrator">Administrator</option>
								<option <?php if($row1["user_type"]==2){echo "selected=\"true\"";}?> value="Principal">Principal</option>
								<option <?php if($row1["user_type"]==3){echo "selected=\"true\"";}?> value="HOD">HOD</option>
								<option <?php if($row1["user_type"]==4){echo "selected=\"true\"";}?> value="Staff">Staff</option>
							</select>
						</label>
					</p>
					<input type="hidden" name="uid" value="<?php echo $uid;?>">
					<input type="hidden" name="offset" value="<?php echo $offset;?>">
					<input tabindex="16" id="postButton" type="submit" value="Submit">
					<input tabindex="17" id="postButton" type="reset" onClick="reset_msgs()" value="Reset">
				</form>
			</div>
			<div class="rightHalfContainer">
				<div id="keygen">Generate code for external site</div>
				<textarea id="codearea" ></textarea>
				<div id="retreiving">Loading....</div>
				<script language="javascript">
					$(document).ready(function(){
						$("#codearea").hide();
						$("#retreiving").hide();
						$("#keygen").click(function(){
							$("#codearea").hide();
							$("#retreiving").slideDown();
							$.get("./runners/ecams-generate-ext-site-profile-import-code.php?uid=<?php echo$uid;?>",function(data){			
								$("#retreiving").slideUp(function(){
									$("#codearea").text(data).slideDown('slow');
								});	
							});
						});
						
					});
				</script>
			</div>
		<?php
		}
	}
	else{
		?>
		<div class="ErrorContainer display">
			<b>No Such User : </b>requested user does not exist. Please select user from the user list only.
		</div>
		<?php
	}
}else{
	if(isset($_GET["mode"]) && $_GET["mode"]=="view" && $_SESSION["user_type"]==1)
		header("Location: ./User.php?mode=view");
	?>
	<div class="leftHalfContainer">
		<div id="userViewerContainer" class="userViewerContainer condensed">
			<table>
				<tr>
					<th>Sno</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Department</th>
					<th>User Type</th>
				</tr>
				<?php
					$offset=0;
					if(USER_CONTACTS_PAGE_LENGTH>0){
						$page_length=USER_CONTACTS_PAGE_LENGTH;
					}
					else{$page_length=10;}
					if(isset($_GET["offset"]) && filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT) && $_GET["offset"]>=0){
						$offset=filter_input(INPUT_GET,"offset",FILTER_VALIDATE_INT);
					}
					$get_from_users_query="select id, display_name, user_type from users order by id ASC limit $offset , $page_length";
					$get_from_users_result=mysql_query($get_from_users_query) or die(mysql_error());
					if($get_from_users_result){
						$i=$offset;
						$user_type_array=array("","Admin","Principal","HOD","Staff");
						while($row1=mysql_fetch_array($get_from_users_result)){
							$i++;
							$id=$row1["id"];
							$get_from_profiles_query="select first_name, last_name, department from profiles where id=$id limit 1";
							$get_from_profiles_result=mysql_query($get_from_profiles_query) or die(mysql_error());
							if($get_from_profiles_result){
								$row2=mysql_fetch_array($get_from_profiles_result);
								$fname=$row2["first_name"];
								$lname=$row2["last_name"];
								$dept=$row2["department"];
							}
							if($fname==""){$fname="N/A";}
							if($lname==""){$lname="N/A";}
							if($dept==""){$dept="N/A";}
				?>
				<tr class="userViewRow pointer" title="View Profile Card" url="./contacts.php?mode=view&uid=<?php echo $row1["id"]?>&offset=<?php echo $offset;?>">
					<td><?php echo $i;?></td>
					<td><?php echo $fname;?></td>
					<td><?php echo $lname;?></td>
					<td><?php echo $dept;?></td>
					<td><?php echo $user_type_array[$row1["user_type"]];?></td>
				</tr>
				<?php
						}
					}
				?>
			</table>
			<script language="javascript">
				$(document).ready(function(){
				   $("tr").click(function(){
					  window.location = $(this).attr("url");
				   });
				});
			</script>
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
					<a class="paginationLink" href="./contacts.php?mode=view&offset=<?php echo ($offset-$page_length);?>">Prev</a>
				<?php
				}
				else{
				?>
					<a class="paginationLinkDead">Prev</a>
				<?php
				}
				while($user_count>0){
					?>
					<a class="paginationLink <?php if($current_page==$page_count){echo "active";}?>" href="./contacts.php?mode=view&offset=<?php echo $displayoffset;?>"><?php echo $page_count;?></a>
				<?php
					$user_count-=$page_length;
					$page_count++;
					$displayoffset+=$page_length;
				}
				if($current_page<$total_pages){
				?>
					<a class="paginationLink" href="./contacts.php?mode=view&offset=<?php echo ($offset+$page_length);?>">Next</a>
				<?php
				}
				else{
				?>
					<a class="paginationLinkDead">Next</a>
				<?php
				}
			?>
		</div>
	</div>
	<div class="rightHalfContainer">
		<h3>Search Contact</h3>
		<form name="contactSearch" method="POST" action="">
			<p>
				<label for="uname_search" title="user name of the contact you want to search">
					User Name
					<input id="uname_search" class="input2" type="text" name="userSearchName">
				</label>
			</p>
			<input id="postButton" title="Display User profile card" type="submit" value="Go">
		</form>
	</div>
	
<?php
}?>