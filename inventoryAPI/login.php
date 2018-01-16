<?php
include_once('../config.php');
include_once(__DOCUMENT_ROOT.'/inventoryAPI/private/masterAPI.php');
 
$headers = apache_request_headers();

foreach ($headers as $header => $value) {
        if($header=="INSTALLERAPP")
        {
                $httpHeader=$value;
        }
 }
if($httpHeader!="MakeInGtrac")
{
        die();
}

if($_POST)
{
	$masterObj = new masterAPI();
	if(empty($_POST['uname']) || empty($_POST['password']))
	{
		//echo 'tt'; die;
		//echo "You did not fill out the Username and Password.";
		//header('location:login.php');
		$result["status"] = false;
		$result["userId"]="0";
		$result["branchid"]="0";
		$result["message"]="Username and Password should be filled";
		
	}
	else
	{
		$uname=addslashes($_POST['uname']);
		$password=addslashes($_POST['password']);
		$mobilekey  = addslashes($_POST['mobilekey']);
        $fromDevice = addslashes($_POST['fromDevice']);
				
		$dbselect = $masterObj->getUserData($uname,$password);		
		echo "<pre>";print_r($dbselect);die;
		
		if(count($dbselect)>0)
		{
			if($mobilekey != "") 
			{
                $MobileNum = $dbselect[0]["installer_mobile"];
				
				$checkKeyAlreadythere = $masterObj->GetKeyByMobile($MobileNum);
                
                if ($checkKeyAlreadythere[0]["mobilenumber"] != $MobileNum) {
                    
                    $insertData = db__select("insert into internalsoftware.mobilekey (inst_id, mobilenumber, AndroidKey, fromDevice) 
					value ('".$dbselect[0]["inst_id"]. "', '".$MobileNum. "', '".$mobilekey."', '".$fromDevice."')");
                    
                } else {
                    
                    $updateData = db__select("update internalsoftware.mobilekey set AndroidKey='".$mobilekey."',fromDevice='".$fromDevice."' where mobilenumber='".$MobileNum. "'");
                    
                }
				
            }
							
			$result["status"]=true;
			$result["userid"]=$dbselect[0]["inst_id"];
			$result["branchid"]=$dbselect[0]["branch_id"];
			$result["message"]="Username or password is correct";
			//print_r($dbselect);

		
		}
		else
		{
			$result["status"] = false;
			$result["userId"]="0";
			$result["branchid"]="0";
			$result["message"]="Username and Password Not Valid";
		}
	}
	
	echo json_encode($result);
	
}
?>
