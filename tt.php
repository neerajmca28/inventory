<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
$branchId=$_SESSION['branch_id'];
$login_name= $_SESSION['user_name_inv'];	
$masterObj = new master();
//$branchId=2;
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$notif_count=0;
$SelectRecdDispatchedDevices=select_Procedure("CALL SelectRecdDispatchedDevices('".$branchId."')");
$SelectRecdDispatchedDevices=$SelectRecdDispatchedDevices[0];
/*  echo "<pre>";
print_r($SelectRecdDispatchedDevices); 
"</pre>";die; */  
$rowcount=count($SelectRecdDispatchedDevices); 
$installerList=db__select_staging("select * from installer where branch_id='".$_SESSION['branch_id']."' and is_delete=1");
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0];
//$strBranchID=$_SESSION['branch_id'];
if (isset($_POST['submit']))
{
	$strResult='';
	
	$challan_mode=$Installer;
	 if ($challan_mode == 1)
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
	
	    $strCH = "CHNO";
	   $strSqlQuery =$masterObj->selectChallanNo($strChallanMode);
	   if(count($strSqlQuery)>0)
	   {
		   $strResult=$strSqlQuery[0]['Id']+1;
	   }
	   $strChallanNo=$strCH.$strResult; 
	   if($branchId==1)
	   {
			if($_POST['radio_value']=='by_sendrepDelhi')
			{
				for($i=0;$i<$rowcount;$i++)
				{
				   if(isset($_POST['rowVal'][$i]))
				   {
						$remark=$_POST['remark'][$i];
						$data=explode('##',$_POST['rowVal'][$i]);
						$DeviceId=$data[0];
						$itgc_id=$data[1];
						$device_imei=$data[2];
						$antena=$data[3];
						$immob_type=$data[4];
						$immob_count=$data[5];
						$connectors=$data[6];
						$item_id=$data[7];
						$st1=$data[8];
						$selectDeviceType=$masterObj->selectDeviceType($item_id);
						//echo "<pre>";print_r($selectDeviceType[0]['item_name']); die;
						$device_type=$selectDeviceType[0]['item_name'];
						$l1=$_SESSION['branch_id'];
						if($l1!=1)
						{
							if ($st1 == 64 || $st1 == 82)
							{
								$DeviceStatus=$SendToRepair_ByBranch;

							}
							else
							{
								$DeviceStatus=$SendToRepair_ByBranch;
							}
						}
						else
						{
							if ($st1 == 64 || $st1 == 82)
							{
								 $DeviceStatus = $DeviceRemoved;
							}
							else
							{
								 $DeviceStatus = $DeviceRemoved;
							}
						}	
						$device_Removed_Date=date('Y-m-d H:i:s');
						$dispatchBranch=1;
						$branchIds=1;
						$Is_Branch_Recevied=$branchId;
						$InstallerID=$_POST['installer_list'];
						$deviceRemoveBranch=$branchId;
						$deviceRemoveProblem = "device removed(At time of Stock Received By branch)";
						$AssignedToBranch_Repair=select_Procedure("CALL AssignedToBranch_Repair('".$DeviceId."','".$DeviceStatus."','".$remark."','".$dispatchBranch."','".$Is_Branch_Recevied."','".$device_Removed_Date."','".$deviceRemoveProblem."')");
						$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
						$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$branchIds,$device_Removed_Date); 
										
						
				   } 
			   }
			   $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
						//header("location:challan_send_toRepair.php?challanNo=".$strChallanNo);	
						echo "<script type='text/javascript'>   
						window.open('challan_send_toRepair.php?challanNo=$strChallanNo');
						</script>";	
						?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?	
			}
			else if($_POST['radio_value']=='by_installer')
			{
			   if($_POST['installer_list']==0)
				{
					 $errorMsg='Please Select Installer Name';
					 echo "<script type='text/javascript'>alert('$errorMsg');</script>";
					 
				}
			   else
				{
					for($i=0;$i<$rowcount;$i++)
					{
						if(isset($_POST['rowVal'][$i]))
						   {
							   $notif_count=$i+1;
								$remark=$_POST['remark'][$i];
								$data=explode('##',$_POST['rowVal'][$i]);
								//print_r($data);die;
								$DeviceId=$data[0];
								$itgc_id=$data[1];
								$device_imei=$data[2];
								$antena=$data[3];
								$immob_type=$data[4];
								$immob_count=$data[5];
								$connectors=$data[6];
								$item_id=$data[7];
								$st1=$data[8];
								//$selectDeviceType=$masterObj->selectDeviceType($item_id);
								//echo "<pre>";print_r($selectDeviceType[0]['item_name']); die;
								//$device_type=$selectDeviceType[0]['item_name'];
								$l1=$_SESSION['branch_id'];
								//$BranchID=$_SESSION['session_id'];
								$Installer_id=$_POST['installer_list'];
								$selectInstallerName=$masterObj->selectInstallerName($Installer_id);
								$Installer_name=$selectInstallerName[0]['inst_name']; 
								$installer_mobile=$selectInstallerName[0]['installer_mobile']; 
								if ($st1 == 64 || $st1 == 82)
								{
									 $DeviceStatus=$AssignToInstaller;
								}
								else
								{
									 $DeviceStatus=$AssignToInstaller;
								}
								//echo $branchId;
								//die;
								//echo $DeviceStatus;
								$Insaller_AssignDate=date('Y-m-d H:i:s');
								$dispatchBranch=1;
								$Is_Branch_Recevied=$strBranchID;
								//$AssignedDevicesToInstaller=select_Procedure("CALL AssignedDevicesToInstaller('".$DeviceId."','".$DeviceStatus."','".$remark."','".$Installer_name."','".$branchId."')");
								$selectChallanDetails=$masterObj->selectChallanDetails($strChallanNo);
								//echo '<pre>';print_r($selectChallanDetails);die;
								//echo count($selectChallanDetails);die;
								if(count($selectChallanDetails)<1)
								{
									//echo 'tt';
									//echo $installer_id; die;
									$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$Installer_id,$branchId,$Insaller_AssignDate);
								}
								else
								{
									//echo $installer_id; die;
									if(count($selectChallanDetails)>0)
									{
										if($selectChallanDetails[0]["ChallanNo"] != "")
										{
											$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
											$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$Installer_id,$branchId,$Insaller_AssignDate);
											
										}
										else
										{
											$updateChallanDetailsNotChallanNoExist=$masterObj->updateChallanDetailsNotChallanNoExist($strChallanNo,$antena,$immob_type,$immob_count,$connectors,$Installer_id,$DeviceId); 
										}
										if($Installer_id == -1)
										{
											$updateNewDeviceRequest=$masterObj->updateNewDeviceRequest($DeviceId,$selectChallanDetails[0]["BranchID"]); 
												
										}
									}	
								}
							
							
							 //header( "Location:challan_assign_device_installer.php?challanNo=".$strChallanNo );
							// echo $strChallanNo;
							// echo $Installer_name; die;
						
							// $params = http_build_query(array('challanNo' => $strChallanNo, 'to_installer' => $Installer_name, 'dev_imei' => $device_imei,'antena' => $antena,'immob_type' => $immob_type, 'immob_count' => $immob_count, 'connectors' => $connectors));
							 //header( "Location: " . $playerurl . "?" . $params);
						
							
						 
							/* $redirect = "challan_assign_device_installer.php?".http_build_query($arr);
							header( "Location: $redirect" ); */
						  }
					}
					 $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
					
					echo "<script type='text/javascript'>   
					window.open('challan_assign_device_installer.php?challanNo=$strChallanNo&to_installer=$Installer_name');
					</script>";
					?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?
				}
			}
			else if($_POST['radio_value']=='by_branch')
			 {
				 if($_POST['branch_list']==0)
				  {
					   $errorMsg='Please Select Branch';
					   echo "<script type='text/javascript'>alert('$errorMsg');</script>";
				  }
				  else
				  {
					  for($i=0;$i<$rowcount;$i++)
						{
							if(isset($_POST['rowVal'][$i]))
							{
					 
								$data=explode('##',$_POST['rowVal'][$i]);
								//print_r($data);die;
								$DeviceId=$data[0];
								$itgc_id=$data[1];
								$device_imei=$data[2];
								$antena=$data[3];
								$immob_type=$data[4];
								$immob_count=$data[5];
								$connectors=$data[6];
								$item_id=$data[7];
								$st1=$data[8];
								$remark=$_POST['remark'][$i];
								//$st1=$status;
								//$l1=$_SESSION['session_id'];
								//$BranchID=$_SESSION['session_id'];
								//$Installer_name=$_POST['installer_list'];
								if ($st1 == 64 || $st1 == 82)
								{
									if($_POST['branch_list']==2)
									{
										$DeviceStatus=$FinalAttachSim;
									}
									else
									{
										$DeviceStatus=$OutOfStock;
									}
									
								}
								else
								{
									if($_POST['branch_list']==1)
									{
										$DeviceStatus=$FinalAttachSim;
									}
									else
									{
										$DeviceStatus=$OutOfStock;
									}
									
								}

								$branch_send_date=date('Y-m-d H:i:s');
								$dispatchBranch_id=$_POST['branch_list'];
								$selectDispatchBranch =$masterObj->selectDispatchBranch($dispatchBranch_id);
								$dispatch_branch=$selectDispatchBranch[0]['branch_name'];
								$Is_Branch_Recevie=$branchId;
								$AssignedToBranch_Repair=select_Procedure("CALL AssignedDevicesToInstaller_branch('".$DeviceId."','".$DeviceStatus."','".$remark."','".$Is_Branch_Recevie."','".$dispatchBranch_id."','".$branch_send_date."')"); 
								$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
								$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$dispatchBranch_id,$branch_send_date); 
								
							  }
						 }
						 $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
								//header("location:challan_assign_device_branch.php?challanNo=".$strChallanNo);
								/* $redirect = "challan_assign_device_installer.php?".http_build_query($arr);
								header( "Location: $redirect" ); */
								echo "<script type='text/javascript'>   
								window.open('challan_assign_device_branch.php?challanNo=$strChallanNo&branch_name=$dispatch_branch');
								</script>";

								?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?
				  }
				 
			   }
			   else
			   {
				   $errorMsg="Please select either Installer Name,Branch Name or Send To Repair Center Delhi  ";
					echo "<script type='text/javascript'>alert('$errorMsg');</script>";
			   }
		   }   
	   else
	   {
		   if($_POST['radio_value']=='by_sendrepDelhi')
		   {
			  for($i=0;$i<$rowcount;$i++)
			  {
				   if(isset($_POST['rowVal'][$i]))
				   {
					    $antena=$_POST['antenna'][$i];
						 $immob_tp=$_POST['immob_type'][$i];
						 if($immob_tp==1)
						 {
							$immob_type="24VT";
						 }
						 if($immob_tp==2)
						 {
							$immob_type="12VT";
						}
						$immob_count=$_POST['immob'][$i];
						$connectors=$_POST['connectors'][$i];
					   
						$data=explode('##',$_POST['rowVal'][$i]);
						//print_r($data);die;
						$DeviceId=$data[0];
						$itgc_id=$data[1];
						$device_imei=$data[2];
						//$antena=$data[3];
						//$immob_type=$data[4];
						//$immob_count=$data[5];
						//$connectors=$data[6];
						$item_id=$data[7];
						$st1=$data[8];
						$remark=$_POST['remark'][$i];
						$selectDeviceType=$masterObj->selectDeviceType($item_id);
						//echo "<pre>";print_r($selectDeviceType[0]['item_name']); die;
						$device_type=$selectDeviceType[0]['item_name'];
				
						$l1=$_SESSION['branch_id'];
						if($l1!=1)
						{
							if ($st1 == 64 || $st1 == 82)
							{
								$DeviceStatus=$SendToRepair_ByBranch;

							}
							else
							{
								$DeviceStatus=$SendToRepair_ByBranch;
							}
						}
						else
						{
							if ($st1 == 64 || $st1 == 82)
							{
								$DeviceStatus = $DeviceRemoved;

							}
							else
							{
								$DeviceStatus = $DeviceRemoved;
							}
						}
						
						$device_Removed_Date=date('Y-m-d H:i:s');
						$dispatchBranch=1;
						$branchIds=1;
						$Is_Branch_Recevied=$branchId;
						$deviceRemoveProblem = "device removed(At time of Stock Received By branch)";
						$AssignedToBranch_Repair=select_Procedure("CALL AssignedToBranch_Repair('".$DeviceId."','".$DeviceStatus."','".$remark."','".$dispatchBranch."','".$Is_Branch_Recevied."','".$device_Removed_Date."','".$deviceRemoveProblem."')");
						$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
						$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$branchIds,$device_Removed_Date); 
						

				   }
			   }
			   $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  
						//header("location:challan_send_toRepair.php?challanNo=".$strChallanNo);
						echo "<script type='text/javascript'>   
						window.open( 'challan_send_toRepair.php?challanNo=$strChallanNo');
						</script>";
						?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?
		   }
			else if($_POST['radio_value']=='by_installer')
			{
			   if($_POST['installer_list']==0)
				{
					 $errorMsg='Please Select Installer Name';
					 echo "<script type='text/javascript'>alert('$errorMsg');</script>";
			    }
				else
				{
					for($i=0;$i<$rowcount;$i++)
					{
						if(isset($_POST['rowVal'][$i]))
						{
							 $antena=$_POST['antenna'][$i];
							 $immob_tp=$_POST['immob_type'][$i];
							 if($immob_tp==1)
							 {
								$immob_type="24VT";
							 }
							 if($immob_tp==2)
							 {
								$immob_type="12VT";
							}
							$immob_count=$_POST['immob'][$i];
							$connectors=$_POST['connectors'][$i];
							$data=explode('##',$_POST['rowVal'][$i]);
							//print_r($data);die;
							$DeviceId=$data[0];
							$itgc_id=$data[1];
							$device_imei=$data[2];
							//$antena=$data[3];
							//$immob_type=$data[4];
							//$immob_count=$data[5];
							//$connectors=$data[6];
							$item_id=$data[7];
							$st1=$data[8];
							$remark=$_POST['remark'][$i];
							$selectDeviceType=$masterObj->selectDeviceType($item_id);
							//echo "<pre>";print_r($selectDeviceType[0]['item_name']); die;
							$device_type=$selectDeviceType[0]['item_name'];
							$l1=$_SESSION['session_id'];
							//$BranchID=$branchId;
							$Installer_id=$_POST['installer_list'];
							$selectInstallerName=$masterObj->selectInstallerName($Installer_id);
							$Installer_name=$selectInstallerName[0]['inst_name'];
							if ($st1 == 64 || $st1 == 82)
							{
								$DeviceStatus=$AssignToInstaller;
							}
							else
							{
								$DeviceStatus=$AssignToInstaller;
							}
							$Insaller_AssignDate=date('Y-m-d H:i:s');
							$dispatchBranch=1;

							
							$AssignedToBranch_Repair=select_Procedure("CALL AssignedDevicesToInstaller('".$DeviceId."','".$DeviceStatus."','".$remark."','".$Installer_name."','".$branchId."')");
							//int intRowsEffected = this.ObjDisptachDevice.SaveChallanDetailInstaller(BranchID, strChallanNo, strDeviceIDs, strAntennaCount, strImmobilzerType, strImmobilzerCount, strConnectorCount, ddlInstallerName.SelectedValue, ChallanMode, "A");
							$selectChallanDetails=$masterObj->selectChallanDetails($strChallanNo);
							//echo '<pre>';print_r($selectChallanDetails);die;
								//echo count($selectChallanDetails);die;
							if(count($selectChallanDetails)<1)
							{
								$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$Installer_id,$branchId,$Insaller_AssignDate);
							}
							else
							{
								if(count($selectChallanDetails)>0)
								{
									if($selectChallanDetails[0]["ChallanNo"] != "")
									{
										 $updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
										 $insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$Installer_id,$branchId,$Insaller_AssignDate);
									
									}
									else
									{
										$updateChallanDetailsNotChallanNoExist=$masterObj->updateChallanDetailsNotChallanNoExist($strChallanNo,$antena,$immob_type,$immob_count,$connectors,$Installer_id,$DeviceId); 
									}
									if($Installer_id == -1)
									{
										$updateNewDeviceRequest=$masterObj->updateNewDeviceRequest($DeviceId,$selectChallanDetails[0]["BranchID"]); 
										
									}
								}	
							}
					
					
						}
					}
				}
						 $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  

							  echo "<script type='text/javascript'>   
							window.open( 'challan_assign_device_installer.php?challanNo=$strChallanNo&to_installer=$Installer_name');
							</script>";
							?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?
				
			   }
			  else if($_POST['radio_value']=='by_branch')
			   {  
				 	 if($_POST['branch_list']==0)
					 {
					    $errorMsg='Please Select Branch';
					    echo "<script type='text/javascript'>alert('$errorMsg');</script>";
				    }
					else
					{
					    for($i=0;$i<$rowcount;$i++)
						{
							if(isset($_POST['rowVal'][$i]))
							{
								  $antena=$_POST['antenna'][$i];
								 $immob_tp=$_POST['immob_type'][$i];
								 if($immob_tp==1)
								 {
									$immob_type="24VT";
								 }
								 if($immob_tp==2)
								 {
									$immob_type="12VT";
								}
								$immob_count=$_POST['immob'][$i];
								$connectors=$_POST['connectors'][$i];
								$data=explode('##',$_POST['rowVal'][$i]);
								//print_r($data);die;
								$DeviceId=$data[0];
								$itgc_id=$data[1];
								$device_imei=$data[2];
								//$antena=$data[3];
								//$immob_type=$data[4];
								//$immob_count=$data[5];
								//$connectors=$data[6];
								$item_id=$data[7];
								$st1=$data[8];
							
								$remark=$_POST['remark'][$i];
								
								$st1=$status;
								$l1=$_SESSION['session_id'];
								$BranchID=$_SESSION['session_id'];
								$Installer_name=$_POST['installer_list'];
								if ($st1 == 64 || $st1 == 82)
								{
									if($_POST['branch_list']==2)
									{
										$DeviceStatus=$FinalAttachSim;
									}
									else
									{
										$DeviceStatus=$OutOfStock;
									}
									
								}
								else
								{
									if($_POST['branch_list']==1)
									{
										//$DeviceStatus=$FinalAttachSim;
										$DeviceStatus=$New_Device_ByBranch;
									}
									else
									{
										$DeviceStatus=$OutOfStock;
									}	
								}
								
								$branch_send_date=date('Y-m-d H:i:s');
								$dispatchBranch_id=$_POST['branch_list'];
								$Is_Branch_Recevie=$branchId;
								$selectDispatchBranch =$masterObj->selectDispatchBranch($dispatchBranch_id);
								$dispatch_branch=$selectDispatchBranch[0]['branch_name'];
								$Is_Branch_Recevie=$branchId;
								$AssignedToBranch_Repair=select_Procedure("CALL AssignedDevicesToInstaller_branch('".$DeviceId."','".$DeviceStatus."','".$remark."','".$Is_Branch_Recevie."','".$dispatchBranch_id."','".$branch_send_date."')");
								$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
								$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$dispatchBranch_id,$branch_send_date); 
								
					   }
					}
					$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
					echo "<script type='text/javascript'>   
					window.open( 'challan_assign_device_branch.php?challanNo=$strChallanNo&branch_name=$dispatch_branch');
					</script>";
					?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?
				}
			}
			else
			{
				$errorMsg="Please select either Installer Name,Branch Name or Send To Repair Center Delhi";
				echo "<script type='text/javascript'>alert('$errorMsg');</script>";
			}
	   }
ob_end_flush();	   
}
?>
<head>

</head>
<body>
<form name="assg_device" id="assg_device" method="post" action=""  onsubmit="return validateForm();">
 <div class="color-sign" style="margin: 11px 0 0px 0px;">
      <div class="cl-item"><span class="lightblue"></span><span >Light Blue :</span><span>Repaired Device</span></div>
      <div class="cl-item"><span class="white"></span><span >White  :</span><span>New Device</span></div>
      <div class="cl-item"><span class="aqua"></span><span >Aqua :</span><span>Recevied from Branch</span></div>
      <div class="cl-item"><span class="red"></span><span >Red :</span><span>FFC Permanent</span></div>
	  <div class="cl-item"><span class="lightgreen"></span><span >Light Green :</span><span> FFC Device </span></div>
 </div>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Assign Devices To Installer </div>
      </div>
      <div class="portlet-body control-box " style="margin-bottom:0;">
           <div class="content-box">
        
           <div class="right-item"> 
		   <table>
            <tr>
              <td><input type="radio" name="radio_value" id="installer_name" value="by_installer"  onchange="by_installerName(this.value);"></td>
              <td>Installer Name</td>
              <td><input type="radio" name="radio_value" id="branch_name" value="by_branch" onChange="by_branchName(this.value);"></td>
              <td>Branch Name </td>
			  <td><input type="radio" name="radio_value" id="send_rep_delhi" value="by_sendrepDelhi" onChange="by_send_rep_delhi(this.value);"></td>
              <td>Send To Repair Center Delhi 	 </td>
            </tr>
          </table>
		  </div>
		  <select class="form-control" name="installer_list" id="installer_list" style="display:none" onChange="assign_installer(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 <?php if($errorMsg){"please select Installer";}?>
		
		  <select class="form-control" name="branch_list" id="branch_list" style="display:none" onChange="assign_branch(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($branchList);$i++)
			{?>
            <option value="<?=$branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?>
            </option>
            <? } ?>
	
         </select>
		
		 
          </div>
		  
       
    </div>
	<div class="portlet-body" id="tt"  style="">
        <table class="table table-bordered"  id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> ITGC ID</th>
			  <th> IMEI </th>
              <th> DispatchRecd Remarks</th>
              <th> Remarks </th>
              <th> Antenna </th>
			  <th> Immobilizer </th>
			  <th> Connectors </th>
			  <?php if($branchId!=1){?>
			  <th> Device Dispatchrecd Remarks </th>
			  <?php }?>
			  <th> IsFFCPermanent </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				
				$repaired=$SelectRecdDispatchedDevices[$x]['is_repaired'];
				 $is_ffc=$SelectRecdDispatchedDevices[$x]['is_ffc'];
				 $is_permanent_ffc=$SelectRecdDispatchedDevices[$x]['is_permanent'];
				// $new_device=$deviceData[$x]['is_cracked'];
				 if($is_permanent_ffc==1 && $is_ffc==0 )
				 {
                   $color="LightGreen";
					$tool_tip="FFC device";
                 }
				 else if($repaired==1)
				 {
					$color="#7acde9";
					$tool_tip="repaired Device";
					
                 }
				 else
				 {
					$color="#FFFFFF";
					$tool_tip="new device";
				 }
            ?>
            <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectRecdDispatchedDevices[$x]['device_id'];?>##<?php echo $SelectRecdDispatchedDevices[$x]['itgc_id'];?>##<?php echo $SelectRecdDispatchedDevices[$x]['device_imei']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchAntennaCount']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchImmobilizerType'];?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchImmobilizerCount']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchConnectorCount']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['device_type']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['device_status']; ?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['itgc_id']; ?></td>
			   
			   
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['device_imei']; ?></td>
			   <td><?php echo $SelectRecdDispatchedDevices[$x]['dispatch_remarks'];?></td>
              <td><textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea></td>
			  	<?php if($branchId==1){?>
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['DispatchAntennaCount']; ?></td>
			  <?php $imm_type=$SelectRecdDispatchedDevices[$x]['DispatchImmobilizerType'];
			  if($imm_type==1)
			  {
				  $immob_type="24VT";
			  }
			  elseif($imm_type==2)
			  {
				  $immob_type="12VT";
			  }
			  else
			  {
				  $immob_type="";
			  }
		
			  ?>
			  
			  <td><?php echo 'immob type :'.$immob_type; echo '</br>'?>
			  <?php echo 'immob count :'.$SelectRecdDispatchedDevices[$x]['DispatchImmobilizerCount']; ?></td>
			  
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['DispatchConnectorCount']; ?></td>
			  <?php }else{?>
			     <td>
                <select id="antenna<?php echo $y;?>" name="antenna[]" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($i=1;$i<=10;$i++){ ?>
                  <option role="presentation" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php } ?>
                </select>  
              </td>
              <td>
			  <select id="immob_type<?php echo $y;?>" name="immob_type[]" disabled />
                  <option role="presentation" value="0">Select</option>
				  <option role="presentation" value="1">24VT</option>
				  <option role="presentation" value="2">12VT</option>
			  </select>  
				
                <select id="immob<?php echo $y;?>" name="immob[]" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($j=1;$j<=10;$j++){ ?>
                  <option role="presentation" value="<?php echo $j; ?>"><?php echo $j; ?></option>
                  <?php } ?>
                </select>  
              </td>
			  
			     <td>
                <select id="connectors<?php echo $y;?>" name="connectors[]" disabled />
                  <option role="presentation" value="0">Select</option>
                  <?php for($j=1;$j<=10;$j++){ ?>
                  <option role="presentation" value="<?php echo $j; ?>"><?php echo $j; ?></option>
                  <?php } ?>
                </select>  
              </td>
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['device_dispatchrecd_remarks']; ?></td>
			  <?php }?>
			  
			  <?php
					$isffc_permanent=$SelectRecdDispatchedDevices[$x]['is_permanent'];
					if($isffc_permanent==1)
					{
						$isffc_perm='True';
					}
					else
					{
						$isffc_perm='False';
					}
			  ?>
			  <td><?php echo $isffc_perm; ?></td>
            </tr>
            <?php } ?>
           
          </tbody>
		     </table>
			  <tr>
              <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Assign"></td>
            </tr>
			  </div>
			     </div>
					 </div>
          </form> 

    <!-- END BORDERED TABLE PORTLET--> 
  
</article>
<script type="text/javascript">
 var $assign = jQuery.noConflict();
function by_installerName(number)
{
	document.getElementById('installer_list').style.display = "block";
	document.getElementById('branch_list').style.display = "none";
	//document.getElementById('send_delhi_list').style.display = "none";
	 
}
function by_branchName(number)
{
	 document.getElementById('branch_list').style.display = "block";
	 document.getElementById('installer_list').style.display = "none";
	//document.getElementById('send_delhi_list').style.display = "none";
}
function by_send_rep_delhi(number)
{
	 //document.getElementById('send_delhi_list').style.display = "block";
	 document.getElementById('installer_list').style.display = "none";
	 document.getElementById('branch_list').style.display = "none";
}

</script>
<script>
function validateForm() 
{
	//var r = document.getElementsByName("radio_value");
      var test = document.getElementsByName("radio_value");
	  var sizes = test.length;
	  var flag=0;
	  //alert(sizes);
      for (i=0; i < sizes; i++) 
	  {
         if (test[i].checked==true)
		  {
             // alert(test[i].value + ' you got a value');     
             //return test[i].value;
			 flag=1;
          }
      }
	//alert(flag);
	//alert(test[1].value);
	if(flag!=1)
	{
		alert("Please select either Installer Name,Branch Name or Send To Repair Center Delhi");
		return false;
	}
	else
	{
		if(test[0].checked==true)
		{
			var e = document.getElementById("installer_list");
			var inst_name = e.options[e.selectedIndex].value;
			//var strUser1 = e.options[e.selectedIndex].text;
			//alert(strUser1);
			if(inst_name==0)
			{
				alert("Please Select Installer Name");
				document.assg_device.installer_list.focus();
				return false;
			} 
		}
		if(test[1].checked==true)
		{
			var e = document.getElementById("branch_list");
			var branch_name = e.options[e.selectedIndex].value;
			if(branch_name==0)
			{
				alert("Please Select Branch Name");
				document.assg_device.branch_list.focus();
				return false;
			} 
		}
	}
}
</script>
<script>

  $assign('.checkbox1').on('change', function() {
    var bool = $assign('.checkbox1:checked').length === $assign('.checkbox1').length;
    $assign('#checkAll').prop('checked', bool);
  });

  $assign('#checkAll').on('change', function() {
    $assign('.checkbox1').prop('checked', this.checked);
  });
</script>
<script type="text/javascript">
  function checkAllId(){
    var i;
    var row = document.getElementById("checkAll");
	//alert(<?php echo $rowcount;?>);
	//alert(row.checked);
    for(i=1;i<=<?php echo $rowcount; ?>;i++){
      if(row.checked){
		 // alert(i);
        document.getElementById("remark"+i).disabled = false;
	/* 	document.getElementById("antenna"+i).disabled = false;
        document.getElementById("immob"+i).disabled = false;
		document.getElementById("immob_type"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false; */
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
		document.getElementById("antenna"+i).disabled = true;
        document.getElementById("immob"+i).disabled = true;
		document.getElementById("immob_type"+i).disabled = true;
		document.getElementById("connectors"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
	  document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("immob_type"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;

    }else{
      document.getElementById("remark"+rowId).disabled = true;
	    document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("immob_type"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
    }
  }
</script>
<script data-config>
    var filtersConfig = {
        base_path: 'dist/tablefilter/',
        paging: true,

        remember_grid_values: false,
        remember_page_number: false,
        remember_page_length: false,
        alternate_rows: false,
        btn_reset: true,
        rows_counter: true,
        loader: false,

        status_bar: true,

        status_bar_css_class: 'myStatus',

        extensions:[{
            name: 'sort',
          types: [
                    'number', 'number','number',
                    'string','number', 'string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
  </form>
</body>
</html>