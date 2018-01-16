<?php
include_once('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
//include_once(__DOCUMENT_ROOT.'/private/common.php');

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
$result=array();
if($_POST)
{
	$masterObj = new master();
	if(empty($_POST['uname']) || empty($_POST['password']))
	{
		//echo 'tt'; die;
		//echo "You did not fill out the Username and Password.";
		//header('location:login.php');
		$result["status"] = false;
		$result["message"]="Username and Password should be filled";	
	}
	else
	{
		$uname=addslashes($_POST['uname']);
		$password=addslashes($_POST['password']);		
		$dbselect = $masterObj->getUserData($uname,$password);		
		
		if(count($dbselect)>0)
		{
			//echo 'tt'; die;
			$uname=addslashes($_POST['uname']);
			$password=addslashes($_POST['password']);
			$installerid=addslashes($_POST['installerid']);
			$branchid=addslashes($_POST['branchid']);
					
			$dbselect = $masterObj->getLoginUserData($uname,$password,$installerid,$branchid);		
		
				if(count($dbselect)>0)
				{
					if($_SERVER['REQUEST_METHOD']=='POST')
					{
						//$service_id=$_POST['service_id'];
						 $close_status=$_POST['status'];
						 $inst_id=$_POST['installerid'];
						 $installation_id=$_POST['installationid'];
						 //$reason=$_POST['reason'];
						 $reason_details=$_POST['reason_details'];
						 //$change_imei=$_POST['change_imei'];
						  $imei=$_POST['imei'];
						 // $replace_with=$_POST['replace_with'];
						  $veh_no=$_POST['veh_no'];
						  $datacheck_string=$_POST['datacheck_string'];
						 $type=$_POST['type'];
						 
						 if($close_status==1)
						 {
							 $status=5;
							 
							if($type=='service')
							{
								 if($reason_details == "devicechanged")
								 {
									 $dbselect1 = $masterObj->updateDeviceChange($inst_id,$installation_id,$reason_details,$status,$close_status,$change_imei,$replace_with);
									 if($dbselect1>0)
									 {
										$result["status"] = true;
										$result["message"]="Success";
									 }
								 }
								 else
								 {
									 $dbselect1 = $masterObj->updateService($inst_id,$installation_id,$reason_details,$status,$close_status);	
									 
									 if($dbselect1>0)
									 {
										$result["status"] = true;
										$result["message"]="Success";
									 }
								 }
								 
							}
							
							if($type=='installation')
							{
								 $dbselect2 = $masterObj->updateInstallation($inst_id,$installation_id,$reason_details,$status,$close_status,$imei,$veh_no,$datacheck_string);
								
								 if($dbselect2>0)
								 {
								 	$total_row = mysql_query("SELECT COUNT(*) AS total_count FROM installation WHERE inst_req_id='".$installation_id."'");


       								$close_inst_row = mysql_query("SELECT COUNT(*) AS total_row FROM installation WHERE inst_req_id='".$installation_id."' AND installation_status IN ('5','6')");

       								$ss=mysql_query("UPDATE installer set status=0 where inst_id='".$inst_id."'");
       								$xx=mysql_query("UPDATE internalsoftware.installation set installation_status='".$inst_status."',failure_reason='".$reason_details."',close_date='".date("Y-m-d")."',inst_date='".date("Y-m-d")."' WHERE id='".$installation_id."'");


							        if($total_row[0]['total_count'] == $close_inst_row[0]['total_row'])
							        {
							            $tt=mysql_query("UPDATE installation_request SET close_date='".date("Y-m-d")."', installation_made='".$close_inst_row[0]['total_row']."',installation_status=5 WHERE id='".$installation_id."'");
							        }
										
										$result["status"] = true;
										$result["message"]="Success";
								 }
								 
							}
							
						}
						
						if($close_status==0)
						{
							 $status=18;
							 if($type=='service')
							 {
								 
								 $dbselect1 = $masterObj->updateService($inst_id,$installation_id,$reason_details,$status,$close_status);	
								 
								 if($dbselect1>0)
								 {
									$result["status"] = true;
									$result["message"]="Success";
								 }
								 
							}
							
							if($type=='installation')
							{
								 $dbselect2 = $masterObj->updateInstallation($inst_id,$installation_id,$reason_details,$status,$close_status);
								 
								 if($dbselect2>0)
								 {
									$result["status"] = true;
									$result["message"]="Success";
								 }
								 
							}
						}
					}
				}
				else
				{
					$result["status"] = false;
					$result["message"]="Username and Password Not Valid";
				}
		}
		else
		{
				$result["status"] = false;
				$result["message"]="Username and Password Not Valid";
		}
	
	}
	echo json_encode($result);
}
?>
