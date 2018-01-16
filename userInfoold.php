<?php
//error_reporting(0);
set_time_limit(0);
ob_start();
include("config.php");
include("device_status.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//include_once(__DOCUMENT_ROOT.'/sqlconnection.php');
$masterObj = new master();
//include($_SERVER["DOCUMENT_ROOT"]."/service/sqlconnection.php");
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branch_id=$_SESSION['branch_id'];
if(isset($_GET['action']) && $_GET['action']=='sim_add')
{	
		 $no_of_sim=$_GET['no_of_sim'];
		 $sim_no=$_GET['sim_no'];
		 $phone_no=$_GET['phone_no'];
		 $myCheckbox=$_GET['myCheckbox'];
		 $operater=$_GET['operater'];
	
		 $count=0;
		 $flag=0;
		 for($i=0;$i<$no_of_sim;$i++)
		 {
			for($j=$i+1;$j<$no_of_sim;$j++)
			{
				if(($sim_no[$i]==$sim_no[$j]) && (!empty($sim_no[$i]) || $sim_no[$i]!="")) 
				{
					$flag=1;
					break;
				}
				if(($phone_no[$i]==$phone_no[$j]) && (!empty($phone_no[$i]) || $phone_no[$i]!="")) 
				{
					$flag=2;
					break;
				}
				
			}
			if((empty($sim_no[$i]) || $sim_no[$i]=="") || (empty($phone_no[$i]) || $phone_no[$i]==""))
			{
				$flag=9;
				break;
			}
			
			
	   	}
		
		if($flag==0)	
		{
			for($i=0;$i<$no_of_sim;$i++)
			{
				if(!empty($sim_no[$i]) || $sim_no[$i]!="")
				{
					$checkSIM=$masterObj->getSim($sim_no[$i]);
					if($checkSIM!=0)
					{
						$flag=3;
						break;
					}
					else if(!(preg_match ("/^([0-9]+)$/", $sim_no[$i]))) 
					{
						$flag=4;
						break;
					}
				 	else if(strlen($sim_no[$i])!=19)
					{
						$flag=5;
						break;
					} 
					else
					{
					}
		
				}
				if(!empty($phone_no[$i]) || $phone_no[$i]!="")
				{
					$checkSIM=$masterObj->getPhone($phone_no[$i]);
					if($checkSIM>0)
					{
						$flag=6;
						break;
					}
					else if(!(preg_match ("/^([0-9]+)$/", $phone_no[$i]))) 
					{
						$flag=7;
						break;
					}
					else if(strlen($phone_no[$i])!=10)
					{
						
						$flag=8;
						break;
					}
					else
					{
						
					}
		
				}
			
			}
		}

		
		if($flag==1)
		{
			echo $errorSimNo="Insert Unique Sim in Each Row";
		}
		if($flag==2)
		{
			echo $errorSimNo="Insert Unique Phone in Each Row";
		}
		if($flag==3)
		{
			echo $errorSimNo="Sim Number Already Exist.";
		}
		if($flag==4)
		{
			echo $errorSimNo="Sim Number Should be Numeric.";
		}
		if($flag==5)
		{
			echo $errorSimNo="Sim Number Should be 19 digits.";
		}
		if($flag==6)
		{
			echo $errorSimNo="Phone Number Already Exist.";
		}
		if($flag==7)
		{
			echo $errorSimNo="Phone Number Should be Numeric .";
		}
		if($flag==8)
		{
			echo $errorSimNo="Phone Number Should be 10 digits.";
		}
		if($flag==9)
		{
			echo $errorSimNo="Map All Phone No. and Sim no.";
		}

		if($errorSimNo=="" )
		{
			for($i=0;$i<$no_of_sim;$i++)
			{
				 if(isset($myCheckbox[$i]))
				 {
					 $sim_status=1;
				 } 
				 else
				 {
					$sim_status=0;
				 } 
					$oprt= $operater[$i]; 
					$tt= select_Procedure("CALL InsertSim('".$sim_no[$i]."', '".$phone_no[$i]."', '".$oprt."','".$sim_status."')");
					if(count($tt)>0)
					{
						$flag=10;
					}
					else
					{
						$flag=11;
					}
			}
			if($flag==10)
			{
				echo "Mapping Successfully";
			}
			if($flag==11)
			{
				echo "There is some Problem in Mapping";
			}
		}
		
	
}

if(isset($_GET['action']) && $_GET['action']=='itgc_check')
{	
		//echo '<pre>'; print_r($_GET);'</pre>'; die;
   		//$check_gtrac = $_GET['gtrac']; 
	   $no_of_device=$_GET['no_of_device'];
	   $device_type = $_GET['device_type']; 
	   $model_type=$_GET['model_type'];
	   $recd_date=$_GET['date'];
	   
	   if($_GET['gtrac']=='gtrac_device')
	   {
	    $check_gtrac=0;
	   }
	   if($_GET['gtrac']=='crack_device')
	   {
	    $check_gtrac=1;
	   }
   //echo $check_gtrac; die;
			 
			$txtVisionTekId=$_GET['txtVisionTekId'];
			//print_r($txtVisionTekId); die;
			$serial_no=$_GET['serial_no'];
			if(empty($no_of_device) || $no_of_device=="")
			{
				echo $errNoDevice="Please Enter No.";
			}
			if($device_type==0)
			{
				echo $errdevice_type="Please Select Device Type.";
			}
			if($model_type==0)
			{
				echo $errmodel_type="Please Select Model Type.";
			}
			if(isset($_GET['username_client']))
			{
				$username_client = $_GET['username_client'];
			}
			else
			{
				$username_client="";
			}
			$count=0;
			$flag=0;
			//echo $no_of_device; die;
			//echo $txtVisionTekId[2]; die;
			for($i=0;$i<$no_of_device;$i++)
			{
				for($j=$i+1;$j<$no_of_device;$j++)
				{
					if(($txtVisionTekId[$i]==$txtVisionTekId[$j]) && (!empty($txtVisionTekId[$i]) || $txtVisionTekId[$i]!="")) 
					{
						//echo $txtVisionTekId[$i]; echo $txtVisionTekId[$j]; die;
						$flag=1;
						break;
					}
				}
				
			}
		
		
		if($flag==0)	
		{
			for($i=0;$i<$no_of_device;$i++)
			{
				//echo strlen($txtVisionTekId[$i]);
				
			 	
				 if(!empty($txtVisionTekId[$i]) || $txtVisionTekId[$i]!="")
				{
					//echo 'ss';
					$checkIMEI=$masterObj->checkSno($txtVisionTekId[$i]);
					if($checkIMEI>0)
					{
						$flag=2;
						break;
					}
					else if(!(preg_match ("/^([0-9]+)$/", $txtVisionTekId[$i]))) 
					{
						$flag=5;
						break;
					}
					else if(strlen($txtVisionTekId[$i])>16 || strlen($txtVisionTekId[$i])<1)
					{
						
						$flag=4;
						break;
					}
				}
				else if(empty($txtVisionTekId[$i]) || $txtVisionTekId[$i]=="")
				{
					//echo 'hh';
					// $count++;
					$flag=3;
					break;
				} 
				
				else
				{
					
				}
			}
		}

		//echo $count; die;
		if($flag==1)
		{
			echo $errorMsg="Enter the Unique IMEI in each Textbox";
		}
		else if($flag==2)
		{
			echo $errorMsg="IMEI Already Exist";
		}
		else if($flag==3)
		{
			//echo $count;die;
			echo $errorMsg="Please Insert All IMEI No.";
		}
		else if($flag==4)
		{
			//echo $count;die;
			echo $errorMsg="Please Insert IMEI No. from 1 to 16";			
		}
		else if($flag==5)
		{
			//echo $count;die;
			echo $errorMsg="Please Insert Numeric IMEI No.";
		}	
		else	
		{
			
		}		
			
			
		if($errorMsg=="" && $errNoDevice=="" && $errdevice_type=="" && $errmodel_type=="")
		{
			for ($i = 0; $i < $no_of_device; $i++) 
			{
				$device_sno=$txtVisionTekId[$i];
				$txtimei='';
				//echo 'tt'; die;
				//echo "CALL InsertDevice('".$device_sno."', '".$txtimei."', '".$model_type."','".$recd_date."','".$device_type."','".$check_gtrac."','".$username_client."')";die;
				$tt= select_Procedure("CALL InsertDevice('".$device_sno."', '".$txtimei."', '".$model_type."','".$recd_date."','".$device_type."','".$check_gtrac."','".$username_client."')");
				if(count($tt)>0)
				{
					$flag=10;
					
				}
				else
				{
					$flag=11;
				
				}
			}
			if($flag==10)
			{
				echo "Insert Successfully";
			}
			if($flag==11)
			{
				echo "There is some problem";
			}	
		}	
}
if(isset($_GET['action']) && $_GET['action']=='raw_device')
{	
			$parent_id = $_POST['parents_id']; 
			$no_of_device=$_POST['no_of_device'];
			$itgcId=select_Procedure("CALL GetItgcId('".$parent_id."')");
			$itgcId=$itgcId[0];
			echo $max=max($itgcId[0]);
			//  count($itgcId);
		/* 	echo '<pre>';
			print_r($itgcId);
			'</pre>'; die;   */
	
}
if(isset($_GET['action']) && $_GET['action']=='company_name')
{
	$user_id=$_GET['user_id'];
	$strCompany = db__select_matrix("select `group`.name as company from matrix.group_users left join matrix.`group` on group_users.sys_group_id=`group`.id where group_users.sys_user_id='".$user_id."' ");
	$strCompany=$strCompany[0];
	print_r($strCompany['company']);
}
if(isset($_GET['action']) && $_GET['action']=='imei_no')
{
	$arr=array();
	$veh_no=$_GET['veh_no']; 
	$str_imei = db__select_matrix("select imei from matrix.devices where id =(select sys_device_id from matrix.services where veh_reg='".$veh_no."'limit 1)");
	$str_imei=$str_imei[0];
	$str_itgc = db__select("select itgc_id from device where device_imei='".$str_imei['imei']."'");
	$str_itgc=$str_itgc[0];
	echo $str_imei['imei']."##".$str_itgc['itgc_id'];
}

if(isset($_GET['action']) && $_GET['action']=='recd_dead_device')
{
	 $deviceId=$_GET['deviceId'];
	 $remark=$_GET['remark'];
	 $recddate=date('Y-m-d H:i:s');
     $devicestatus=$DeadDeviceToClient; 
	$DeadDevice=select_Procedure("CALL DeadDevice('".$deviceId."','".$recddate."','".$devicestatus."','".$remarks."')");
	//print_r($strCompany['company']);
}

if(isset($_GET['action']) && $_GET['action']=='recd_replace_device')
{
	$deviceId=$_GET['deviceId'];
	$remark=$_GET['remark'];
	$recddate=date('Y-m-d H:i:s');
    $devicestatus=$Device_Replaced_By_Manufactured;
	$DeadDevice=select_Procedure("CALL DeadDevice('".$deviceId."','".$recddate."','".$devicestatus."','".$remarks."')");
	//print_r($strCompany['company']);
}

if(isset($_GET['action']) && $_GET['action']=='recd_repair_device')
{
	$deviceId=$_GET['deviceId'];
	$remark=$_GET['remark'];
	$recddate=date('Y-m-d H:i:s');
    $devicestatus=$SendToRepairCentreManufacture1;
	$DeadDevice=select_Procedure("CALL DeadDevice('".$deviceId."','".$recddate."','".$devicestatus."','".$remarks."')");
	//print_r($strCompany['company']);
}

if(isset($_GET['action']) && $_GET['action']=='active')
{
	//echo 'tt';
	  $sim_id=$_GET['sim_id'];
	  $status=$Sim_Recd;
	  $branchID=$_SESSION['branch_id'];
	$mode=1;
	$SimActivation=select_Procedure("CALL SimActivation('".$branchID."','".$sim_id."','".$status."','".$mode."')");	
	//print_r($SimActivation);
	//echo '<script language="text/javascript">alert("'.$sim_id.'" is Activated)</script>';
	echo $sim_id.' is Activated';
}
if(isset($_GET['action']) && $_GET['action']=='deactive')
{
	//echo 'xx';
	//die;
	 $condition="";
    $sim_id=$_GET['sim_id'];
	$dtsim=db__select("select * from sim where sim_id='".$sim_id."'");
	//print_r($dtsim);
	$phone_no=$dtsim[0]['phone_no'];
	//echo count($dtsim);
	//echo $phone_no; die;
	$dtphone=db__select_matrix("select * from matrix.mobile_simcards where mobile_no='".$phone_no."'");
	//print_r($dtphone);
    echo count($dtphone); 
     if(count($dtphone)>0)
	 {
		 echo "SIM is Attached With Vehicle/Device So Cannot deactivate it.";
			exit;
	 }
	 else
	 {
		 //echo 'tt'; die;
		$status=$Sim_Deactivation;
		$branchID=$_SESSION['branch_id'];
		$mode=2;
		$SimDeactivation=select_Procedure("CALL SimActivation('".$branchID."','".$sim_id."','".$status."','".$mode."')"); 
		//print_r($SimDeactivation);
		echo $sim_id.' is Deactivated';
	 } 
}
if(isset($_GET['action']) && $_GET['action']=='dead_assign_installer')
{
	   $device_id=$_GET['device_id'];
	   $DeadDeviceSendDate=date('Y-m-d H:i:s');
	   $status=$AssignDeadDevice;
	   $branchID=$_SESSION['branch_id'];
		$sendToclient=select_Procedure("CALL DeadDeviceSendToClient('".$device_id."','".$DeadDeviceSendDate."','".$status."','".$branchID."')");	
		echo 'Assign to Installer';
}

if(isset($_GET['action']) && $_GET['action']=='dead_dev_send_client')
{
	   $device_id=$_GET['device_id'];
	   $DeadDeviceSendDate=date('Y-m-d H:i:s');
	   $status=$DeadDeviceToClient;
	   $branchID=$_SESSION['branch_id'];
		$DeadDeviceAssignInstaller=select_Procedure("CALL DeadDeviceSendToClient('".$device_id."','".$DeadDeviceSendDate."','".$status."','".$branchID."')");	
		echo 'Dead Device Send To Client';
}

if(isset($_GET['action']) && $_GET['action']=='delhi_kept_client')
{
	   $device_id=$_GET['device_id'];
	    $DeadDeviceSendDate=date('Y-m-d H:i:s');
	   $status=$ArchievDeadList;
	   $branchID=$_SESSION['branch_id'];
		$delhiKept=select_Procedure("CALL DeadDeviceSendToClient('".$device_id."','".$DeadDeviceSendDate."','".$status."','".$branchID."')");	
		//print_r($DeadDeviceAssignInstaller);
		//echo '<script language="text/javascript">alert("'.$sim_id.'" is Activated)</script>';
		echo 'Delhi Kept At Client';
}


if(isset($_GET['action']) && $_GET['action']=='dead_assign_installer')
{
	   $device_id=$_GET['device_id'];
	   $DeadDeviceSendDate=date('Y-m-d H:i:s');
	   $status=$AssignDeadDevice;
	   $branchID=$_SESSION['branch_id'];
		$sendToclient=select_Procedure("CALL DeadDeviceSendToClient('".$device_id."','".$DeadDeviceSendDate."','".$status."','".$branchID."')");	
		echo 'Assign to Installer';
}

if(isset($_GET['action']) && $_GET['action']=='imei_check')
{
	$new_imei=$_GET['new_imei'];
	$checkIMEI=$masterObj->checkIMEI($new_imei);
	if($checkIMEI>0)
	{
		//echo  $new_imei."IMEI Already Exist.";
		echo  "IMEI Already Exist";
	}
}


if(isset($_GET['devid'])&& $_GET['action']=='rep_comment'){
 $device_id = $_POST['devid'];
  
    $getRepairComment=select_Procedure("CALL GetRepairComments('".$device_id."')");
    $getRepairComment=$getRepairComment[0];

    for($i=0;$i<count($getRepairComment);$i++){
        
	        $abc[$i] = array(
	            "device_id"  => $getRepairComment[$i]['device_id'],
	            "comment" => $getRepairComment[$i]['comment'],
	            "updatedBy" => $getRepairComment[$i]['updated_by'],
	            "updated_date" => $getRepairComment[$i]['updated_date'],
	        );
	       $s[$i]=$abc[$i]; 
	}
	echo json_encode($s);
}


/* if(isset($_GET['action']) && $_GET['action']=='monthly_sim_repair')
{
	 $start_date=date('Y-m-d',strtotime($_GET['start_date']));
	 $end_time=date('Y-m-d',strtotime($_GET['end_date']));
	//echo $_SESSION['branch_id']; die
	//echo $_SESSION['branch_id'];
	$SimMonthyRepair=select_Procedure("CALL SimMonthyRepair('".$_SESSION['branch_id']."','".$start_time."','".$end_time."')");
	$SimMonthyRepair=$SimMonthyRepair[0];
	$rowcount=count($SimMonthyRepair);
	echo '<pre>';print_r($SimMonthyRepair); echo '</pre>';die;
?>
	<table class="table table-bordered table-hover">
         
			  <thead>
				<tr>
				  <th>Serial No. </th>
				  <th> sim_no </th>
				  <th> phone_no </th>
				  <th> rec_date</th>
				  <th>dispatch_date</th>
				  <th> device_imei </th>
				  <th>branch_name</th>
				  <th> client_name </th>
				  <th> item_name </th>
				  <th>status</th>  
				</tr>
			  </thead>
			  <tbody>
				<?php 

				for($x=0;$x<$rowcount;$x++)
				{
					$y=$x+1;
				?>
				<tr>
				<td><?php echo $y;?></td>
				<td><?php echo $SimMonthyRepair[$x]['sim_no'];?></td>
				<td><?php echo $SimMonthyRepair[$x]['phone_no'];?></td>
				<td><?php echo date('d-m-Y H:i:s',strtotime($SimMonthyRepair[$x]['rec_date'])); ?></td>
				<td><?php echo date('d-m-Y H:i:s',strtotime($SimMonthyRepair[$x]['dispatch_date'])); ?></td>
				<td><?php echo $SimMonthyRepair[$x]['device_imei']; ?></td>
				<td><?php echo $SimMonthyRepair[$x]['branch_name']; ?></td>
				<td><?php echo $SimMonthyRepair[$x]['item_name'];?></td>
				<td><?php echo $SimMonthyRepair[$x]['status']; ?></td>
				<td><?php echo $SimMonthyRepair[$x]['is_cracked']; ?></td>
				<td><?php echo $SimMonthyRepair[$x]['is_repaired']; ?></td>
				<td><?php echo $SimMonthyRepair[$x]['is_ffc']; ?></td>
				<td><?php echo $SimMonthyRepair[$x]['is_permanent']; ?></td>
				</tr>
				<?php } ?>
			   
			  </tbody> 
			</table>
<?php
} */


/* if(isset($_GET['action']) && $_GET['action']=='monthly_sim_repair')
{
	  $start_date=date('Y-m-d',strtotime($_GET['start_date']));
	  $end_time=date('Y-m-d',strtotime($_GET['end_date']));
	 echo $branch_id=$_GET['branch_id']; 
	//echo $_SESSION['branch_id']; die
	//echo $_SESSION['branch_id'];
	 $SimMonthyRepair=select_Procedure("CALL SimMonthyRepair('".$branch_id."','".$start_time."','".$end_time."')");
	$SimMonthyRepair=$SimMonthyRepair[0]; 
	
	for($i=0;$i<count($SimMonthyRepair);$i++)
	{
        $abc[$i] = array(
            "simno"  => $SimMonthyRepair[$i]['sim_no'],
            "phoneno" => $SimMonthyRepair[$i]['phone_no'],
            "recdate" => $SimMonthyRepair[$i]['rec_date'],
            "dispatchdate" => $SimMonthyRepair[$i]['dispatch_date'],
            "deviceimei" => $SimMonthyRepair[$i]['device_imei'],
            "branchname" => $SimMonthyRepair[$i]['branch_name'],
            "clientname" => $SimMonthyRepair[$i]['client_name'],
            "itemname" => $SimMonthyRepair[$i]['item_name'],
            "status" => $SimMonthyRepair[$i]['status']
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
}	 */

/* if(isset($_GET['action']) && $_GET['action']=='dead_device_byDate')
{
	    $start_date1=date('Y-m-d',strtotime($_GET['start_date']));
	    $end_date1=date('Y-m-d',strtotime($_GET['end_date']));
		$SearchDeadDeviceDate=select_Procedure("CALL SearchDeadDeviceDate('".$start_date1."','".$end_date1."')");	
		$SearchDeadDeviceDate=$SearchDeadDeviceDate[0];
		$rowcount=count($SearchDeadDeviceDate);
		//echo '<pre>';print_r($SearchDeadDeviceDate); echo '</pre>'; die;
}?>
 <table class="table table-bordered table-hover">
         
          <thead>
            <tr>
              <th> Device Sno. </th>
              <th> Device IMEI </th>
              <th> Device Id</th>
              <th> Client Name </th>
			  <th> Veh No </th>
			  <th> Opencase Date </th>
              <th> Manufacture Name </th>
              <th> Manufacture Remarks </th>
			  <th> Send To Client</th>
              <th> Assign To Installer</th>
              <th> Delhi Kept at Delhi</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
		
			  <td><?php echo $SearchDeadDeviceDate[$x]['device_sno']; ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['device_imei']; ?></td>
              <td><?php echo $SearchDeadDeviceDate[$x]['device_id'];?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['client_name']; ?></td>
			  <?php
				
			 
			  ?>
			  <td><?php echo $SearchDeadDeviceDate[$x]['veh_no'];?></td>
			  <?php $dt=date('d-m-Y',strtotime($SearchDeadDeviceDate[$x]['opencase_date'])); 
			   if($dt=='01-01-1970' )
				  {
					  $dt='';
				  }
			  else
				  {
					   $dt=date('d-m-Y H:i:s',strtotime($SearchDeadDeviceDate[$x]['opencase_date']));
					}
				  ?>
			  <td><?php echo $dt ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['ManufactureName']; ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['ManufactureRemarks']; ?></td>
			    <td><a href="#" onclick="return send_client(<?php echo $SearchDeadDeviceDate[$x]["device_id"];?>);"><strong>Device Assign To Installer</strong></a></td>
			  <td><a href="#" onclick="return assign_installer(<?php echo $SearchDeadDeviceDate[$x]["device_id"];?>);"><strong>Device Assign To Installer</strong></a></td>
			   <td><a href="#" onclick="return delhi_kept_delhi(<?php echo $SearchDeadDeviceDate[$x]["device_id"];?>);"><strong>Delhi Kept At Client</strong></a></td>
		
			   
            </tr>
            <?php } ?>
     
          </tbody>
          </form> 
        </table> */





