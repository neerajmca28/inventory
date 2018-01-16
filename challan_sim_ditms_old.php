<?php
ob_start();
//ini_set("session.auto_start", 0);
include("config.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
require_once('/fpdf/fpdf.php');

 //echo date('H:i:sa'); die;
$masterObj = new master(); 
 //print_r($_GET); die; 
$login_name=$_SESSION['user_name_inv'];
$strChallanNo=$_GET['challanNo'];
$to_repair=$_GET['to_repair'];
//$strChallanNo='CHNO109';
 $GetSimInstallerChallanDetailByNo=$masterObj->GetSimInstallerChallanDetailByNo($strChallanNo);  
$count=count($GetSimInstallerChallanDetailByNo);
//echo '<pre>';print_r($GetSimInstallerChallanDetailByNo);die;	  
if($count>0)
{
	
		 if($GetSimInstallerChallanDetailByNo[0]['branch_id']==1)
		 {
			  $branch_name='Delhi';
		 }
		 if($GetSimInstallerChallanDetailByNo[0]['branch_id']==2)
		 {
			  $branch_name='Mumbai';
		 }
			
		if($GetSimInstallerChallanDetailByNo[0]['branch_id']==3)
		 {
			  $branch_name='Jaipur';
		 }
			
		if($GetSimInstallerChallanDetailByNo[0]['branch_id']==4)
		 {
			  $branch_name='Sonepat';
		 }
			
		if($GetSimInstallerChallanDetailByNo[0]['branch_id']==5)
		 {
			  $branch_name='Kanpur';
		 }
			
		if($GetSimInstallerChallanDetailByNo[0]['branch_id']==6)
		 {
			  $branch_name='Ahamedabad';
		 }
					
		if($GetSimInstallerChallanDetailByNo[0]['branch_id']==7)
		 {
			  $branch_name='Kolkata';
		 }
		 
				$pdf=new FPDF();
				$pdf->AddPage();
				$pdf->SetFont('Arial','',10);
				$pdf->Image('fpdf/header.png',10,6,200);
				//  $pdf->cell(18,10,'',0);
				  
				  $pdf->ln(8);
				  $pdf->cell(180,10,'Challan NO:'.$strChallanNo.'',0,6,'R');
				  $pdf->cell(180,10,'Date:'.date('d-m-Y').'',0,6,'R');
				   $pdf->cell(180,10,'Time:'.date("H:i:s a").'',0,6,'R');
				   
				  $pdf->ln(70);
				  $pdf->SetFont('Arial','B',11);
				  $pdf->cell(70,8,'',0);
				  $pdf->cell(100,8,'Delivery Challan',0);
				  		   
				  $pdf->ln(15);
				  $pdf->SetFont('Arial','',11);
				  $pdf->cell(50,6,'Repair Name/DITMS:',0);
				 $pdf->cell(50,6,$to_repair,0);
				  $pdf->cell(50,6,'Delivered By:',0);
				  $pdf->cell(50,6,$branch_name,0);
				  

					// Column headings
					$header = array('S.no', 'Operator', 'Phone No'	);
					$pdf->SetFont('Arial','',8);
					//print_r($header); die;

	
					// Colors, line width and bold font
					$pdf->SetFillColor(255,0,255);
					//$pdf->SetTextColor(255);
					//$pdf->SetDrawColor(128,0,0);
					$pdf->SetLineWidth(.2);
					$pdf->SetFont('','');
					$pdf->Ln(15);
					// Header
					$w = array(30,70,70);
							//print_r($w); die;
				
				for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
				$pdf->Ln();
				// Color and font restoration
				//$pdf->SetFillColor(224,235,255);
				//$pdf->SetTextColor(91,137,42);
				$pdf->SetFont('');
				// Data
				$fill = false;
				for($j=0;$j<$count;$j++)
				{
				$y=$j+1;
				//print_r($data); 
				$pdf->Cell($w[0],6,$y,'LR',0,'C',$fill);
				$pdf->Cell($w[1],6,$GetSimInstallerChallanDetailByNo[$j]['operator'],'LR',0,'C',$fill);
				$pdf->Cell($w[2],6,$GetSimInstallerChallanDetailByNo[$j]['phone_no'],'LR',0,'C',$fill);
				$pdf->Ln();
				$fill = !$fill;
				}

 	// Closing line
	    $pdf->Cell(array_sum($w),0,'','T');
		//footer

			/* 	 $pdf->AddPage();
				  $pdf->SetFont('Arial','',10);
				 // $pdf->Image('logo.png',10,6,30);
					//$pdf->Image('fpdf/logo.png',10,6,30);
					$pdf->Image('fpdf/footer.png',10,6,200);
	 $pdf->SetY(-60);
    // Arial italic 8
    $pdf->SetFont('Arial','I',8);
    // Page number
    $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C'); */
	  $pdf->SetY(-50);
	  $pdf->Image('fpdf/footer.png',10,240,200);
    // Arial italic 8
    $pdf->SetFont('Arial','I',8);
    // Page number
   // $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');

	$pdf->Output();
}
else
{
	echo "There is no Record.";
}
?>