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
	$data=array();
	if(empty($_POST['uname']) || empty($_POST['password']) || empty($_POST['installerid']) || empty($_POST['branchid']))
	{
		$arr=array(
								'device_id' => 0,
								'device_imei' => 0,
								'device_type' =>0,
								'device_source' => 0,
								'client_name' => 0,
								'itgc_id' => 0,
								'installerid' => 0,		
								'model' => 0,	
								'brand' => 0,									
								'status' => false,
								'message' => "Username and Password should be filled",
					);
					array_push($data,$arr);	
	}
	else
	{
		$uname=addslashes($_POST['uname']);
		$password=addslashes($_POST['password']);
		$installerid=addslashes($_POST['installerid']);
		$branchid=addslashes($_POST['branchid']);
				
		$dbselect = $masterObj->getLoginUserData($uname,$password,$installerid,$branchid);		
		if(count($dbselect)>0)
		{
		
			$stockData = $masterObj->getStockData($installerid,$branchid);
			//echo count($stockData); die;
			if(count($stockData)>0)
			{ 
				for($s=0;$s<count($stockData);$s++)
				{
					$model_id=$stockData[$s]["parent_id"];
					$stockBrand = $masterObj->getStockModel($model_id);

					if(($stockData[$s]["TranferInstallerId"]) == "" || ($stockData[$s]["TranferInstallerId"] == 'NULL'))
					{
						$transferInstId = $stockData[$s]["installerid"];
					}
					else{
						$transferInstId = $stockData[$s]["TranferInstallerId"];
					}
					$arr=array(
								'device_id' => $stockData[$s]["device_id"],
								'device_imei' => $stockData[$s]["device_imei"],
								'device_type' => $stockData[$s]["is_repaired"],
								'device_source' => $stockData[$s]["is_cracked"],
								'client_name' => $stockData[$s]["client_name"],
								'itgc_id' => $stockData[$s]["itgc_id"],
								'installerid' => $stockData[$s]["installerid"],		
								'model' => $stockData[$s]["item_name"],	
								'brand' => $stockBrand[0]["item_name"],									
								'status' => True,
								'message' => "Data Found",
								'transferInstId' => $transferInstId,
								'confirmStatus' =>	$stockData[$s]["ConfirmStatus"],
													
								) ;
						array_push($data,$arr);	
				}
			}
			else
			{
				$arr=array(
								'device_id' => 0,
								'device_imei' => 0,
								'device_type' =>0,
								'device_source' => 0,
								'client_name' => 0,
								'itgc_id' => 0,
								'installerid' => 0,		
								'model' => 0,	
								'brand' => 0,									
								'status' => false,
								'message' => "Not Applicable",
								'transferInstId' => "NULL",	
				);
				array_push($data,$arr);	
			}
		}
		else
		{ 
			$arr=array(
								'device_id' => 0,
								'device_imei' => 0,
								'device_type' =>0,
								'device_source' => 0,
								'client_name' => 0,
								'itgc_id' => 0,
								'installerid' => 0,		
								'model' => 0,	
								'brand' => 0,									
								'status' => false,
								'message' => "Username and Password Not Valid",
								'transferInstId' => "NULL",
					);
					array_push($data,$arr);	
		}
	}
	echo json_encode($data);
}
?>
