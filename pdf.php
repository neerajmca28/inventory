<?php
ob_start();
//ini_set("session.auto_start", 0);
require_once('/fpdf/fpdf.php');
 //echo date('H:i:sa'); die;
 $data=array();
 $datas=array();
 $data=$_GET;
 //echo count($_GET); die;
//echo '<pre>';print_r($data);die;	  
 
	  $arr=array (
				'sno'=>$data['sno'],
				'devic_id' =>$data['devic_id'],
				'itgc_id'=> $data['itgc_id'],
				'imei_no' => $data['imei_no'],
				'disp_branch'=>$data['disp_branch'],
			
				) ;
				array_push($datas,$arr);
  
		 // echo '<pre>';print_r($datas);die;	  
				$pdf=new FPDF();
				 $pdf->AddPage();
				  $pdf->SetFont('Arial','',10);
			
					//$pdf->Image('fpdf/footer.png',10,6,200);
				//  $pdf->cell(18,10,'',0);
				  
				   $pdf->ln(4);
				  $pdf->SetFont('Arial','',9);
				  $pdf->cell(150,10,'Date:'.date('d-m-Y').'',0);
				  
				    $pdf->ln(15);
					  $pdf->SetFont('Arial','',9);
				   $pdf->cell(50,11,'Time:'.date("H:i:s a").'',0);
				   
				  $pdf->ln(40);
				  $pdf->SetFont('Arial','B',11);
				  $pdf->cell(70,8,'',0);
				  $pdf->cell(100,8,'Re-Assign Challan',0);
				  		   
				  $pdf->ln(10);
				  $pdf->SetFont('Arial','',11);
				  $pdf->cell(50,6,'Dispatch Address:',0);
				  $pdf->cell(50,6,'ReAssign From:',0);
			 
			
				  // Column headings
				$header = array('S.no', 'ITGC ID', 'IMEI', 'Device Type');
				$pdf->SetFont('Arial','',14);
				//print_r($header); die;

	
		// Colors, line width and bold font
		$pdf->SetFillColor(255,0,0);
		$pdf->SetTextColor(255);
		$pdf->SetDrawColor(128,0,0);
		$pdf->SetLineWidth(.3);
		$pdf->SetFont('','B');
		$pdf->Ln(50);
		// Header
		$w = array(10,40, 60, 80);
				//print_r($w); die;
				
		for($i=0;$i<count($header);$i++)
			$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$pdf->Ln();
		// Color and font restoration
		$pdf->SetFillColor(224,235,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('');
		// Data
		$fill = false;
		
		foreach($datas as $row)
		{
			//print_r($data); 
			$pdf->Cell($w[0],6,number_format($row['sno']),'LR',0,'C',$fill);
			$pdf->Cell($w[1],6,number_format($row['devic_id']),'LR',0,'C',$fill);
			$pdf->Cell($w[2],6,number_format($row['itgc_id']),'LR',0,'C',$fill);
			$pdf->Cell($w[3],6,number_format($row['imei_no']),'LR',0,'C',$fill);
			$pdf->Ln();
			$fill = !$fill;
		}
		// Closing line
	    $pdf->Cell(array_sum($w),0,'','T');
		//footer
				 $pdf->AddPage();
				  $pdf->SetFont('Arial','',10);
				 // $pdf->Image('logo.png',10,6,30);
					//$pdf->Image('fpdf/logo.png',10,6,30);
					$pdf->Image('fpdf/footer.png',10,6,200);
	 $pdf->SetY(-60);
    // Arial italic 8
    $pdf->SetFont('Arial','I',8);
    // Page number
    $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
	$pdf->Output();
?>