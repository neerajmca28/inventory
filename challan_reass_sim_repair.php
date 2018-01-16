<?php
ob_start();
include("config.php");
require_once('/fpdf/fpdf.php');
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//ini_set("session.auto_start", 0);
$masterObj = new master();  

$login_name=$_SESSION['user_name_inv'];
$strChallanNo=$_GET['challanNo'];
$from_repair=$_GET['from_repair'];
$to_repair=$_GET['to_repair'];
$GetSimInstallerChallanDetailByNo=$masterObj->GetSimInstallerChallanDetailByNo($strChallanNo);  
$count=count($GetSimInstallerChallanDetailByNo);
//echo count($_GET); die;
//echo '<pre>';print_r($GetSimInstallerChallanDetailByNo);die;	
if($count>0)
{
					
				 	 if($GetSimInstallerChallanDetailByNo[0]['RepairName']=="-1")
					{
						$flag=3;
						$to_repair="Stock";
					}
					/* else
					{
						$flag=4;
						$repairName=$GetSimInstallerChallanDetailByNo[$j]['RepairName'];
					} */
					 
					$pdf=new FPDF();
					$pdf->AddPage();
					$pdf->SetFont('Arial','',10);
					$pdf->Image('fpdf/header.png',10,6,200);
					//  $pdf->cell(18,10,'',0);
					  
					  $pdf->ln(8);
					  $pdf->cell(180,10,'Challan NO:'.$strChallanNo.'',0,6,'R');
					  $pdf->cell(180,10,'Date:'.date('d-m-Y').'',0,6,'R');
					  $pdf->cell(180,10,'Time:'.date("H:i:s").'',0,6,'R');
					   
					  $pdf->ln(70);
					  $pdf->SetFont('Arial','B',11);
					  $pdf->cell(70,8,'',0);
					  $pdf->cell(100,8,'Re-Assign Challan',0);
							   
					  
					  $pdf->ln(15);
					  $pdf->SetFont('Arial','',11);
					    $pdf->cell(50,6,'Repair Name/Stock :',0);
						  $pdf->cell(50,6,$to_repair,0);
					  /* if($flag==1)
					  {
						  $pdf->cell(50,6,'Installer Name:',0);
						  $pdf->cell(50,6,$Installer_name_to,0);
					  }
					  if($flag==2)
					  {
						  $pdf->cell(50,6,'Devices Status :',0);
						  $pdf->cell(50,6,'Dead',0);
						  
					  }
					  if($flag==3)
					  {
						  $pdf->cell(50,6,'Repair Name/Stock:',0);
						  $pdf->cell(50,6,'Stock',0);
					  }
					  if($flag==4)
					  {
						  $pdf->cell(50,6,'Repair Name/Stock :',0);
						  $pdf->cell(50,6,$repairName,0);
					  } */
					  
					  
					  $pdf->cell(50,6,'Delivered By:',0);
					  $pdf->cell(50,6,$login_name,0);
					  
					  $pdf->ln(17);
					  $pdf->SetFont('Arial','',11);
					  $pdf->cell(50,6,'Reassign From :',0);
					  $pdf->cell(50,6,$from_repair,0);
					  
			
				 
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
					for($i=0;$i<count($header);$i++)
					$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
					$pdf->Ln();
					$pdf->SetFont('');
					// Data
					$fill = false;
			for($j=0;$j<$count;$j++)
				{
					$y=$j+1;
					$pdf->Cell($w[0],6,$y,'LR',0,'C',$fill);
					$pdf->Cell($w[1],6,$GetSimInstallerChallanDetailByNo[$j]['operator'],'LR',0,'C',$fill);
					$pdf->Cell($w[2],6,$GetSimInstallerChallanDetailByNo[$j]['phone_no'],'LR',0,'C',$fill);
	
			
					$pdf->Ln();
					$fill = !$fill;
				}
			$pdf->Cell(array_sum($w),0,'','T');

		  $pdf->SetY(-50);
		  $pdf->Image('fpdf/footer.png',10,240,200);
		$pdf->SetFont('Arial','I',8);
	   	$pdf->Output();
}
else
{
	echo "There is no Record.";
}




?>