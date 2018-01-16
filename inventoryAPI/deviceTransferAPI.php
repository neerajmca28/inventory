<?php
include_once('../config.php');
include_once(__DOCUMENT_ROOT.'/inventoryAPI/private/masterAPI.php');


if($_POST)
{
	//print_r($_POST);die;
	$masterObj = new masterAPI();
	$branchId=$_SESSION['branch_id'];
	if(empty($_POST['deviceId']) || empty($_POST['InstallerID']) || empty($_POST['TranferInstallerId']) || empty($_POST['branchId']))
	{
	
		$result["status"] = false;
		$result["msg"]="Empty Feilds Not Allowed";
		
	}
	else
	{
		$deviceId=addslashes($_POST['deviceId']);
		$installerId=addslashes($_POST['InstallerID']);
		$TranferInstallerId=addslashes($_POST['TranferInstallerId']);
		 
		$installerList=db__select_staging("select * from internalsoftware.installer where branch_id='".$_POST['branchId']."' and is_delete=1");
		 $installerName=$installerList[0]['inst_name']; 
		$branchId=addslashes($_POST['branchId']);
		//echo "getTransferStockData($deviceId,$TranferInstallerId)"; die;
		$dbselect = $masterObj->getTransferStockData($deviceId,$TranferInstallerId,$installerId);
		//$dbselect2 = $masterObj->getTransferStockData($deviceId,$installerId);
		//print_r($dbselect);die;

		if($dbselect[0]['ConfirmStatus'] == '1')
		{
			if($dbselect[0]['CurrentRecord'] == '1')
			{				
				if(isset($deviceId) && isset($installerId))
				{
					$transferRecord=$masterObj->updateOlderInstaller($deviceId,$installerId,$TranferInstallerId);
					//print_r($transferRecord);die;
					if($transferRecord==1) 
					{


						function send_notification($tokens,$message,$androidkey)
						{
						    $url = 'https://fcm.googleapis.com/fcm/send';
						    $fields = array(
						    'registration_ids' => $tokens,
						    'data' => $message
						    );
						    $headers = array(
						    'Authorization:key = '.$androidkey,
						    'Content-Type: application/json'
						    );   
							    $ch = curl_init();
							       curl_setopt($ch, CURLOPT_URL, $url);
							       curl_setopt($ch, CURLOPT_POST, true);
							       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
							       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));	
							       $result = curl_exec($ch);           
					       if ($result === FALSE)
					       {
					           die('Curl failed: ' . curl_error($ch));
					       }
					       curl_close($ch);
					       //print_r($result);die;
					       return $result;
						}

					$imei=substr($dataImei,0,strlen($dataImei)-1);
					//echo $imei; die;
					$countDevice=explode('_',$imei);
					$countDevice=count($countDevice);
					//echo "select * from internalsoftware.mobilekey where inst_id='".$Installer_id."'";die;
					$token_get = db__select_staging("select * from internalsoftware.mobilekey where inst_id='".$TranferInstallerId."' ");
					//print_r($token_get); die;
				    if(count($token_get)>0)
				    {
				         $tokens[] = $token_get[0]['AndroidKey'];
				         //echo $imei;die;
				      	 //echo "You Assigned ".$countDevice." Devices"; die;
				       	 // echo $branchId; die;
				         //$branchId=1;
				        $Notificato_msg = array("title" => "Device Addition Request", "subtitle" => "You have been Assigned ".$countDevice." Devices From ".$installerName, "installelrid" => $TranferInstallerId,"installelrid2" => "blank", "installelrName" => "tarun","installelrName2" => "neeraj","branchid" => $branchId,"branchid2" => "blank", "imei" => $imei, "Msg" => "one");
				         // print_r($Notificato_msg); die;
				        $androidkey = "AIzaSyD9pinPICJTK7ibz_5U69QgZVCyjvGa0DU";
				       // print_r($Notificato_msg); die;
				        $message_status = send_notification($tokens,$Notificato_msg,$androidkey);
				    
				    } 

						$result["status"] = true;
						$result["msg"]='Device Received';	

					}
				}
				 
			}
			else
			{
				$result["status"] = true;
				$result["msg"]='Device Already Received';	
			}	
		}
		else
		{
			$result["status"] = false;
			$result["msg"]='Installer Confirmation Pending';		
		}
	}	
		
	echo json_encode($result);
	
}
?>
