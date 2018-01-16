<?php
ob_start();
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$masterObj = new master();
$itgc_id='11457X1068630';
//$itgc_id=$_GET['ItgcID'];
	//$selectChallanDetails=$masterObj->selectChallanDetails($strChallanNo);
//$selectItgcId=
	$SearchItgcId=select_Procedure("CALL SearchItgcId('".$itgc_id."')");
		$SearchItgcId=$SearchItgcId[0];
		//echo count($SearchItgcId); die;
	//echo '<pre>'; print_r($SearchItgcId[0]); '</pre>';die;
	for($i=0;$i<count($SearchItgcId);$i++)
	{
		echo "<phone_no>".$SearchItgcId[$i]."</phone_no>";
		echo "<phone_no>".$device_imei[$i]."</phone_no>";
	}

?>
