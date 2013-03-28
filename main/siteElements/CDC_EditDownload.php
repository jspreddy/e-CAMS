<?php 
ob_start();
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_type"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"])){
	session_destroy();
	header("Location: ../index.php");
}
else{
	if(isset($_GET["rid"]) && filter_input(INPUT_GET, "rid", FILTER_VALIDATE_INT)){
		$rid=filter_input(INPUT_GET, "rid", FILTER_VALIDATE_INT);
		if(getUType()==1){
			$extension=" ";
		}
		else{
			$uid=  getUid();
			$extension=" and uid='$uid' ";
		}
		$query="SELECT rid,bid,yid,cid,filename,displayname,date from cdc_downloads where rid='$rid' ".$extension;
		$result=mysql_query($query) or die(mysql_error());
		$count=mysql_num_rows($result);
		if($count==1){
			$row = mysql_fetch_array($result);
	?>
			<script language="javascript">
				function formCheck(){
					var d=document.d_form;
					var errMsg="";
					var errColor="#ff1010"

					if(d.d_name.value==""){
						errMsg+="<br>NAME: please enter a name for the file<br>";
						$('#d_name').css("background",errColor);
					}
					else if(d.d_name.value.length>50){
						errMsg+="<br>NAME: name too big, should be with in 50 characters<br>";
						$('#d_name').css("background",errColor);
					}
					else{$('#d_name').css("background","");}

					if(!(d.d_b_cse.checked || d.d_b_ece.checked || d.d_b_eee.checked || d.d_b_it.checked || d.d_b_civ.checked || d.d_b_mech.checked || d.d_b_mtech.checked || d.d_b_mba.checked || d.d_b_mca.checked)){
						errMsg+="<br>BRANCHES: Select one or more branches<br>";
						$('#d_branches,#d_branches2').css("background",errColor);
					}
					else if((d.d_b_cse.checked || d.d_b_ece.checked || d.d_b_eee.checked || d.d_b_it.checked || d.d_b_civ.checked  || d.d_b_mech.checked) && (d.d_b_mtech.checked || d.d_b_mba.checked || d.d_b_mca.checked)){
						errMsg+="<br>BRANCHES: Select either BTech groups or PG groups, but not both<br>";
						$('#d_branches,#d_branches2').css("background",errColor);
					}
					else{$('#d_branches,#d_branches2').css("background","");}

					if(d.d_category.value==""){
						errMsg+="<br>CATEGORY: Please select any one category<br>";
						$('#d_category').css("background",errColor);
					}
					else{$('#d_category').css("background","");}

					if(!(d.d_y_1.checked || d.d_y_2.checked || d.d_y_3.checked || d.d_y_4.checked)){
						errMsg+="<br>YEAR: Select atleast one year<br>";
						$('#d_year').css("background",errColor);
					}
					else if(d.d_b_mtech.checked || d.d_b_mba.checked || d.d_b_mca.checked){
						if(d.d_y_3.checked || d.d_y_4.checked){
							errMsg+="<br>YEAR: PG groups do not have 3,4 years<br>";
							$('#d_year').css("background",errColor);
						}
					}
					else{$('#d_year').css("background","");}

					if(errMsg!=""){
						$('#d_msg').empty().append(errMsg);
						return false;
					}
					else{
						return true;
					}
				}
			</script>
			<div id="d_pannel">
				<div id="d_title"></div>
				<form name="d_form" method="post" enctype="multipart/form-data" action="./runners/ecams-run-cdc-edit-download.php" onSubmit="return formCheck()" >
					<input type="hidden" name="d_rid" value="<?php echo $rid;?>">
					<table id="d_table">
						<tr>
							<td id="d_file"></td>
							<td>Selected File : </td>
							<td><a id="d_view_file" target="_BLANK" href="../../CDC/CDC_UploadDocs/<?php echo $row["filename"]; ?>">View File</a></td>												
						</tr>
						<tr>
							<td id="d_name"></td>
							<td>Download Name:</td>
							<td><input name="d_name" type="text" size="50" value="<?php echo $row["displayname"]; ?>"></td>									
						</tr>
						<tr>
							<td id="d_branches"></td>
							<td>Branches : </td>
							<td>
								CSE: <input name="d_b_cse" type="checkbox" <?php if(strstr($row["bid"],'1')){echo "checked";} ?>> &nbsp
								ECE: <input name="d_b_ece" type="checkbox" <?php if(strstr($row["bid"],'2')){echo "checked";} ?>> &nbsp
								EEE: <input name="d_b_eee" type="checkbox" <?php if(strstr($row["bid"],'3')){echo "checked";} ?>> &nbsp
								IT: <input name="d_b_it" type="checkbox" <?php if(strstr($row["bid"],'4')){echo "checked";} ?>> &nbsp
								CIVIL: <input name="d_b_civ" type="checkbox" <?php if(strstr($row["bid"],'5')){echo "checked";} ?>> &nbsp
								MECH: <input name="d_b_mech" type="checkbox" <?php if(strstr($row["bid"],'6')){echo "checked";} ?>> &nbsp
							</td>
						</tr>
						<tr>
							<td id="d_branches2"></td>
							<td></td>
							<td>
								MTech: <input name="d_b_mtech" type="checkbox" <?php if(strstr($row["bid"],'7')){echo "checked";} ?>> &nbsp
								MBA: <input name="d_b_mba" type="checkbox" <?php if(strstr($row["bid"],'8')){echo "checked";} ?>> &nbsp
								MCA: <input name="d_b_mca" type="checkbox" <?php if(strstr($row["bid"],'9')){echo "checked";} ?>> &nbsp
							</td>
						</tr>
						<tr>
							<td id="d_category"></td>
							<td>Category : </td>
							<td>
								<select name="d_category">
									<option></option>
									<option <?php if($row["cid"]=="Mid Exams"){echo "selected=\"true\"";}?>>Mid Exams</option>
									<option <?php if($row["cid"]=="University Exams"){echo "selected=\"true\"";}?>>University Exams</option>
									<option <?php if($row["cid"]=="Assignments"){echo "selected=\"true\"";}?>>Assignments</option>
									<option <?php if($row["cid"]=="Project Docs"){echo "selected=\"true\"";}?>>Project Docs</option>
									<option <?php if($row["cid"]=="Others"){echo "selected=\"true\"";}?>>Others</option>
								</select>
							</td>												
						</tr>
						<tr>
							<td id="d_year"></td>
							<td>Year : </td>
							<td>
								I:  <input name="d_y_1" type="checkbox" <?php if(strstr($row["yid"],'1')){echo "checked";} ?>> &nbsp
								II: <input name="d_y_2" type="checkbox" <?php if(strstr($row["yid"],'2')){echo "checked";} ?>> &nbsp
								III: <input name="d_y_3" type="checkbox" <?php if(strstr($row["yid"],'3')){echo "checked";} ?>> &nbsp
								IV: <input name="d_y_4" type="checkbox" <?php if(strstr($row["yid"],'4')){echo "checked";} ?>> &nbsp
							</td>												
						</tr>
						<tr>
							<td></td>
							<td>Date: </td>
							<td>
								Keep old Date:<input name="d_date" value="old" type="radio" checked> &nbsp
								Change Date to new:<input name="d_date" value="new" type="radio"> &nbsp
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>
								<input type="submit" value="Submit">
								<a href="./CDC.php?mode=manage" id="d_go_back">Go Back</a>
							</td>
						</tr>					
					</table>
				</form>
				<div id="d_msg">
					<?php 
					if(isset($_GET["msg"])) 
					{
						if($_GET["msg"]=="Succ")
							echo "<b>Download Edited successfully</b>";
						elseif($_GET["msg"]=="Error")
							echo "<b>Internal error</b>:<i> Try again. If problem persists, contact the developer.</i>";
					}	
					?>
				</div>
			</div>
	<?php 
		}
		else{
			header("Location: ./CDC.php?mode=manage&msg=noExist");
		}
	}
	else{
		header("Location: ./CDC.php?mode=manage&msg=noExist");
	}
}
ob_end_flush();	
?>