<?php
include_once('../config.php');
include_once(__DOCUMENT_ROOT.'/inventoryAPI/private/masterAPI.php');


if($_POST)
{
//print_r($_POST); die;
	$masterObj = new masterAPI();

	if(empty($_POST['deviceId']) || empty($_POST['InstallerID']) || empty($_POST['branchId']))
	{
	
		$result["status"] = false;
		$result["msg"]="Empty Feilds Not Allowed";
		
	}
	else
	{
	
		$deviceId=trim(addslashes($_POST['deviceId']));
		$installerId=trim(addslashes($_POST['InstallerID']));
		$branchId=trim(addslashes($_POST['branchId']));
		if(isset($deviceId) && isset($installerId))
		{
			//echo "updateAssignedDevice($deviceId,$installerId)"; die;
			$dbselect=$masterObj->updateAssignedDevice($deviceId,$installerId);	
			//print_r($dbselect); die;
		}

		if($dbselect) 
		{
			//$result["status"] = true;
			$result["msg"]='Device Received';
		}
		else
		{
			//$result["status"] = true;
			$result["msg"]='Device Already Received';
		}
	}	

	echo json_encode($result);
	
}
?>
