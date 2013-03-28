<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
	if(ecams_chk_profile_editable($_SESSION["id"]) || $_SESSION["user_type"]==1){
		if(isset($_GET["edit"]) && $_GET["edit"]=="success"){?>
			<div class="message">
				Profile Updated Successfully.
			</div>
		<?php
		}
		if(isset($_GET["pic"]) && $_GET["pic"]=="uploaded"){?>
			<div class="message">
				<b>Pic Upload</b> : Pic upload success.
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
		
		$fname="";$lname="";$dob="";$pic="";$dept="";$post="";$qual="";$email2="";$phone="";$mobile="";$address="";$logExist="no";
		$id=$_SESSION["id"];
		$query="select * from profiles where id='$id'";
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count==1){
			$logExist="yes";
			$row=mysql_fetch_array($result);
			$fname=$row['first_name'];
			$lname=$row['last_name'];
			$dob=$row['dob'];
			$pic=$row['photo'];
			$dept=$row['department'];
			$post=$row['post'];
			$qual=$row['qualification'];
			$email2=$row['second_email'];
			$phone=$row['phone'];
			$mobile=$row['mobile'];
			$address=$row['address'];
		}
		?>
		<link type="text/css" rel="stylesheet" href="./css/smoothness/jquery-ui-1.8.17.custom.css">
		<link type="text/css" rel="stylesheet" href="./css/jquery.countdown.css">
		<script language="javascript" src="./js/jquery-ui-1.8.17.custom.min.js"></script>
		<script language="javascript" src="./js/jquery.countdown.min.js"></script>
		<script language="javascript">
			function profileCheck(){
				var d=document.profileEditForm;
				var profileErrMsg="";
				if(d.fname.value==""){
					profileErrMsg+="<b>First Name</b>: Enter your name.<br>";
				}
				if(d.lname.value==""){
					profileErrMsg+="<b>Last Name</b>: Enter your family name(sur name).<br>";
				}
				if(d.dob.value==""){
					profileErrMsg+="<b>Date Of Birth</b>: select your date of birth.<br>";
				}
				if(d.pic.value!="" && d.pic.value.lastIndexOf(".jpg")==-1 && d.pic.value.lastIndexOf(".JPG")==-1){
					profileErrMsg+="<b>Display Pic Format</b>: Upload only \".jpg\" files.<br>";
				}
				
				if(d.dept.value==""){
					profileErrMsg+="<b>Department</b>: Select your department.<br>";
				}
				if(d.post.value==""){
					profileErrMsg+="<b>Designation</b>: Enter your designation.<br>";
				}
				if(d.qual.value==""){
					profileErrMsg+="<b>Qualification</b>: Enter your qualification.<br>";
				}
				if(d.email2.value!=""){
					if(!( (d.email2.value.indexOf("@")>0) && (d.email2.value.lastIndexOf(".") > d.email2.value.indexOf("@")+1) )){
						profileErrMsg+="<b>Secondary Email</b>: Enter a valid email id.<br>";
					}
				}
				if(d.mobile.value==""){
					profileErrMsg+="<b>Mobile</b>: Enter your Mobile number.<br>";
				}
				else if(isNaN(d.mobile.value) || (d.mobile.value.length!=10)){
					profileErrMsg+="<b>Mobile</b>: Enter a valid mobile number \(length = 10 digits\).<br>";
				}
				if(d.phone.value!=""){
					if(isNaN(d.phone.value) || (d.phone.value.length!=8)){
						profileErrMsg+="<b>Phone</b>: Enter a valid phone number \(length = 8 digits\).<br>";
					}
				}
				if(d.address.value==""){
					profileErrMsg+="<b>Address</b>: Enter your address.<br>";
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
			
			<?php if($_SESSION["user_type"]!=1){?>
				$(document).ready(function(){
					$('#countDown').countdown({
						until: new Date(<?php echo ecams_return_profile_countdown($_SESSION["id"]);?>),
						format: 'HMS',
						expiryUrl:'./home.php?profile=edit',
						serverSync: serverTime
					});
				});
				function serverTime(){
					var time = null; 
					$.ajax({url: './runners/ecams-return-time.php', 
						async: false,
						dataType: 'text', 
						success:function(text){
									time = new Date(text); 
								},
						error:	function(http, message, exc) { 
									time = new Date(); 
								}
					}); 
					return time;
				}
			<?php 
			}?>
		</script>
		<?php if($_SESSION["user_type"]!=1){?>
		<div class="message">
			<b>NOTE: </b>Please complete your profile within one day after your first update.<br> The profile will be locked one day after your first update.<br>
		</div>
		<div id="countDown">
			
		</div>
		<?php }?>
		<div id="profile_error" class="ErrorContainer"></div>
		<div id="profileEditContainer">
			<h3>Edit Profile</h3>
			<form name="profileEditForm" id="profileEditForm" enctype="multipart/form-data" onsubmit="return profileCheck()" action="./runners/ecams-run-profile-update.php" method="POST">
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
					<label for="pic">
						Display Pic: <b>*</b>
						<input id="pic" class="input2" name="pic" type="file" tabindex="4"/>
					</label>
				</p>
				<p>
					<label for="dept">
						Department: <b>*</b>
						<select id="dept" name="dept" class="input2" tabindex="5">
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
						<input id="post" class="input2" name="post" type="text" tabindex="6" value="<?php echo $post;?>"/>
					</label>
				</p>
				<p>
					<label for="qual">
						Qualification: <b>*</b>
						<input id="qual" class="input2" name="qual" type="text" tabindex="7" value="<?php echo $qual;?>"/>
					</label>
				</p>
				<p>
					<label for="email2">
						Personal email:
						<input id="email2" class="input2" name="email2" type="text" tabindex="8" value="<?php if($email2!=""){echo $email2;}?>"/>
					</label>
				</p>
				<p>
					<label for="phone">
						Phone No.:
						<input id="phone" class="input2" name="phone" type="text" tabindex="9" value="<?php if($phone!="" && $phone!=0){echo $phone;}?>"/>
					</label>
				</p>
				<p>
					<label for="mobile">
						Mobile No.: <b>*</b>
						<input id="mobile" class="input2" name="mobile" type="text" tabindex="10" value="<?php echo $mobile;?>"/>
					</label>
				</p>
				<p>
					<label for="address">
						Address: <b>*</b>
						<textarea id="address" class="input2" name="address" tabindex="11" ><?php echo $address;?></textarea>
					</label>
				</p>
				<input type="hidden" name="logExist" value="<?php echo$logExist;?>">
				<input tabindex="12" id="postButton" type="submit" value="Submit">
				<input tabindex="13" id="postButton" type="reset" onClick="reset_msgs()" value="Reset">
			</form>
		</div>
		<div id="displayPic">
			<img id="displayPicImg" src="./profiles/images/<?php if($pic!="" && file_exists("./profiles/images/".$pic)){echo $pic;}else{echo "placeholderImage.jpg";}?>">
		</div>
		<div id="displayPicNoteContainer">
			<b>Note:-</b>
			<ul>
				<li>The display pic's size should be <i>width=150px</i> and <i>height=200px</i>.</li>
				<li>If you don't follow the image size restrictions, the image will look oddly compressed</li>
				<li><a target="_BLANK" href="http://www.online-image-editor.com/">www.online-image-editor.com</a> You can use this service to resize your pics.</li>
			</ul>
		</div>
<?php
	}
	else{
	?>
		<div class="ErrorContainer display">
			<b>Edit Timeout : </b> You have previously edited this profile and thus it has been locked one day after you started the update.<br>
			If you want to edit it, ask Administrator to unlock the profile.
		</div>
	<?php
	}
}?>