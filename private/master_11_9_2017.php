<?php
session_start();
//include_once(__DOCUMENT_ROOT.'/config.php');
include_once(__DOCUMENT_ROOT.'/private/lib/library_common.php');
class master
{
	
		function check_simnoForRND($sim_no)
		{
			$condition = "";
			// echo "select sim_no from sim INNER JOIN simchallandetail ON sim.sim_id=simchallandetail.sim_id WHERE (sim.branch_id=0 OR sim.flag=0 OR sim.active_status=0 OR sim.is_testsim=1 OR sim.Sim_status !=93) AND simchallandetail.currentrecord=0 AND sim.sim_no='".$sim_no."'"; die;
			$this->data=db__select("select sim_no from sim INNER JOIN simchallandetail ON sim.sim_id=simchallandetail.sim_id WHERE (sim.branch_id=0 OR sim.flag=0 OR sim.active_status=0 OR sim.is_testsim=1 OR sim.Sim_status !=93) AND simchallandetail.currentrecord=0 AND sim.sim_no='".$sim_no."'", $condition);
			return count($this->data);
		}
			function selectRepairName($strSimID)
			{
				$condition = "";
				//echo "select id,name from repair_user where id='".$strSimID."'"; die;
				$this->data=db__select("select id,name from repair_user where id='".$strSimID."' ", $condition); 
				return $this->data;
		
			} 

	
			function navData($Serviceid)
			{
				$condition = "";
				$this->data=db__select("select sys_Service_id,gps_time,ADDDATE( gps_time, INTERVAL 330 MINUTE) as india_time,gps_latitude,gps_longitude,gps_speed,des_movement_id as port,case when tel_ignition=true then true else false end as AC,case when tel_panic=true then true else false end as tel_panic,tel_rawlog,tel_fuel,case when tel_input_0=true then true else false end as tel_input_0,case when tel_input_1=true then true else false end as tel_input_1,case when tel_input_2=true then true else false end as tel_input_2,tel_input_3,tel_temperature,tel_voltage,main_powervoltage,gps_fix,tel_rfid,tel_fuel,tel_odometer,tel_hours from today_ideal where sys_Service_id='".$Serviceid."' and ADDDATE(gps_time,INTERVAL 19800 SECOND)>=ADDDATE(NOW(),INTERVAL -65 minute)", $condition); 
				return $this->data;
			} 
	
		   function newQryService($imei)
			{
				$condition = "";
		
				//echo "select services.veh_reg from services where device_imei = '".$imei."'"; die;
				$this->data=db__select_staging("select services.id,veh_reg from services left join devices on services.sys_device_id=devices.id where devices.imei = '".$IMEI."'", $condition); 
				return $this->data;
			} 
	
			function updateNotificationAlert($Installer_id)
			{
				$condition = "";
				$this->data=db__select("UPDATE notification_alert set status_count=0 where inst_id ='".$Installer_id."'", $condition);
				return $this->data;
		
			}
			function select_Notification()
			{
				$condition = "";
				//echo "SELECT count(*) from notification_alert where status_count = 1"; die;
				$this->data=db__select("SELECT count(*) as no_of_notification from notification_alert where status_count = 1", $condition); 
				return $this->data;
			} 
			
			function insertSIMChallanDetailReassignRepair($strChallanNo,$branchId,$RepairName,$sim_id)
			{
				$condition = "";
				$insert_data="INSERT INTO simchallandetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord,RepairName) VALUES('".$strChallanNo."','".$sim_id."','".$branchId."',1,'".$RepairName."')";
				$this->data=db__select($insert_data,$condition);
				return $this->data;
		
			}
			function insertSIMChallanDetailsRepair($strChallanNo,$sim_id,$branchId,$Installer_id,$remark,$AssignDate,$RepairName)
			{
					  $condition = "";
					  $insert_data="INSERT INTO simchallandetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord,installerID,AssignRemarks,AssignDate,RepairName) VALUES('".$strChallanNo."','".$sim_id."','".$branchId."',1,'".$Installer_id."','". $remark."','". $AssignDate."','". $RepairName."')";
					  $this->data=db__select($insert_data,$condition);
					
					  return $this->data;	
			}
			
			
			function updateSIMChallanDetailsExistBranch($strChallanNo,$branchId,$sim_id)
			{
				$condition = "";
				$this->data=db__select("UPDATE simchallandetail set CurrentRecord=1,DispatchChallanNo='".$strChallanNo."',BranchID='".$branchId."' where sim_id ='".$sim_id."'", $condition);
				return $this->data;
		
			}
	

			function insertSIMChallanDetailsBranch($strChallanNo,$sim_id,$branchId)
			{
					  $condition = "";
					  $insert_data="INSERT INTO simchallandetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord) VALUES('".$strChallanNo."','".$sim_id."','".$branchId."',1)";
					  $this->data=db__select($insert_data,$condition);
					
					  return $this->data;	
			} 
	

			function updateSIMChallanDetailsExistInstaller($strChallanNo,$branchId,$Installer_id,$sim_id)
			{
				$condition = "";
				$this->data=db__select("UPDATE simchallandetail set CurrentRecord=1,DispatchChallanNo='".$strChallanNo."',BranchID='".$branchId."',installerID='".$Installer_id."' where sim_id ='".$sim_id."'", $condition);
				return $this->data;
		
			}
	
			function insertSIMChallanDetailsInstaller($strChallanNo,$sim_id,$branchId,$Installer_id,$remark,$AssignDate)
			{
					  $condition = "";
					  $insert_data="INSERT INTO simchallandetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord,installerID,AssignRemarks,AssignDate) VALUES('".$strChallanNo."','".$sim_id."','".$branchId."',1,'".$Installer_id."','". $remark."','". $AssignDate."')";
					  $this->data=db__select($insert_data,$condition);
					
					  return $this->data;	
			}
			
	
			function GetSimInstallerChallanDetailByNo($strChallanNo)
			{
				$condition = "";

				$this->data=db__select("select CD.RepairName,CD.InstallerID,CD.DispatchChallanNo,CD.sim_id,D.sim_no,D.branch_id,D.operator, D.phone_no from simchallandetail CD LEFT JOIN sim D ON CD.sim_id=D.sim_id  WHERE CD.DispatchChallanNo='".$strChallanNo."' AND CD.CurrentRecord=1", $condition); 
				return $this->data;
			} 

			function updateSIMChallanDetailsExist($strChallanNo,$branchId,$RepairName,$sim_id)
			{
				$condition = "";
				$this->data=db__select("UPDATE simchallandetail set CurrentRecord=1,DispatchChallanNo='".$strChallanNo."',BranchID='".$branchId."',RepairName='".$RepairName."' where sim_id ='".$sim_id."'", $condition);
				return $this->data;
		
			}
		
			function insertSIMChallanDetails($strChallanNo,$sim_id,$branchId,$RepairName,$AssignDate)
			{
					  $condition = "";
					 // echo "INSERT INTO SimChallanDetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord,RepairName,AssignDate) VALUES('".$strChallanNo."','".$sim_id."','".$branchId."',1,'".$RepairName."','". $AssignDate."')"; die;
					  $insert_data="INSERT INTO simchallandetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord,RepairName,AssignDate) VALUES('".$strChallanNo."','".$sim_id."','".$branchId."',1,'".$RepairName."','". $AssignDate."')";
					  $this->data=db__select($insert_data,$condition);
					
					  return $this->data;	
			}  
			function selectSIMChallanDetails($sim_id)
			{
				$condition = "";
				//echo "select DispatchChallanNo,BranchID,CurrentRecord from simchallandetail where sim_id='".$sim_id."' order by AssignDate desc limit 1";die;
				$this->data=db__select( "select DispatchChallanNo,BranchID,CurrentRecord from simchallandetail where sim_id='".$sim_id."' order by AssignDate desc limit 1", $condition); 
				return $this->data;
			} 

			function GetSimChallanDetailByNo($strChallanNo)
			{
				$condition = "";
		
				$this->data=db__select("select sim.phone_no,sim.operator,Branch_Master.branch_name,sim.branch_id  from simchallandetail left jOIN sim ON sim.sim_id=simchallandetail.sim_id left jOIN Branch_Master ON Branch_Master.id=simchallandetail.BranchID WHERE simchallandetail.DispatchChallanNo='".$strChallanNo."' AND CurrentRecord=1", $condition); 
				return $this->data;
			} 

		/* 	function updateSimChallanDetailExist($strChallanNo,$strArrAntenna,$strArrImmobilerType,$strArrImmobilzerCount,$strArrConnectorCount,$strInstallerID,$strArrDevice)
			{
				$condition = "";
				$this->data=db__select("UPDATE ChallanDetail set InstallerChallanNo='".$strChallanNo."',AssignedAntennaCount='".$strArrAntenna."',AssignedImmobilizerType='".$strArrImmobilerType."',AssignedImmobilizerCount='".$strArrImmobilzerCount."',AssignedConnectorCount='".$strArrConnectorCount."',InstallerID='".$strInstallerID."' where id in  (select id from ChallanDetail where DeviceID='".$strArrDevice."' order by DispatchDate desc limit 1)", $condition);
				return $this->data;
			}
	  */
	 		function updateSimChallanDetailExist($strChallanNo,$branch_send,$sim_id)
			{
					$condition = "";
					$this->data=db__select("UPDATE simchallandetail set CurrentRecord=1,DispatchChallanNo='".$strChallanNo."',BranchID='".$branch_send."' WHERE sim_id='".$sim_id."' ", $condition);
					return $this->data;
	
			} 
	  
			function updateSimChallanDetails($sim_id)
			{
				$condition = "";

				$this->data=db__select("Update simchallandetail set CurrentRecord=0 where sim_id='".$sim_id."'", $condition);
				return $this->data;
			}
			 

	
			function insertSimChallanDetail($strChallanNo,$sim_id,$branch_send)
			{
	
				 $condition = "";
				 $insert_data="INSERT INTO simchallandetail(DispatchChallanNo,sim_id,BranchID,CurrentRecord) VALUES('".$strChallanNo."','".$sim_id."','". $branch_send."',1)";
				 $this->data=db__select($insert_data,$condition);
				
				  return $this->data;	
			}   
		
			function SelectSimChallanDetail($strSimID)
			{
				$condition = "";
		
				$this->data=db__select("select DispatchChallanNo,BranchID,CurrentRecord from simchallandetail where sim_id='".$strSimID."' order by AssignDate desc limit 1", $condition); 
				return $this->data;
		
			} 

			function selectChallanDetails($strChallanNo,$DeviceId)
			{
				$condition = "";

				$this->data=db__select( "select InstallerChallanNo as ChallanNo,DispatchChallanNo,BranchID,DispatchAntennaCount,DispatchImmobilizerType,DispatchImmobilizerCount,DispatchConnectorCount,DispatchDate from challandetail where DeviceID='".$DeviceId."' and InstallerChallanNo='".$strChallanNo."' order by DispatchDate desc limit 1", $condition); 
				return $this->data;
		
			} 
			
			function insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$strArrAntenna,$strArrImmobilerType,$strArrImmobilzerCount,$strArrConnectorCount,$installer_id,$branchId,$date_time)
			{
	
					  $condition = "";
					  $insert_data="INSERT INTO challandetail(DispatchChallanNo,InstallerChallanNo,DeviceID,ChallanStatus,AssignedAntennaCount,AssignedImmobilizerType,AssignedImmobilizerCount,AssignedConnectorCount,CurrentRecord,InstallerID,BranchID,AssignedDate) VALUES('".$strChallanNo."','".$strChallanNo."','".$DeviceId."',1,'".$strArrAntenna."','". $strArrImmobilerType."','".$strArrImmobilzerCount."','".$strArrConnectorCount."',1,'".$installer_id."','".$branchId."','".$date_time."')";
					  $this->data=db__select($insert_data,$condition);
					
					  return $this->data;	
			}  
			
			
			function insertChallanDetails($strChallanNo,$DeviceId,$strArrAntenna,$strArrImmobilerType,$strArrImmobilzerCount,$strArrConnectorCount,$branchid,$date_time)
			{
				  $condition = "";
				  $insert_data="INSERT INTO challandetail(DispatchChallanNo,DeviceID,ChallanStatus,DispatchAntennaCount,DispatchImmobilizerType,DispatchImmobilizerCount,DispatchConnectorCount,CurrentRecord,BranchID,AssignedDate) VALUES('".$strChallanNo."','".$DeviceId."',1,'".$strArrAntenna."','". $strArrImmobilerType."','".$strArrImmobilzerCount."','".$strArrConnectorCount."',1,'".$branchid."','".$date_time."')";
				// echo $insert_data;die;
				  $this->data=db__select($insert_data,$condition);
				  return $this->data;
			}  

																																																																																																																																																																																																																																																																																																																										
			function GetChallanDetailByNo($strChallanNo,$device_idList)
			{
				$condition = "";
				//echo $device_idList; die;
				//echo "select CD.InstallerName,D.device_installer_remarks,CD.BranchID, CD.DispatchChallanNo,CD.DeviceId,D.itgc_id,D.device_sno,D.device_imei,IM.item_name AS DeviceType,CD.DispatchAntennaCount,CD.DispatchImmobilizerType,CD.DispatchImmobilizerCount,CD.DispatchConnectorCount,branch_master.branch_name from challandetail CD LEFT JOIN device D ON  CD.DeviceID=D.device_id LEFT JOIN item_master IM ON D.device_type=IM.item_id LEFT JOIN branch_master ON CD.BranchID=branch_master.id WHERE CD.DeviceID IN ($device_idList) and CD.DispatchChallanNo='".$strChallanNo."' and CD.CurrentRecord=1"; die;
				$this->data=db__select("select CD.InstallerName,D.device_installer_remarks,CD.BranchID, CD.DispatchChallanNo,CD.DeviceId,D.itgc_id,D.device_sno,D.device_imei,IM.item_name AS DeviceType,CD.DispatchAntennaCount,CD.DispatchImmobilizerType,CD.DispatchImmobilizerCount,CD.DispatchConnectorCount,branch_master.branch_name from challandetail CD LEFT JOIN device D ON  CD.DeviceID=D.device_id LEFT JOIN item_master IM ON D.device_type=IM.item_id LEFT JOIN branch_master ON CD.BranchID=branch_master.id WHERE CD.DeviceID IN ($device_idList) and CD.DispatchChallanNo='".$strChallanNo."' and CD.CurrentRecord=1", $condition); 	
				return $this->data;
			
			}
		
			function GetDispatchChallanDetailByNo($strChallanNo)
			{
				$condition = "";
		 
				$this->data=db__select("select D.device_installer_remarks,CD.BranchID,CD.InstallerID,CD.InstallerChallanNo,CD.DeviceId,D.itgc_id,D.device_sno,D.device_imei,IM.item_name AS DeviceType,CD.AssignedAntennaCount,CD.AssignedImmobilizerType,CD.AssignedImmobilizerCount,CD.DispatchConnectorCount,CD.AssignedConnectorCount,CD.DispatchImmobilizerType,CD.DispatchImmobilizerCount,CD.DispatchAntennaCount,D.DEVICE_STATUS from challandetail CD LEFT JOIN device D ON  CD.DeviceID=D.device_id LEFT JOIN item_master IM ON D.device_type=IM.item_id WHERE CD.DispatchChallanNo='".$strChallanNo."'", $condition); 
				return $this->data;
			}
		
			function selectDispatchBranch($send_branch)
			{
				$condition = "";
				$this->data=db__select("select branch_name from branch_master WHERE id='".$send_branch."'", $condition);
				return $this->data;
			}

		function checkIMEI($new_imei)
		{
			$condition = "";
			$this->data=db__select("select device_imei,itgc_id from inventory.device WHERE active_status=1 AND device_imei='".$new_imei."'", $condition);
			return count($this->data);
		}
		
		function checkSno($sno)
		{
			$condition = "";
			$this->data=db__select("select device_sno from device WHERE active_status=1 AND device_sno='".$sno."'", $condition);
			return count($this->data);
		
		}
		function check_imei($imei_no)
		{
			$condition = "";
			$this->data=db__select("select device_imei from device WHERE active_status=1 AND device_imei='".$imei_no."'", $condition);
			return count($this->data);
		}
		function check_simno($sim_no)
		{
			$condition = "";
			$this->data=db__select("select sim_no from sim WHERE active_status=1 AND sim_no='".$sim_no."'", $condition);
			return count($this->data);
		}
		function phone_no($phone_no)
		{
			$condition = "";
			$this->data=db__select("select phone_no from sim WHERE active_status=1 AND phone_no='".$phone_no."'", $condition);
			return count($this->data);
		}
		function updateChallanDetails($DeviceId)
		{
			$condition = "";
			$this->data=db__select("Update challandetail set CurrentRecord=0 where DeviceID='".$DeviceId."'", $condition);
			return $this->data;
		
		}

		function updateChallanDetailsNotChallanNoExist($strChallanNo,$strArrAntenna,$strArrImmobilerType,$strArrImmobilzerCount,$strArrConnectorCount,$strInstallerID,$strArrDevice)
		{
			$condition = "";
		//	echo "UPDATE ChallanDetail set InstallerChallanNo='".$strChallanNo."',AssignedAntennaCount='".$strArrAntenna."',AssignedImmobilizerType='".$strArrImmobilerType."',AssignedImmobilizerCount='".$strArrImmobilzerCount."',AssignedConnectorCount='".$strArrConnectorCount."',InstallerID='".$strInstallerID."' where id in (select id from ChallanDetail where DeviceID='".$strArrDevice."' order by DispatchDate desc limit 1)"; die;
			
			$this->data=db__select("UPDATE challandetail set InstallerChallanNo='".$strChallanNo."',AssignedAntennaCount='".$strArrAntenna."',AssignedImmobilizerType='".$strArrImmobilerType."',AssignedImmobilizerCount='".$strArrImmobilzerCount."',AssignedConnectorCount='".$strArrConnectorCount."',InstallerID='".$strInstallerID."' where id in (select id from challandetail where DeviceID='".$strArrDevice."' order by DispatchDate desc limit 1)", $condition);
			return $this->data;
		
		}
		
		function updateNewDeviceRequest($DeviceId,$branchID)
		{
			
			$condition = "";
			$this->data=db__select("update newdevice_request set pending_devices=pending_devices-1 where branch_id='".$branchID."' and device_model=(select device_type from device where device_id='".$DeviceId."') and device_condition=
			(select case when is_repaired=1 then '3' when is_cracked=1 then '2' when is_ffc=1 then '1' else '0' end as DeviceCondition from device where device_id='".$DeviceId."')", $condition);
			return $this->data;
		
		}
	 
		function updateApplicationSetting($strChallanMode,$strResult)
		{
			$condition = "";
			$this->data=db__select("UPDATE application_setting SET Id='".$strResult."' WHERE Name='".$strChallanMode."'", $condition);
			return $this->data;
		}
		
		
		function GetInstallerChallanDetailByNo($strChallanNo,$deviceListID)
		{
			$condition = "";
			$this->data=db__select( "select D.device_installer_remarks,CD.InstallerID,CD.InstallerChallanNo,CD.DeviceId,D.itgc_id,D.device_sno,D.device_installer_remarks,D.device_imei,IM.item_name AS DeviceType,CD.AssignedAntennaCount,CD.AssignedImmobilizerType,CD.AssignedImmobilizerCount,CD.AssignedConnectorCount from ChallanDetail CD LEFT JOIN device D ON  CD.DeviceID=D.device_id LEFT JOIN item_master IM ON D.device_type=IM.item_id WHERE CD.InstallerChallanNo='".$strChallanNo."' AND CD.CurrentRecord=1", $condition);
			return $this->data;
		
		}

		function selectDeviceType($device_type)
		{
			$condition = "";
			
			$this->data=db__select("select item_name from item_master WHERE item_id='".$device_type."'", $condition);
			return $this->data;
		
		}
		function selectInstallerName($Installer_id)
		{
			$condition = "";
			$this->data=db__select_staging("select inst_name,installer_mobile from internalsoftware.installer WHERE inst_id='".$Installer_id."' AND is_delete=1", $condition);
			return $this->data;
		
		}

		function getUserData($user_name, $password)
		{
			$condition = "";
			
			$this->data=db__select("select * from inventory.user_details where user_name='".$user_name."' and password='".$password."' and active_status=1", $condition);
			
			return $this->data;
		
		}
		function getUserList($user_id)
		{
			$condition = "";
		
			$this->data=db__select("SELECT sys_username as name FROM matrix.users where id='".$user_id."'", $condition);
			
			return $this->data;
		
		}
		

		function insertDeviceData($device_sno,$ITGC_ID,$recd_date,$device_type,$check_gtrac,$parent_id,$ClientName)
		{
			$condition = "";
			  $insert_data="INSERT INTo device(device_sno,itgc_id,device_imei,sim_id,recd_date,device_type,device_status,active_status,is_cracked,client_name,dispatch_branch) values('".$device_sno."','".$ITGC_ID."',0,0,'".$recd_date."','".$device_type."',21,1,'".$check_gtrac."','".$ClientName."',1)";
			$this->data=db__select($insert_data,$condition);
			
			return $this->data;
		
		}  
	
		function getPhone($phone_no )
		{
			$condition = "";
			$this->data=db__select("select phone_no from inventory.sim where active_status=1 AND phone_no='".$phone_no."'", $condition);
			
			return count($this->data);
		}
	
		function getSim($sim_no )
		{
			$condition = "";
			$this->data=db__select("select sim_no from inventory.sim where active_status=1 AND sim_no ='".$sim_no ."'", $condition);
			
			return count($this->data);
		
		}
		
		function getImei($imei_no )
		{
			$condition = "";
			$this->data=db__select("select device_imei from inventory.device where device_imei ='".$imei_no ."'", $condition);
			
			return count($this->data);
		
		}
		function selectChallanNo($strChallanMode )
		{
			$condition = "";
			$this->data=db__select("select Id from application_setting WHERE Name='".$strChallanMode."'", $condition);
			
			return $this->data;
		
		}

	
		function insertChallanDetail($strChallanNo,$trArrDevice,$strArrAntenna,$strArrImmobilerType,$strArrImmobilzerCount,$strArrConnectorCount,$branchid)
		{
			//print_r($file_name);
			$condition = "";
			$challan_insert = "INSERT INTO challandetail(DispatchChallanNo,DeviceID,ChallanStatus,DispatchAntennaCount,DispatchImmobilizerType,DispatchImmobilizerCount,DispatchConnectorCount,CurrentRecord,branchid) VALUES('".$strChallanNo."','".$trArrDevice."',1,'".$strArrAntenna."','". $strArrImmobilerType."','".$strArrImmobilzerCount."','".$strArrConnectorCount."',1,'".$branchid."')";
			
			$this->data=db__select($challan_insert,$condition);		
			return count($this->data);
		} 
		
		function insertChallanDetails_recd_remove($strChallanNo,$trArrDevice,$strArrAntenna,$strArrImmobilerType,$strArrImmobilzerCount,$strArrConnectorCount,$branchid,$Installer_name)
		{
			//print_r($file_name);
			$condition = "";
			$challan_insert = "INSERT INTO challandetail(DispatchChallanNo,DeviceID,ChallanStatus,DispatchAntennaCount,DispatchImmobilizerType,DispatchImmobilizerCount,DispatchConnectorCount,CurrentRecord,branchid,InstallerName) VALUES('".$strChallanNo."','".$trArrDevice."',1,'".$strArrAntenna."','". $strArrImmobilerType."','".$strArrImmobilzerCount."','".$strArrConnectorCount."',1,'".$branchid."','".$Installer_name."')";
			
			$this->data=db__select($challan_insert,$condition);		
			return count($this->data);
		} 
	
	
		function selectServices($strPhoneNo)
		  {
		   $condition = "";
		  
		   $this->data=db__select("select sys_device_id from matrix.services where veh_reg='".$strPhoneNo."'", $condition);
		   
		   return $this->data;
		  
		  }
		  
		 function updateDeviceImei($strIMEI,$strDeviceID)
		  {
		   $condition = "";
		   $this->data=db__select("update matrix.devices set imei='".$strIMEI."' where id='".$strDeviceID."'", $condition);
		   
		   return $this->data;
		  }
		  
		  function installerName($InstallerId)
			{
				$condition = "";
				$this->data=db__select_staging("select inst_name from internalsoftware.installer where inst_id='".$InstallerId."'", $condition);
				return $this->data;
			
			}
		  
	

}

?>
