<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php?login=fail");
}
else{
	if(isset($_GET["error"]) && $_GET["error"]=="hacker"){?>
		<div class="ErrorContainer display">
			<b>HACKER ALERT!!!!</b> : dude, stop hacking my application.
		</div>
	<?php
	}
?>
	<script language="javascript">
		function formCheck(){
			var d=document.d_form;
			var errMsg="";
			var errColor="#ff1010"
			if(d.d_file.value==""){
				errMsg+="FILE: Please select a file to upload<br>";
				$('#d_file').css("background",errColor);
			}
			else{$('#d_file').css("background","");}

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
		function reset_msgs(){
			$('#d_file,#d_name,#d_branches,#d_branches2,#d_category,#d_year').css("background","");
			$('#d_msg').empty();
		}
	</script>
	<div id="d_pannel">
		<div id="d_title"></div>
		<form name="d_form" method="post" enctype="multipart/form-data" action="./runners/ecams-run-cdc-add-download.php" onSubmit="return formCheck()" >
			<table id="d_table">
				<tr>
					<td id="d_file"></td>
					<td>Select File : </td>
					<td><input name="d_file" type="file" ></td>												
				</tr>
				<tr>
					<td id="d_name"></td>
					<td>Download Name:</td>
					<td><input name="d_name" type="text" size="50"></td>									
				</tr>
				<tr>
					<td id="d_branches"></td>
					<td>Branches : </td>
					<td>
						CSE: <input name="d_b_cse" type="checkbox" > &nbsp
						ECE: <input name="d_b_ece" type="checkbox" > &nbsp
						EEE: <input name="d_b_eee" type="checkbox" > &nbsp
						IT: <input name="d_b_it" type="checkbox" > &nbsp
						CIVIL: <input name="d_b_civ" type="checkbox" > &nbsp
						MECH:<input name="d_b_mech" type="checkbox" > &nbsp
					</td>
				</tr>
				<tr>
					<td id="d_branches2"></td>
					<td></td>
					<td>
						MTech: <input name="d_b_mtech" type="checkbox" > &nbsp
						MBA: <input name="d_b_mba" type="checkbox" > &nbsp
						MCA:<input name="d_b_mca" type="checkbox" > &nbsp
					</td>
				</tr>
				<tr>
					<td id="d_category"></td>
					<td>Category : </td>
					<td>
						<select name="d_category">
							<option></option>
							<option>Mid Exams</option>
							<option>University Exams</option>
							<option>Assignments</option>
							<option>Project Docs</option>
							<option>Others</option>
						</select>
					</td>												
				</tr>
				<tr>
					<td id="d_year"></td>
					<td>Year : </td>
					<td>
						I:  <input name="d_y_1" type="checkbox" > &nbsp
						II: <input name="d_y_2" type="checkbox" > &nbsp
						III: <input name="d_y_3" type="checkbox" > &nbsp
						IV: <input name="d_y_4" type="checkbox" > &nbsp
					</td>												
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input type="submit" value="Submit">
						<input type="reset" onClick="reset_msgs()" value="Reset">
					</td>
					<td></td>
				</tr>					
			</table>
		</form>
		<div id="d_msg">
			<?php 
			if(isset($_GET["msg"])) 
			{
				if($_GET["msg"]=="Succ")
					echo "<b>Download added successfully</b>";
				elseif($_GET["msg"]=="internalError")
					echo "<b>Internal error</b>:<i> Try again. If problem persists, contact the developer.</i>";
				else if($_GET["msg"]=="nullFile")
					echo "<b>Null File : </b> The file cannot be NULL.";
				else if($_GET["msg"]=="uploadFail")
					echo "<b>Upload Fail : </b>Do not refresh or close during download.<br>Also check if your internet connection is fast enough to upload the file of this size.";
			}	
			?>
		</div>
	</div>
<?php
}
?>
