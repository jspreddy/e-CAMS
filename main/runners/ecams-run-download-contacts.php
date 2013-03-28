<?php
ob_start();
session_start();
if(!isset($_SESSION["id"])){
	header("Location: ../index.php");
}
else if($_SESSION["user_type"]==1){
	require_once("../includes/databaseConnection.php");
	require_once("../config/SystemConstantsConfig.php");
	require_once("../includes/EncryptionFunctions.php");
	require_once("../includes/initialisation.php");
	if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["dlrange"]) && isset($_GET["dltype"]) && ($_GET["dltype"]=="csv" || $_GET["dltype"]=="pdf") && ($_GET["dlrange"]=="full" || $_GET["dlrange"]=="filled")){
		//echo "dltype= ".$_GET["dltype"]."<br>";
		//echo "dlrange= ".$_GET["dlrange"]."<br>";
		$dltype=$_GET["dltype"];
		$dlrange=$_GET["dlrange"];
		$data=array();
		$date=date("d-m-Y_H-i-s");
		$user_types=array(
				"ERROR",
				"Administrator",
				"Principal",
				"HOD",
				"Staff"
			);
		$row_profiles=array("id","first_name", "last_name", "dob", "photo", "department", "post", "qualification", "second_email", "phone", "mobile", "address");
		if($dlrange=="full"){
			$query_users="select id, user_login, user_email, user_registered_date, user_status, display_name, user_type from users order by id";
			$result_users=mysql_query($query_users) or die(mysql_error());
			$count_users=mysql_num_rows($result_users);
			if($count_users>0){
				$i=0;
				while($row_users=mysql_fetch_array($result_users)){
					$query_profiles="select first_name, last_name, dob, photo, department, post, qualification, second_email, phone, mobile, address from profiles where id=".$row_users["id"]." limit 1";
					$result_profiles=mysql_query($query_profiles) or die(mysql_error());
					//$count_profiles=mysql_num_rows($result_profiles);
					$row_profiles=mysql_fetch_array($result_profiles);
					
					$data[$i]["id/sno"]=$row_users["id"];
					
					$data[$i]["user_login"]=$row_users["user_login"];
					$data[$i]["official_email"]=$row_users["user_email"];
					$data[$i]["user_registered_date"]=$row_users["user_registered_date"];
					$data[$i]["user_status"]=$row_users["user_status"];
					$data[$i]["display_name"]=$row_users["display_name"];
					$data[$i]["user_type"]=$user_types[$row_users["user_type"]];
					
					$data[$i]["first_name"]=$row_profiles["first_name"];
					$data[$i]["last_name"]=$row_profiles["last_name"];
					$data[$i]["dob"]=$row_profiles["dob"];
					$data[$i]["photo"]=$row_profiles["photo"];
					$data[$i]["department"]=$row_profiles["department"];
					$data[$i]["post/designation"]=$row_profiles["post"];
					$data[$i]["qualification"]=$row_profiles["qualification"];
					$data[$i]["personal_email"]=$row_profiles["second_email"];
					$data[$i]["phone"]=$row_profiles["phone"];
					$data[$i]["mobile"]=$row_profiles["mobile"];
					$temp=str_replace(',','_',$row_profiles["address"]);
					$temp=str_replace(array("\r","\r\n","\n"),'_',$temp);
					$data[$i]["address"]=$temp;
					//echo $temp."<br>";
					$i++;
				}
			}
		}
		else if($dlrange=="filled"){
			$currdate=date("Y-m-d H:i:s");
			$query_profiles="select id, first_name, last_name, dob, photo, department, post, qualification, second_email, phone, mobile, address from profiles where TIMESTAMPDIFF(DAY,last_edit_date,'$currdate')>0 order by id";
			$result_profiles=mysql_query($query_profiles) or die(mysql_error());
			$count_profiles=mysql_num_rows($result_profiles);
			if($count_profiles>0){
				$i=0;
				while($row_profiles=mysql_fetch_array($result_profiles)){
					$query_users="select user_login, user_email, user_registered_date, user_status, display_name, user_type from users where id=".$row_profiles["id"]." limit 1";
					$result_users=mysql_query($query_users) or die(mysql_error());
					$row_users=mysql_fetch_array($result_users);
					
					$data[$i]["id/sno"]=$row_profiles["id"];
					//echo "<br>".$row_profiles["id"];
					$data[$i]["user_login"]=$row_users["user_login"];
					$data[$i]["official_email"]=$row_users["user_email"];
					$data[$i]["user_registered_date"]=$row_users["user_registered_date"];
					$data[$i]["user_status"]=$row_users["user_status"];
					$data[$i]["display_name"]=$row_users["display_name"];
					$data[$i]["user_type"]=$user_types[$row_users["user_type"]];
					
					$data[$i]["first_name"]=$row_profiles["first_name"];
					$data[$i]["last_name"]=$row_profiles["last_name"];
					$data[$i]["dob"]=$row_profiles["dob"];
					$data[$i]["photo"]=$row_profiles["photo"];
					$data[$i]["department"]=$row_profiles["department"];
					$data[$i]["post/designation"]=$row_profiles["post"];
					$data[$i]["qualification"]=$row_profiles["qualification"];
					$data[$i]["personal_email"]=$row_profiles["second_email"];
					$data[$i]["phone"]=$row_profiles["phone"];
					$data[$i]["mobile"]=$row_profiles["mobile"];
					$temp=str_replace(',','_',$row_profiles["address"]);
					$temp=str_replace(array("\r","\r\n","\n"),'_',$temp);
					$data[$i]["address"]=$temp;
					//echo $temp."<br>";
					$i++;
				}
			}
		}
		else{ echo"UNDEFINED download range<br>";die(); }
		
		//$keys=array_keys($data[1]);
		
		if($dltype=="csv"){
			$keys=array_keys($data[1]);
			$filename=$date.".csv";
			$fp=fopen("../tmp/dls/$filename","w");
			fputcsv($fp,$keys,',');
			foreach($data as $id=>$val){
				fputcsv($fp,$val,',');
			}
			fclose($fp);
		
			header("Location: ../tmp/dls/$filename");
		}
		else if($dltype=="pdf"){
			//echo "PFD download function is not available yet<br>";
			//echo "For now try downloading contacts using the CSV feature.<br>";
			require_once("../includes/fpdf.php");
			require_once("../includes/ecams_pdf.php");
			$pdf=new ecams_pdf('P','mm','A4');
			$pdf->AddPage();
			$pdf->SetFont('Arial','',11);
			foreach($data as $key1=>$key2){
				$pdf->Ln();
				$pdf->checkPageWrap();
				if($data[$key1]["user_status"]){
					$pdf->SetFillColor(180,180,180);
					$pdf->SetTextColor(0,0,0);
					
				}else{
					$pdf->SetFillColor(100,40,40);
					$pdf->SetTextColor(250,250,250);
				}
				$pdf->contactHead($data[$key1]["user_login"],$data[$key1]["first_name"].' , '.$data[$key1]["last_name"]);
				$pdf->profPic($data[$key1]["photo"]);
				//$pdf->halfWidth( '', $data[$key1][""],'', $data[$key1][""]);
				//$pdf->fullWidth( '', $data[$key1][""]);
				$pdf->halfWidth( 'Login ID', $data[$key1]["user_login"],'Display Name', $data[$key1]["display_name"]);
				$pdf->halfWidth( 'DOB', $data[$key1]["dob"],'User Type', $data[$key1]["user_type"]);
				$pdf->halfWidth( 'Mobile No.', $data[$key1]["mobile"],'Department', $data[$key1]["department"]);
				$pdf->halfWidth( 'Phone', $data[$key1]["phone"],'Designation', $data[$key1]["post/designation"]);
				$pdf->fullWidth('Official Email', $data[$key1]["official_email"]);
				$pdf->fullWidth('Personal Email', $data[$key1]["personal_email"]);
				$pdf->fullWidth('Qualification', $data[$key1]["qualification"]);
				$pdf->fullwidth_wrap('Address', $data[$key1]["address"]);
				$pdf->contactFooter($data[$key1]["photo"],$data[$key1]["user_registered_date"]);
				$pdf->Ln();
				$pdf->Ln();
			}
			$pdf->Output();
		}
		else{ echo "UNDEFINED download file type.<br>";die(); }
		//echo "<br>done<br>";
	}
	else{
		header("Location: ../User.php?mode=view&error=hacker");
	}
}
else{
?>
<br>Access Denied<br>
<?php
}
ob_end_flush();
?>