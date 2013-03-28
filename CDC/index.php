<?php
	$dispRightPane=false;
	$dispList=false;
	if(isset($_GET["bid"]) && isset($_GET["yid"])){
		if($_GET["bid"]>0 && $_GET["yid"]>0 && $_GET["bid"]<=9 && $_GET["yid"]<=4){
			$dispRightPane=true;
		}
	}
	if(isset($_GET["cid"])){
		if($_GET["cid"]=="Mid Exams" || $_GET["cid"]=="University Exams"||$_GET["cid"]=="Project Docs"||$_GET["cid"]=="Assignments"||$_GET["cid"]=="Others"){
			$dispList=true;
		}
	}
	
require_once("includes/connection.php");
require_once("includes/CDC_functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"> 
<html>
	<head>
		<title>CDC @ DRKCET</title>
		<link rel="stylesheet" href="./css/style.css" type="text/css">
		<link type="text/css" href="./css/ui-lightness/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="./js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.8.17.custom.min.js"></script>
		<script type="text/javascript" src="./js/jquery.jcarousel.min.js"></script>
		<link rel="stylesheet" type="text/css" href="./css/skin.css" />
		<script type="text/javascript">
			jQuery(document).ready(function(){
				$('#catList').accordion({
					header: '.mainListItem',
					active:false,
					collapsible:true
				});
				jQuery('#carousel1').jcarousel({start:2});
				jQuery('#carousel2').jcarousel({start:2});
				jQuery('#carousel3').jcarousel({start:2});
				jQuery('#carousel4').jcarousel({start:2});
				jQuery('#carousel5').jcarousel({start:2});
				$('.jcarousel-next').html("<div class='icon icon-next'></div>");
				$('.jcarousel-prev').html("<div class='icon icon-prev'></div>");
			});
		</script>
		<script type="text/javascript">
			$(function () {
				$('.downloadContainer').each(function () {
					var time = 250;
					var hideDelay = 250;

					var hideDelayTimer = null;

					var beingShown = false;
					var shown = false;
					var trigger = $('.trigger', this);
					var info = $('.download-Desc-Container', this).css('opacity', 0);


					$([trigger.get(0), info.get(0)]).mouseover(function () {
						if (hideDelayTimer) clearTimeout(hideDelayTimer);
						if (beingShown || shown) {
							// don't trigger the animation again
							return;
						} else {
							// reset position of info box
							beingShown = true;

							info.css({
								display: 'block'
							}).animate({
								opacity: 1
							}, time, 'swing', function() {
								beingShown = false;
								shown = true;
							});
						}

						return false;
					}).mouseout(function () {
						if (hideDelayTimer) clearTimeout(hideDelayTimer);
						hideDelayTimer = setTimeout(function () {
							hideDelayTimer = null;
							info.animate({
								opacity: 0
							}, time, 'swing', function () {
								shown = false;
								info.css('display', 'none');
							});

						}, hideDelay);

						return false;
					});
				});
			});
		</script>
	</head>
	<body>
		<div id="page">
			<div id="pageTitle">
				<a id="titleImage" href="index.php"></a>
			</div>
			<div id="contentWrapper">
				<div id="leftPane">
					<h3>Select Branch, Year</h3>
					<div id="catList">
						<div class="mainListItem"><a>CSE</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=1&yid=1">First Year</a></li>
								<li><a href="index.php?bid=1&yid=2">Second Year</a></li>
								<li><a href="index.php?bid=1&yid=3">Third Year</a></li>
								<li><a href="index.php?bid=1&yid=4">Fourth Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>ECE</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=2&yid=1">First Year</a></li>
								<li><a href="index.php?bid=2&yid=2">Second Year</a></li>
								<li><a href="index.php?bid=2&yid=3">Third Year</a></li>
								<li><a href="index.php?bid=2&yid=4">Fourth Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>EEE</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=3&yid=1">First Year</a></li>
								<li><a href="index.php?bid=3&yid=2">Second Year</a></li>
								<li><a href="index.php?bid=3&yid=3">Third Year</a></li>
								<li><a href="index.php?bid=3&yid=4">Fourth Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>IT</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=4&yid=1">First Year</a></li>
								<li><a href="index.php?bid=4&yid=2">Second Year</a></li>
								<li><a href="index.php?bid=4&yid=3">Third Year</a></li>
								<li><a href="index.php?bid=4&yid=4">Fourth Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>CIVIL</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=5&yid=1">First Year</a></li>
								<li><a href="index.php?bid=5&yid=2">Second Year</a></li>
								<li><a href="index.php?bid=5&yid=3">Third Year</a></li>
								<li><a href="index.php?bid=5&yid=4">Fourth Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>MECH</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=6&yid=1">First Year</a></li>
								<li><a href="index.php?bid=6&yid=2">Second Year</a></li>
								<li><a href="index.php?bid=6&yid=3">Third Year</a></li>
								<li><a href="index.php?bid=6&yid=4">Fourth Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>MTech</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=7&yid=1">First Year</a></li>
								<li><a href="index.php?bid=7&yid=2">Second Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>MBA</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=8&yid=1">First Year</a></li>
								<li><a href="index.php?bid=8&yid=2">Second Year</a></li>
							</ul>
						</div>
						<div class="mainListItem"><a>MCA</a></div>
						<div>
							<ul class="yearList">
								<li><a href="index.php?bid=9&yid=1">First Year</a></li>
								<li><a href="index.php?bid=9&yid=2">Second Year</a></li>
							</ul>
						</div>
					</div>
				</div>
				
				<div id="rightPane">
				<?php if($dispRightPane==false){ ?>
					<div class="please-select-branch">
						Please Select your Branch &amp; Year.
					</div>
					<div class="interfaceHelpContainer">
						<div class="interfaceHelpTitle">Download Color Change based on age</div>
						<img src="./images/3states.png" alt="3 states of a download">
					</div>
				<?php 
				}else
				{?>
					<div id="breadCrumbContainer">
						<a class="breadLink" href="index.php">CDC Home</a>
						<a class="breadLink">
							<?php
								if($_GET["bid"]==1){echo "CSE";}
								else if($_GET["bid"]==2){echo "ECE";}
								else if($_GET["bid"]==3){echo "EEE";}
								else if($_GET["bid"]==4){echo "IT";}
								else if($_GET["bid"]==5){echo "CIVIL";}
								else if($_GET["bid"]==6){echo "MECH";}
								else if($_GET["bid"]==7){echo "MTech";}
								else if($_GET["bid"]==8){echo "MBA";}
								else if($_GET["bid"]==9){echo "MCA";}
							?>
						</a>
						<a class="breadLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>">
							<?php
								if($_GET["yid"]==1){echo "First Year";}
								else if($_GET["yid"]==2){echo "Second Year";}
								else if($_GET["yid"]==3){echo "Third Year";}
								else if($_GET["yid"]==4){echo "Fourth Year";}
							?>
						</a>
						<?php if($dispList==true){?>
							<a class="breadLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=<?php echo $_GET["cid"];?>"><?php echo $_GET["cid"];?></a>
						<?php 
						}?>
					</div>
					<?php 
						$baseQuery="SELECT bid,yid,cid,uid,filename,displayname,size,date from cdc_downloads ";
						$queryOrder="order by date desc ";
						$queryBranch="where bid LIKE '%".$_GET["bid"]."%' ";
						$queryYear="and yid LIKE '%".$_GET["yid"]."%' ";
					?>
					<?php if($dispList==false){?>
						<div class="categoryContainer">
							<a class="categoryLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Mid%20Exams">
								<div class="linkDisplay blue">
									Mid Exams
								</div>
							</a>
							<div class="sliderContainer">
								<ul id="carousel1" class="jcarousel-skin-tango">
									<li></li> <!-- for buffering the carousel-->
									<?php
										$queryCategory=" and cid='Mid Exams' ";
										$query=$baseQuery.$queryBranch.$queryYear.$queryCategory.$queryOrder;
										$result = mysql_query($query) or die(mysql_error());
										if($result)
										{
											$i=0;
											while($row = mysql_fetch_array($result))
											{
												$i+=1;
												if($i==20){
												?>
													<li>
														<div class="downloadContainer">
															<a class="trigger" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Mid%20Exams">
																<div class="download-Image-Container">
																	<div class="download-Desc-Container">
																		more files in archive.<br>
																		click here to go to archive.
																	</div>
																</div>
																<div class="download-Title-Container"><div class="download-Title">ARCHIVE</div></div>
															</a>
														</div>
													</li>
												<?php
													break;
												}
												$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
												$filedate=$row["date"];
												$currentdate=date("y-m-d");
												$diff = abs(strtotime($currentdate) - strtotime($filedate));
												$days = floor(($diff)/ (60*60*24));
												if($days<2){$ageColor="newDownload";}
												elseif($days>=2 && $days<4){$ageColor="oldDownload";}
												elseif($days>=4){$ageColor="archivedDownload";}
									?>
									<li>
										<div class="downloadContainer">
											<a class="trigger" href="CDC_UploadDocs/<?php echo $row["filename"];?>" target="_BLANK">
												<div class="download-Image-Container download-Image-Background-<?php echo $ext?>">
													<div class="download-Desc-Container">
														<b>Size: </b><?php echo round(($row["size"]/1024/1024),3);?> MB<br>
														<b>Date: </b><?php echo date('M-d-Y',strtotime($row["date"]));?><br>
														<b>Age: </b><?php echo $days;?> Days<br>
														<b>Type: </b><?php echo strtoupper($ext);?><br>
														<b>Owner: </b><?php echo getName($row['uid']);?>
													</div>
												</div>
												<div class="download-Title-Container <?php echo $ageColor;?>"><div class="download-Title"><?php echo $row["displayname"];?></div></div>
											</a>
										</div>
									</li>
									<?php
											}
										}
									?>
									<li></li><!-- for buffering the carousel-->
								</ul>
							</div>
						</div>
						
						<div class="categoryContainer">
							<a class="categoryLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=University%20Exams">
								<div class="linkDisplay green">
									University Exams
								</div>
							</a>
							<div class="sliderContainer">
								<ul id="carousel2" class="jcarousel-skin-tango">
									<li></li> <!-- for buffering the carousel-->
									<?php
										$queryCategory=" and cid='University Exams' ";
										$query=$baseQuery.$queryBranch.$queryYear.$queryCategory.$queryOrder;
										$result = mysql_query($query) or die(mysql_error());
										if($result)
										{
											$i=0;
											while($row = mysql_fetch_array($result))
											{
												$i+=1;
												if($i==20){
												?>
													<li>
														<div class="downloadContainer">
															<a class="trigger" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=University%20Exams">
																<div class="download-Image-Container">
																	<div class="download-Desc-Container">
																		more files in archive.<br>
																		click here to go to archive.
																	</div>
																</div>
																<div class="download-Title-Container"><div class="download-Title">ARCHIVE</div></div>
															</a>
														</div>
													</li>
												<?php
													break;
												}
												$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
												$filedate=$row["date"];
												$currentdate=date("y-m-d");
												$diff = abs(strtotime($currentdate) - strtotime($filedate));
												$days = floor(($diff)/ (60*60*24));
												if($days<2){$ageColor="newDownload";}
												elseif($days>=2 && $days<4){$ageColor="oldDownload";}
												elseif($days>=4){$ageColor="archivedDownload";}
									?>
									<li>
										<div class="downloadContainer">
											<a class="trigger" href="CDC_UploadDocs/<?php echo $row["filename"];?>" target="_BLANK">
												<div class="download-Image-Container download-Image-Background-<?php echo $ext?>">
													<div class="download-Desc-Container">
														<b>Size: </b><?php echo round(($row["size"]/1024/1024),3);?> MB<br>
														<b>Date: </b><?php echo date('M-d-Y',strtotime($row["date"]));?><br>
														<b>Age: </b><?php echo $days;?> Days<br>
														<b>Type: </b><?php echo strtoupper($ext);?><br>
														<b>Owner: </b><?php echo getName($row['uid']);?>
													</div>
												</div>
												<div class="download-Title-Container <?php echo $ageColor;?>"><div class="download-Title"><?php echo $row["displayname"];?></div></div>
											</a>
										</div>
									</li>
									<?php
											}
										}
									?>
									
									<li></li><!-- for buffering the carousel-->
								</ul>
							</div>
						</div>
						
						<div class="categoryContainer">
							<a class="categoryLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Assignments">
								<div class="linkDisplay orange">
									Assignments
								</div>
							</a>
							<div class="sliderContainer">
								<ul id="carousel3" class="jcarousel-skin-tango">
									<li></li> <!-- for buffering the carousel-->
									<?php
										$queryCategory=" and cid='Assignments' ";
										$query=$baseQuery.$queryBranch.$queryYear.$queryCategory.$queryOrder;
										$result = mysql_query($query) or die(mysql_error());
										if($result)
										{
											$i=0;
											while($row = mysql_fetch_array($result))
											{
												$i+=1;
												if($i==20){
												?>
													<li>
														<div class="downloadContainer">
															<a class="trigger" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Assignments">
																<div class="download-Image-Container">
																	<div class="download-Desc-Container">
																		more files in archive.<br>
																		click here to go to archive.
																	</div>
																</div>
																<div class="download-Title-Container"><div class="download-Title">ARCHIVE</div></div>
															</a>
														</div>
													</li>
												<?php
													break;
												}
												$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
												$filedate=$row["date"];
												$currentdate=date("y-m-d");
												$diff = abs(strtotime($currentdate) - strtotime($filedate));
												$days = floor(($diff)/ (60*60*24));
												if($days<2){$ageColor="newDownload";}
												elseif($days>=2 && $days<4){$ageColor="oldDownload";}
												elseif($days>=4){$ageColor="archivedDownload";}
									?>
									<li>
										<div class="downloadContainer">
											<a class="trigger" href="CDC_UploadDocs/<?php echo $row["filename"];?>" target="_BLANK">
												<div class="download-Image-Container download-Image-Background-<?php echo $ext?>">
													<div class="download-Desc-Container">
														<b>Size: </b><?php echo round(($row["size"]/1024/1024),3);?> MB<br>
														<b>Date: </b><?php echo date('M-d-Y',strtotime($row["date"]));?><br>
														<b>Age: </b><?php echo $days;?> Days<br>
														<b>Type: </b><?php echo strtoupper($ext);?><br>
														<b>Owner: </b><?php echo getName($row['uid']);?>
													</div>
												</div>
												<div class="download-Title-Container <?php echo $ageColor;?>"><div class="download-Title"><?php echo $row["displayname"];?></div></div>
											</a>
										</div>
									</li>
									<?php
											}
										}
									?>
									
									<li></li><!-- for buffering the carousel-->
								</ul>
							</div>
						</div>
						
						<div class="categoryContainer">
							<a class="categoryLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Project%20Docs">
								<div class="linkDisplay pink">
									Project Documents
								</div>
							</a>
							<div class="sliderContainer">
								<ul id="carousel4" class="jcarousel-skin-tango">
									<li></li> <!-- for buffering the carousel-->
									<?php
										$queryCategory=" and cid='Project Docs' ";
										$query=$baseQuery.$queryBranch.$queryYear.$queryCategory.$queryOrder;
										$result = mysql_query($query) or die(mysql_error());
										if($result)
										{
											$i=0;
											while($row = mysql_fetch_array($result))
											{
												$i+=1;
												if($i==20){
												?>
													<li>
														<div class="downloadContainer">
															<a class="trigger" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Project%20Docs">
																<div class="download-Image-Container">
																	<div class="download-Desc-Container">
																		more files in archive.<br>
																		click here to go to archive.
																	</div>
																</div>
																<div class="download-Title-Container"><div class="download-Title">ARCHIVE</div></div>
															</a>
														</div>
													</li>
												<?php
													break;
												}
												$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
												$filedate=$row["date"];
												$currentdate=date("y-m-d");
												$diff = abs(strtotime($currentdate) - strtotime($filedate));
												$days = floor(($diff)/ (60*60*24));
												if($days<2){$ageColor="newDownload";}
												elseif($days>=2 && $days<4){$ageColor="oldDownload";}
												elseif($days>=4){$ageColor="archivedDownload";}
									?>
									<li>
										<div class="downloadContainer">
											<a class="trigger" href="CDC_UploadDocs/<?php echo $row["filename"];?>" target="_BLANK">
												<div class="download-Image-Container download-Image-Background-<?php echo $ext?>">
													<div class="download-Desc-Container">
														<b>Size: </b><?php echo round(($row["size"]/1024/1024),3);?> MB<br>
														<b>Date: </b><?php echo date('M-d-Y',strtotime($row["date"]));?><br>
														<b>Age: </b><?php echo $days;?> Days<br>
														<b>Type: </b><?php echo strtoupper($ext);?><br>
														<b>Owner: </b><?php echo getName($row['uid']);?>
													</div>
												</div>
												<div class="download-Title-Container <?php echo $ageColor;?>"><div class="download-Title"><?php echo $row["displayname"];?></div></div>
											</a>
										</div>
									</li>
									<?php
											}
										}
									?>
									
									<li></li><!-- for buffering the carousel-->
								</ul>
							</div>
						</div>
						
						<div class="categoryContainer">
							<a class="categoryLink" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Others">
								<div class="linkDisplay silver">
									Others
								</div>
							</a>
							<div class="sliderContainer">
								<ul id="carousel5" class="jcarousel-skin-tango">
									<li></li> <!-- for buffering the carousel-->
									<?php
										$queryCategory=" and cid='Others' ";
										$query=$baseQuery.$queryBranch.$queryYear.$queryCategory.$queryOrder;
										$result = mysql_query($query) or die(mysql_error());
										if($result)
										{
											$i=0;
											while($row = mysql_fetch_array($result))
											{
												$i+=1;
												if($i==20){
													?>
														<li>
															<div class="downloadContainer">
																<a class="trigger" href="index.php?bid=<?php echo $_GET["bid"];?>&yid=<?php echo $_GET["yid"];?>&cid=Others">
																	<div class="download-Image-Container">
																		<div class="download-Desc-Container">
																			more files in archive.<br>
																			click here to go to archive.
																		</div>
																	</div>
																	<div class="download-Title-Container"><div class="download-Title">ARCHIVE</div></div>
																</a>
															</div>
														</li>
													<?php
														break;
													}
												$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
												$filedate=$row["date"];
												$currentdate=date("y-m-d");
												$diff = abs(strtotime($currentdate) - strtotime($filedate));
												$days = floor(($diff)/ (60*60*24));
												if($days<2){$ageColor="newDownload";}
													elseif($days>=2 && $days<4){$ageColor="oldDownload";}
													elseif($days>=4){$ageColor="archivedDownload";}
									?>
									<li>
										<div class="downloadContainer">
											<a class="trigger" href="CDC_UploadDocs/<?php echo $row["filename"];?>" target="_BLANK">
												<div class="download-Image-Container download-Image-Background-<?php echo $ext?>">
													<div class="download-Desc-Container">
														<b>Size: </b><?php echo round(($row["size"]/1024/1024),3);?> MB<br>
														<b>Date: </b><?php echo date('M-d-Y',strtotime($row["date"]));?><br>
														<b>Age: </b><?php echo $days;?> Days<br>
														<b>Type: </b><?php echo strtoupper($ext);?><br>
														<b>Owner: </b><?php echo getName($row['uid']);?>
													</div>
												</div>
												<div class="download-Title-Container <?php echo $ageColor;?>"><div class="download-Title"><?php echo $row["displayname"];?></div></div>
											</a>
										</div>
									</li>
									<?php
											}
										}
									?>
									
									<li></li><!-- for buffering the carousel-->
								</ul>
							</div>
						</div>					
					<?php 
					}else if($dispList==true){
						$queryCategory=" and cid='".$_GET["cid"]."' ";
						$query=$baseQuery.$queryBranch.$queryYear.$queryCategory.$queryOrder;
						$result = mysql_query($query) or die(mysql_error());
					?>
						<div id="listViewContainer">
							<table>
								<tr id="listViewHeader">
									<td><div id="lv_sno">S.No</div></td>
									<td><div id="lv_dn">Download Name</div></td>
									<td><div id="lv_size">Size</div></td>
									<td><div id="lv_date">Date</div></td>
									<td><div id="lv_age">Age</div></td>
									<td><div id="lv_type">Type</div></td>
									<td><div id="lv_owner">Owner</div></td>
								</tr>
								<?php
									if($result)
									{	
										$i=0;
										while($row = mysql_fetch_array($result))
										{
											$i+=1;
											$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
											$filedate=$row["date"];
											$currentdate=date("y-m-d");
											$diff = abs(strtotime($currentdate) - strtotime($filedate));
											$days = floor(($diff)/ (60*60*24));
											$ext=pathinfo($row["filename"],PATHINFO_EXTENSION);
								?>
								<tr class="lv_row">
									<td class="col_center"><?php echo $i;?></td>
									<td><a class="lv_link" href="CDC_UploadDocs/<?php echo $row["filename"];?>" target="_blank"><?php echo $row["displayname"];?></a></td>
									<td><?php echo round(($row["size"]/1024/1024),3);?> MB</td>
									<td><?php echo date('M-d-Y',strtotime($row["date"]));?></td>
									<td><?php echo $days;?> Days</td>
									<td><?php echo strtoupper($ext);?></td>
									<td><?php echo getName($row['uid']);?></td>
								</tr>
								<?php   }
									}
								?>
							</table>
						</div>
				<?php }
				}?>
				</div>
			</div>
			
			<div id="footer">
				<div id="author">
					<div id="designBy">Design By</div> <a id="authorLink" href="../profile.html" target="_BLANK">jspreddy</a>
				</div>
			</div>
		</div>
	</body>
</html>