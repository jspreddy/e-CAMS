<?php

/**
 * Description of ecams_pdf
 *
 * @author P#@N!
 */
//require_once ("./fpdf.php");
class ecams_pdf extends FPDF{
	function Header(){
		$this->SetY(5);
		$this->SetFont('Arial','',10);
		$this->SetTextColor(100,100,100);
		$this->SetDrawColor(100,100,100);
		$this->Cell(0,5,'e-CAMS    contacts download','B',1,'R');
	}
	function Footer(){
		$this->SetY(-10);
		$this->SetFont('Arial','',10);
		$this->SetTextColor(100,100,100);
		$this->SetDrawColor(100,100,100);
		$this->Cell(0,5,'Page : '.$this->PageNo(),'T',0,'R');
	}
	function checkPageWrap(){
		$y=$this->GetY();
		if($y+55>=285){
			//$this->Line(20,285,160,280); just checking the page length
			$this->AddPage();
			$this->Ln();
		}
	}
	function contactHead($id, $name){
		$this->font1(); $this->Cell(30.5,8,$id,1,0,'L',true);
		$this->font1(); $this->Cell(160,8,'Name : '.$name,'LTR',1,'L',true);
	}
	function profPic($photo){
		if($photo!="" && file_exists("../profiles/images/".$photo)){
			$pic=$photo;
		}else{
			$pic="placeholderImage.jpg";
		}
		$this->Image('../profiles/images/'.$pic,$this->GetX(),$this->GetY(),30,40);
	}
	function halfWidth($key1,$val1,$key2,$val2){
		$this->SetXY($this->GetX()+30.5,$this->GetY());
		$this->font2(); $this->Cell(40,5,$key1,'LTR',0,'L',true);	//cell1
		$this->font3(); $this->Cell(40,5,$val1,'TR',0,'L');		//cell2
		$this->font2(); $this->Cell(40,5,$key2,'LTR',0,'L',true);	//cell3
		$this->font3(); $this->Cell(40,5,$val2,'TR',1,'L');		//cell4
	}
	function fullWidth($key1, $val1){
		$this->SetXY($this->GetX()+30.5,$this->GetY());
		$this->font2(); $this->Cell(40,5,$key1,'LTR',0,'L',true);
		$this->font3(); $this->Cell(120,5,$val1,'TR',1,'L');
	}
	function fullWidth_wrap($key1, $val1){
		$this->SetXY($this->GetX()+30.5,$this->GetY());
		$this->font2(); $this->Cell(40,5,$key1,'LTR',0,'L',true);
		$this->font4(); $this->Cell(120,5,$val1,'TR',1,'L');
	}
	function contactFooter($picname,$registeredDate){
		$this->font5();
		$this->Cell(30.5,4,$picname,1,0,'L',true);
		$this->Cell(160,4,'Registered on : '.$registeredDate,1,1,'L',true);
	}
	function font1(){
		$this->SetFont('Arial','',13);
	}
	function font2(){
		$this->SetFont('Arial','',12);
		$this->SetTextColor(20,20,20);
		$this->SetFillColor(220,220,220);
	}
	function font3(){
		$this->SetFont('Arial','',11);
		$this->SetTextColor(40,40,40);
	}
	function font4(){
		$this->SetFont('Arial','',10);
		$this->SetTextColor(60,60,60);
	}
	function font5(){
		$this->SetFont('Arial','',9);
		$this->SetTextColor(100,100,100);
	}
}

?>
