<?php
ob_start();
//ini_set("session.auto_start", 0);
include("config.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
require_once('/fpdf/fpdf.php');

$masterObj = new master();
 $login_name=$_SESSION['user_name_inv'];
  $strChallanNo=$_GET['challanNo'];
    $dispatch_send=$_GET['dispatch_send'];

	    $GetChallanDetailByNo=$masterObj->GetChallanDetailByNo($strChallanNo);  
		$count=count($GetChallanDetailByNo);
		//echo '<pre>';print_r($GetChallanDetailByNo); '<pre>';	  
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
				 $pdf->cell(50,6,$dispatch_send,0);
				  $pdf->cell(50,6,'Delivered By:',0);
				  $pdf->cell(50,6,$login_name,0);
				  

					// Column headings
					$header = array('S.no', 'ITGC ID', 'IMEI', 'Device Type', 'Antenna', 'Immoblizer Type', 'Immoblizer', 'Connector'	);
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
					$w = array(10,30,40,30,20,25,20,20);
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
					$pdf->Cell($w[1],6,$GetChallanDetailByNo[$j]['itgc_id'],'LR',0,'C',$fill);
					$pdf->Cell($w[2],6,$GetChallanDetailByNo[$j]['device_imei'],'LR',0,'C',$fill);
					$pdf->Cell($w[3],6,$GetChallanDetailByNo[$j]['DeviceType'],'LR',0,'C',$fill);
					$pdf->Cell($w[4],6,$GetChallanDetailByNo[$j]['DispatchAntennaCount'],'LR',0,'C',$fill);
					$pdf->Cell($w[5],6,$GetChallanDetailByNo[$j]['DispatchImmobilizerType'],'LR',0,'C',$fill);
					$pdf->Cell($w[6],6,$GetChallanDetailByNo[$j]['DispatchImmobilizerCount'],'LR',0,'C',$fill);
					$pdf->Cell($w[7],6,$GetChallanDetailByNo[$j]['DispatchConnectorCount'],'LR',0,'C',$fill);
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
		echo "There is some problem";
	}
	
?>