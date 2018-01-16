<?php
ob_start();
//ini_set("session.auto_start", 0);
include("config.php");
require_once('/fpdf/fpdf.php');
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$masterObj = new master();
 //echo date('H:i:sa'); die;
 $login_name=$_SESSION['user_name_inv'];
// $data=array();
// $datas=array();
  $strChallanNo=$_GET['challanNo'];
	//echo $strChallanNo; die;
 //echo count($_GET); die;
//echo '<pre>';print_r($data);die;	
	    $GetSimChallanDetailByNo=$masterObj->GetSimChallanDetailByNo($strChallanNo);  
		$count=count($GetSimChallanDetailByNo);
		//echo '<pre>';print_r($GetSimChallanDetailByNo); '<pre>';	die;
if($count>0)
{
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
					  $pdf->cell(50,6,'Dispatch Address :',0);
					 $pdf->cell(50,6,$GetSimChallanDetailByNo[$i]['branch_name'],0);
					  $pdf->cell(50,6,'Delivered By:',0);
					  $pdf->cell(50,6,$login_name,0);
			 
					
						// Column headings
						$header = array('S.no', 'Operator', 'Phone No');
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
						$w = array(20,80,80);
								//print_r($w); die;
					
					for($j=0;$j<count($header);$j++)
					$pdf->Cell($w[$j],7,$header[$j],1,0,'C',true);
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
					$pdf->Cell($w[1],6,$GetSimChallanDetailByNo[$j]['operator'],'LR',0,'C',$fill);
					$pdf->Cell($w[2],6,$GetSimChallanDetailByNo[$j]['phone_no'],'LR',0,'C',$fill);
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