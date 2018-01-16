<?php
include("device_status.php");
include("config.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$branch_id=$_SESSION['branch_id'];
if(isset($_GET['action']) && $_GET['action']=='repaired')
{
		//print_r($_GET); die;
		$ChallanMode=$Installer;
		$RemovedDeviceRecdDate=date('Y-m-d H:i:s');
		$DeviceStatus=$InternalBranchRepaired;
		$Remarks=$_GET['remarks'];
		$device_id=$_GET['device_id'];
	 
		$condition="";
		$delhiKept=select_Procedure("CALL InternalBranchRepaired('".$device_id."','".$RemovedDeviceRecdDate."','".$Remarks."','".$DeviceStatus."','".$branch_id."')");	
		echo "Device has been repaired.You can assigned it to installer now.";
	
}

if(isset($_GET['action']) && $_GET['action']=='send_to_rep_centre')
{
	//print_r($_GET); die;
		$ChallanMode=$Dispatch;
		
					if ($ChallanMode == 1)
					{
						$strChallanMode = "DispatchChallanNo";
					}
					else if ($ChallanMode == 3)
					{
						$strChallanMode = "SimDispatchChallanNo";
					}
					else
					{
						$strChallanMode = "InstallerChallanNo";
					}
					//echo $strChallanMode;
					 $strCH = "CHNO";
					$strSqlQuery =$masterObj->selectChallanNo($strChallanMode);
					//	echo '<pre>';print_r($strSqlQuery); '</pre>';
					//echo count($strSqlQuery);
					if (count($strSqlQuery)> 0)
					{
						 $strResult = ($strSqlQuery[0]['Id'] + 1);
					}
					//echo $strResult; die;
					 $strChallanNo=$strCH.$strResult; 
					
					 $RemovedDeviceRecdDate=date('Y-m-d H:i:s');
					 $Remarks=$_GET['remarks'];
					 $deviceId=$_GET['device_id'];
					 $imei=$_GET['imei'];
					 $antena=$_GET['antena'];
					 $immob=$_GET['immob'];
					 $immob_type=$_GET['immob_type'];
					 $connector=$_GET['connector']; 
					if($branch_id==1)
					{
						  $devicestatus=$SendToRepairCentre; 
					}
					else
					{
					 	 $devicestatus=$SendToRepair_ByBranch;
					}
					$condition="";
					//echo "CALL SendToRepairedCentreDevice('".$deviceId."','".$RemovedDeviceRecdDate."','".$Remarks."','".$devicestatus."','".$branch_id."','".$RemovedDeviceRecdDate."')";
					//die;
					$dt=date('Y-m-d H:i:s');
					$delhiKept=select_Procedure("CALL SendToRepairedCentreDevice('".$deviceId."','".$RemovedDeviceRecdDate."','".$Remarks."','".$devicestatus."','".$branch_id."')");	
					//echo "Device has been repaired.You can assigned it to installer now.";
					$updateChallanDetails=$masterObj->updateChallanDetails($deviceId); 
					$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$deviceId,$antena,$immob_type,$immob,$connector,$branch_id,$dt); 
					$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
					echo $strChallanNo;

						 
}

?>