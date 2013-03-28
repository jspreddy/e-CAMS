<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php?login=fail");
}
else{

?>
		<script language="javascript">
			function urlGen(){
				var b;
				var c;
				var y;
				var base="./CDC.php?mode=manage&";
				var extend="";
				
				if(document.getElementById("d_b_cse").checked) {b="%1";}
				if(document.getElementById("d_b_ece").checked) {
					if(b){b+="%2";}
					else {b="%2";}
				}
				if(document.getElementById("d_b_eee").checked) {
					if(b){b+="%3";}
					else {b="%3";}
				}
				if(document.getElementById("d_b_it").checked) {
					if(b){b+="%4";}
					else {b="%4";}
				}
				if(document.getElementById("d_b_civ").checked) {
					if(b){b+="%5";}
					else {b="%5"}
				}
				if(document.getElementById("d_b_mech").checked) {
					if(b){b+="%6";}
					else {b="%6"}
				}
				if(document.getElementById("d_b_mtech").checked) {
					if(b){b+="%7";}
					else {b="%7"}
				}
				if(document.getElementById("d_b_mba").checked) {
					if(b){b+="%8";}
					else {b="%8"}
				}
				if(document.getElementById("d_b_mca").checked) {
					if(b){b+="%9";}
					else {b="%9"}
				}
				
				var i=document.getElementById("d_cat").selectedIndex;
				c=document.getElementById("d_cat").options[i].text;
				
				if(document.getElementById("d_y_1").checked){
					y="%1";
				}
				if(document.getElementById("d_y_2").checked){
					if(y){y+="%2";}
					else {y="%2";}
				}
				if(document.getElementById("d_y_3").checked){
					if(y){y+="%3";}
					else {y="%3";}
				}
				if(document.getElementById("d_y_4").checked){
					if(y){y+="%4";}
					else {y="%4";}
				}
				
				if(b){extend+="b="+b;}
				if(c){
					if(b){
						extend+="&c="+c;
					}
					else{
						extend+="c="+c;
					}
				}
				if(y){
					if(b || c){
						extend+="&y="+y;
					}
					else{
						extend+="y="+y;
					}
				}
				
				if(!document.getElementById("list_only_mine").checked){
					if( b||c||y ){extend+="&LOM=false";}
					else{extend+="LOM=false";}
				}
				
				document.getElementById("d_search_go").href=base+extend;
				return true;
			}
			$(document).ready(function(){
				$(".d_delLink").click(function(event){
					var go=confirm("Do you really want to delete the download?");
					event.preventDefault();
					var url=$(this).attr('href');
					if(go==true){
						window.location=url;
					}
				});
			});
		</script>
		<?php 
		if(isset($_GET["msg"])) 
		{
			if($_GET["msg"]=="Succ"){ ?>
				<div class="message display">
					<b>Success : </b> File deleted successfully.
				</div>
			<?php
			}
			elseif($_GET["msg"]=="Error"){ ?>
				<div class="ErrorContainer display">
					<b>Internal error</b>:<i> Try again. If problem persists, contact the developer.</i>
				</div>
			<?php
			}
			else if($_GET["msg"]=="noExist"){ ?>
				<div class="ErrorContainer display">
					<b>File doesn't exist</b>: Please select download only from the list.
				</div>
			<?php
			}
		}
		?>
		<div id="d_pannel">
			<div id="d_title"></div>
			<div id="d_search_container">
				<div id="d_search">
					<div id="d_search_title">List the Downloads belonging to:-</div>
					<table>
						<tr>
							<td>Branches : </td>
							<td>
								CSE: <input id="d_b_cse" type="checkbox" > &nbsp
								ECE: <input id="d_b_ece" type="checkbox" > &nbsp
								EEE: <input id="d_b_eee" type="checkbox" > &nbsp
								IT: <input id="d_b_it" type="checkbox" > &nbsp
								CIVIL: <input id="d_b_civ" type="checkbox" > &nbsp
								MECH: <input id="d_b_mech" type="checkbox" > &nbsp
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								MTech: <input id="d_b_mtech" type="checkbox" > &nbsp
								MBA: <input id="d_b_mba" type="checkbox" > &nbsp
								MCA: <input id="d_b_mca" type="checkbox" > &nbsp
							</td>
						</tr>
						<tr>
							<td>Category : </td>
							<td>
								<select id="d_cat">
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
							<td>Year : </td>
							<td>
								I:  <input id="d_y_1" type="checkbox" > &nbsp
								II: <input id="d_y_2" type="checkbox" > &nbsp
								III: <input id="d_y_3" type="checkbox" > &nbsp
								IV: <input id="d_y_4" type="checkbox" > &nbsp
							</td>												
						</tr>
						<tr>
							<td></td>
							<td>
								<a id="d_search_go" href="./CDC.php?mode=manage" onClick="return urlGen() ">Go</a>
								<label title="Lists the downloads belonging to you" id="LMineContainer" for="list_only_mine">
									<input id="list_only_mine" type="checkbox" <?php if(isset($_GET['LOM']) && $_GET['LOM']=='false'){}else{echo'checked="checked"';}?> > List only mine
								</label>
							</td>
						</tr>
					</table>
				</div>
				<div id="d_search_note">
					<div id="d_search_title">Note:-</div>
					<ul>
						<li>Select one option to list downloads belonging to that option.</li>
						<li>Select more options to list downloads classified as belonging to all the options selected.</li>
					</ul>
					<ul>
						<li>Example-1: To get all the downloads of CSE select only the CSE option and hit GO.</li>
						<li>Exmaple-2: To get the downloads common to CSE &amp; ECE select both CSE &amp; ECE options.</li>
					</ul>
					<ul>
						<li>NOTE: Hit GO without selecting anything to list all the available downloads.</li>
					</ul>
				</div>
			</div>
			<table id="d_list">
				<tr id="d_list_head">
					<td><div class="d_sno bold">S.No</div></td> 
					<td><div class="d_dname bold">Download Name</div></td>
					<td><div class="d_cat bold">Category</div></td>
					<td><div class="d_branch bold">Branches</div></td>
					<td><div class="d_years bold">Years</div></td>
					<td><div class="d_date bold">Date</div></td>
					<td><div class="d_view bold">View</div></td>
					<td><div class="d_edit bold d_acenter">Edit</div></td>
					<td><div class="d_del bold">Delete</div></td>
				</tr>
				<?php
					$baseQuery="SELECT rid,bid,yid,cid,uid,filename,displayname,date from cdc_downloads ";
					$queryOrder=" order by date desc";
					$queryBranch=NULL;
					$queryCategory=NULL;
					$queryYear=NULL;
					$uid =getUid();
					if(isset($_GET["b"]))
					{
						$queryBranch="where bid LIKE '".$_GET["b"]."%' ";
					}
					if(isset($_GET["c"]))
					{
						if(isset($_GET["b"]))
						{
							$queryCategory=" and cid='".$_GET["c"]."' ";
						}
						else
						{
							$queryCategory="where cid='".$_GET["c"]."'";
						}
					}
					if(isset($_GET["y"]))
					{
						if(isset($_GET["c"]) || isset($_GET["b"]))
						{
							$queryYear=" and yid LIKE '".$_GET["y"]."%' ";
						}
						else
						{
							$queryYear="where yid LIKE '".$_GET["y"]."%' ";
						}
					}
					
					$LOMquery=" where `uid`='$uid' ";
					if(isset($_GET["c"]) || isset($_GET["b"]) || isset($_GET["y"])){
						$LOMquery=" and `uid`='$uid' ";
					}
					if(isset($_GET["LOM"]) && $_GET["LOM"]=="false"){
						$LOMquery=" ";
					}
					$query=$baseQuery.$queryBranch.$queryCategory.$queryYear.$LOMquery.$queryOrder;
					//echo $query;
					$result = mysql_query($query) or die(mysql_error());
					if($result)
					{
						$i=0;
						while($row = mysql_fetch_array($result))
						{	
							$i=$i+1;
							$branches=null;
							if(strstr($row["bid"],'1')){$branches.="CSE, ";}
							if(strstr($row["bid"],'2')){$branches.="ECE, ";}
							if(strstr($row["bid"],'3')){$branches.="EEE, ";}
							if(strstr($row["bid"],'4')){$branches.="IT, ";}
							if(strstr($row["bid"],'5')){$branches.="CIVIL, ";}
							if(strstr($row["bid"],'6')){$branches.="MECH, ";}
							if(strstr($row["bid"],'7')){$branches.="MTech, ";}
							if(strstr($row["bid"],'8')){$branches.="MBA, ";}
							if(strstr($row["bid"],'9')){$branches.="MCA, ";}
				?>
				<tr class="d_list_row">
					<td class="d_acenter"><?php echo $i;?></td>
					<td><?php echo $row["displayname"]; ?></td>
					<td><?php echo $row["cid"]; ?></td>
					<td><?php echo $branches; ?></td>
					<td><?php echo $row["yid"]; ?></td>
					<td><?php echo $row["date"]; ?></td>
					<td class="d_acenter"><a class="d_viewLink" href="../../CDC/CDC_UploadDocs/<?php echo $row["filename"];?>" target="_BLANK"></a></td>
					<?php if(($uid==$row["uid"]) || (getUType()==1) ){?>
						<td class="d_acenter"><a class="d_editLink" href="./CDC.php?mode=edit&rid=<?php echo $row["rid"];?>"></a></td> 
						<td class="d_acenter">
							<a class="d_delLink" href="./runners/ecams-run-cdc-delete-download.php?rid=<?php echo $row["rid"];?>"></a>
							<?php $name=getName($row['uid']);?>
							<a class="d_owner_mini" href="./contacts.php?mode=view&uid=<?php echo $row['uid'];?>" title="<?php echo $name;?>"><?php echo substr($name,0,6);?></a>
						</td>
					<?php
					}else{
					?>
						<td colspan='2'>
							<?php $name=getName($row['uid']);?>
							<a href="./contacts.php?mode=view&uid=<?php echo $row['uid'];?>" title="<?php echo $name;?>"><?php echo substr($name,0,14);?></a>
						</td>
					<?php
					}?>
				</tr>
				<?php
						}
					}
				?>
			</table>
		</div>
<?php
}
?>