<?php
session_start();
//include_once('sqlconnection.php');
//include_once(__DOCUMENT_ROOT.'/config.php');
include_once(__DOCUMENT_ROOT.'/private/lib/library_common.php');

class masterAPI
{
   function getTransferStockData($DeviceId,$TranferInstallerId,$installerId)
	{
		$condition = "";
		
		$this->data=db__select("select * from inventory.challandetail where DeviceId='".$DeviceId."' and InstallerId='".$installerId."' and challandetail.CurrentRecord=1", $condition);
		
		return $this->data;
	} 

	function updateOlderInstaller($DeviceId,$InstallerId,$TranferInstallerId)
	{

			$condition = "";

			$resultOldInstaller=mysql_query("UPDATE inventory.challandetail set challandetail.ConfirmStatus='0',challandetail.CurrentRecord='0' where DeviceId='".$DeviceId."' and InstallerID='".$InstallerId."'");
			if($resultOldInstaller==1)
			{
				$AssignedDate=date('Y-m-d H:i:s');
				$strCH = "CHNO";

				$tt=mysql_query("select Id from inventory.application_setting WHERE Name='InstallerChallanNo'");
				$count=mysql_fetch_array($tt);
				$idCount=$count['Id'];
				$strResult=$idCount+1;
				$strChallanNo=$strCH.$strResult;

				$insertNewInstaller=mysql_query("Insert into inventory.challandetail(DispatchChallanNo,InstallerChallanNo,DeviceID,ChallanStatus,BranchID,InstallerID,AssignedDate,CurrentRecord,ConfirmStatus) values('".$strChallanNo."','".$strChallanNo."','".$DeviceId."',1,1,'".$TranferInstallerId."','".$AssignedDate."',1,0)") or die("MySQL error:".mysql_error());
				if($insertNewInstaller==1)
				{
				    return 1;
				}
				else
				{
					return 0;
				}

			}
			
	}


	function updateAssignedDevice($DeviceId,$InstallerId)
	{

			$condition = "";
			// echo "UPDATE challandetail set challandetail.ConfirmStatus='1' where DeviceId='".$DeviceId."' and InstallerID='".$InstallerId."'and challandetail.CurrentRecord=1"; die;
			$result=mysql_query("UPDATE inventory.challandetail set ConfirmStatus='1' where DeviceId='".$DeviceId."' and InstallerID='".$InstallerId."'and challandetail.CurrentRecord=1") or die("MySQL error:".mysql_error());
			//echo $result; die;
			if($result==1)
			{
				$res=mysql_query("UPDATE devicehistorydate set devicehistorydate.DeviceReceivedInstaller='".date("Y-m-d H:i:s")."' where devicehistorydate.device_id='".$DeviceId."' ");
				return true; 
				 //die;
			}
			// if (mysql_affected_rows() > 0) {

			// 	mysql_query("UPDATE devicehistorydate set devicehistorydate.DeviceReceivedInstaller='".date("Y-m-d H:i:s")."'");
			//     return true;
			// }
			// else {
			//     return false; 
			// }
	}

    function getUserData($user_name, $password)
    {
        $condition = "";
        
        $this->data=db__select("select * from internalsoftware.installer where user_name='".$user_name."' and password='".$password."' 
                                and is_active=1 and is_delete=1", $condition);
        
        return $this->data;
    }

    function getItems($identity)
    {
        $condition = "";
        
        $this->data=db__select("select * from internalsoftware.toolkit_access where identity='".$identity."'", $condition);
        
        return $this->data;
    }
    
    function getLoginUserData($user_name,$password,$installerid,$branchid)
    {
        $condition = "";
        
        $this->data=db__select("select * from internalsoftware.installer where user_name='".$user_name."' and password='".$password."' 
                                and is_active=1 and is_delete=1 and inst_id='".$installerid."' and branch_id='".$branchid."'", $condition);
        
        return $this->data;
    }
    
    function getServiceData($installerid,$branchid)
    {
        $condition = "";
        
        $this->data=db__select("select installer.inst_id, installer.inst_name, services.id, services.req_date, services.name as UserName,
                    services.company_name, services.user_id, services.veh_reg, services.device_imei, services.service_status as running_status, 
                    services.request_by, services.device_model as model,services.pname as contact_person,services.cnumber as contact_number,
                    services.Zone_area as Zone_area,services.job_type as job_type, re_city_spr_1.name as area,services.location as location,
                    case when dfm.IP_Box='Y' then 'Yes' else 'No' end as IP_Box, 
                    case when dfm.fuel_sensor='Y' then 'Yes' else 'No' end as fuel_sensor,
                    case when dfm.bonnet_sensor='Y' then 'Yes' else 'No' end as bonnet_sensor,
                    case when dfm.rfid_reader='Y' then 'Yes' else 'No' end as rfid_reader,
                    case when dfm.speed_alarm='Y' then 'Yes' else 'No' end as speed_alarm,
                    case when dfm.door_lock_unlock='Y' then 'Yes' else 'No' end as door_lock_unlock,
                    case when dfm.temperature_sensor='Y' then 'Yes' else 'No' end as temperature_sensor,
                    case when dfm.duty_box='Y' then 'Yes' else 'No' end as duty_box,
                    case when dfm.panic_button='Y' then 'Yes' else 'No' end as panic_button,
                    case when dfm.ac_status='Y' then 'Yes' else 'No' end as ac_status, 
                    case when dfm.immobilizer='Y' then 'Yes' else 'No' end as immobilizer_status,
                    case when dfm.ignition='Y' then 'Yes' else 'Yes' end as ignition,
                    re_city_spr_1.id_region,zone.name as zone, 'service' as req_type, services.service_reinstall, services.comment
 					from installer left join services on installer.inst_id=services.inst_id  left join re_city_spr_1 on 
					services.Zone_area=re_city_spr_1.id left join zone on re_city_spr_1.id_region=zone.id left join device_feature_master as dfm 
					on services.user_id=dfm.client_id WHERE services.inst_id=".$installerid." AND services.service_status=2 and 
					services.installer_close_status is null ORDER BY services.req_date DESC", $condition);
        
        /*$this->data=db__select("select installer.inst_id, installer.inst_name, services.id, services.req_date, services.name as UserName,
         services.company_name, services.user_id, services.veh_reg, services.device_imei, services.service_status as running_status, 
         services.request_by, services.device_model as model,services.pname as contact_person,services.cnumber as contact_number,
         services.Zone_area as Zone_area,services.job_type as job_type, re_city_spr_1.name as area,services.location as location,
         case when services.IP_Box!='' then 'Yes' else 'No' end as IP_Box, case when services.ac_status!='' then 'Yes' else 'No' end as ac_status, 
         case when services.immobilizer_status!='' then 'Yes' else 'No' end as immobilizer_status, re_city_spr_1.id_region,zone.name as zone, 
         'service' as req_type from installer  left join services on installer.inst_id=services.inst_id  left join re_city_spr_1 
         on services.Zone_area=re_city_spr_1.id left join zone on re_city_spr_1.id_region=zone.id WHERE services.inst_id=".$installerid." AND
         services.service_status=2 and services.installer_close_status is null ORDER BY services.req_date DESC", $condition);*/
        
        return $this->data;
    }
    
    function getInstallationData($installerid,$branchid)
    {
        $condition = "";
        
        $this->data=db__select("select installer.inst_id, installer.inst_name, installation.id, installation.req_date, addclient.UserName, 
        installation.company_name, installation.user_id as user_id,installation.veh_reg,installation.installation_status as running_status, 
        installation.request_by, installation.model as model,installation.Zone_area as Zone_area,installation.job_type as job_type,
        installation.contact_person,installation.contact_number,re_city_spr_1.name as area,installation.location as location,
        re_city_spr_1.id_region,zone.name as zone,'installation' as req_type, installation.instal_reinstall, installation.comment,        
        case when installation.IP_Box!='' then 'Yes' else case when dfm.IP_Box='Y' then 'Yes' else 'No' end end as IP_Box,
        case when installation.fuel_sensor!='' then 'Yes' else case when dfm.fuel_sensor='Y' then 'Yes' else 'No' end end as fuel_sensor, 
        case when installation.bonnet_sensor!='' then 'Yes' else case when dfm.bonnet_sensor='Y' then 'Yes' else 'No' end end as bonnet_sensor, 
        case when installation.rfid_reader!='' then 'Yes' else case when dfm.rfid_reader='Y' then 'Yes' else 'No' end end as rfid_reader, 
        case when installation.speed_alarm!='' then 'Yes' else case when dfm.speed_alarm='Y' then 'Yes' else 'No' end end as speed_alarm,
        case when installation.door_lock_unlock!='' then 'Yes' else case when dfm.door_lock_unlock='Y' then 'Yes' else 'No' end end as 
        door_lock_unlock,  case when installation.temperature_sensor!='' then 'Yes' else case when dfm.temperature_sensor='Y' then 'Yes' 
        else 'No' end end as temperature_sensor,
        case when installation.duty_box!='' then 'Yes' else case when dfm.duty_box='Y' then 'Yes' else 'No' end end as duty_box,
        case when installation.panic_button!='' then 'Yes' else case when dfm.panic_button='Y' then 'Yes' else 'No' end end as panic_button,  
        case when dfm.ac_status='Y' then 'Yes' else 'No' end as ac_status, 
        case when dfm.immobilizer='Y' then 'Yes' else 'No' end as immobilizer_status,
        case when dfm.ignition='Y' then 'Yes' else 'Yes' end as ignition
        from installer  left join installation on installer.inst_id=installation.inst_id  left join re_city_spr_1 on 
        installation.Zone_area=re_city_spr_1.id  left join zone on  re_city_spr_1.id_region=zone.id left join addclient on 
        installation.user_id=addclient.Userid left join device_feature_master as dfm on installation.user_id=dfm.client_id WHERE 
        installation.inst_id=".$installerid." AND installation.installation_status=2 and installation.installer_close_status is null
        ORDER BY installation.req_date DESC", $condition);
        
        /*$this->data=db__select("select installer.inst_id, installer.inst_name, installation.id, installation.req_date, addclient.UserName, 
        installation.company_name, installation.user_id as user_id,installation.veh_reg,installation.installation_status as running_status, 
        installation.request_by, installation.model as model,installation.Zone_area as Zone_area,installation.job_type as job_type,
        installation.contact_person,installation.contact_number,re_city_spr_1.name as area,installation.location as location,
        re_city_spr_1.id_region,zone.name as zone,'installation' as req_type, case when installation.IP_Box!='' then 'Yes' else 'No' end as IP_Box,
        case when installation.fuel_sensor!='' then 'Yes' else 'No' end as fuel_sensor, case when 
        installation.bonnet_sensor!='' then 'Yes' else 'No' end as bonnet_sensor, 
        case when installation.rfid_reader!='' then 'Yes' else 'No' end as rfid_reader, 
        case when installation.speed_alarm!='' then 'Yes' else 'No' end as speed_alarm,
        case when installation.door_lock_unlock!='' then 'Yes' else 'No' end as door_lock_unlock, 
        case when installation.temperature_sensor!='' then 'Yes' else 'No' end as temperature_sensor,
        case when installation.duty_box!='' then 'Yes' else 'No' end as duty_box,
        case when installation.panic_button!='' then 'Yes' else 'No' end as panic_button  from installer  left join installation on 
        installer.inst_id=installation.inst_id  left join re_city_spr_1 on installation.Zone_area=re_city_spr_1.id  left join zone on 
        re_city_spr_1.id_region=zone.id left join addclient on installation.user_id=addclient.Userid WHERE 
        installation.inst_id=".$installerid." AND installation.installation_status=2 and installation.installer_close_status is null
        ORDER BY installation.req_date DESC", $condition);*/
        
        return $this->data;
    }
    

    function getStockData($installerid,$branchid)
	{
		$condition = "";
		// $this->data=db__select("select distinct(device.device_id),device.device_imei,case when device.is_repaired=1 then 'Old device' else 'New Device' end as is_repaired, case when device.is_cracked=1 then 'Client device' else 'Gtrac Device' end as is_cracked,case when device_repair.client_name=null or device_repair.client_name=0 then 'satish' end as client_name,device.itgc_id,
		// 							device.dispatch_date,installerid,item_master.item_name ,item_master.parent_id,ChallanDetail.TranferInstallerId,challandetail.ConfirmStatus, challandetail.waiting_for_receving from ChallanDetail left join device on ChallanDetail.deviceid=device.device_id left join item_master on device.device_type=item_master.item_id left join device_repair on ChallanDetail.deviceid=device_repair.device_id where  device.device_status=64 and ChallanDetail.branchid=".$branchid." and ChallanDetail.CurrentRecord=1 and ChallanDetail.installerid=".$installerid."",$condition);
		$this->data=db__select("select distinct(device.device_id),device.device_imei,case when device.is_repaired=1 then 'Old device' else 'New Device' end as is_repaired, case when device.is_cracked=1 then 'Client device' else 'Gtrac Device' end as is_cracked,case when device_repair.client_name=null or device_repair.client_name=0 then 'satish' end as client_name,device.itgc_id,device.dispatch_date,installerid,item_master.item_name ,item_master.parent_id,challandetail.TranferInstallerId,challandetail.ConfirmStatus from challandetail left join device on challandetail.DeviceID=device.device_id left join item_master on device.device_type=item_master.item_id left join device_repair on challandetail.DeviceID=device_repair.device_id where  device.device_status=64 and challandetail.branchid=".$branchid." and challandetail.CurrentRecord=1 and challandetail.installerid=".$installerid."",$condition);
		
		return $this->data;
	}
	function getStockModel($model_id)
	{
		$condition = "";
		$this->data=db__select("select item_name from item_master where item_id=".$model_id."",$condition);
		
		return $this->data;
	}
    // function getStockData($installerid,$branchid)
    // {
    //     $condition = "";
        
    //     $this->data=select_query_sql("select device.device_id, device.device_imei, 
    //     case when device.is_repaired=1 then 'Old Device' else 'New Device' end as is_repaired, 
    //     case when device.is_cracked=1 then 'Client Device' else 'Gtrac Device' end as is_cracked,
    //     device.itgc_id,sim.sim_no,device.dispatch_date,installerid,item_master.item_name,item_master.parent_id 
    //     from inventory.challandetail left join inventory.device on challandetail.deviceid=device.device_id 
    //     left join inventory.sim on device.sim_id=sim.sim_id left join
    //     inventory.item_master on device.device_type=item_master.item_id 
    //     where  device.device_status=64 and challandetail.branchid=".$branchid." and 
    //     challandetail.CurrentRecord=1 and challandetail.installerid='".$installerid."' ",$condition);
        
    //     return $this->data;
        
    // }
	
	// function getDeviceImei($DeviceImei)
 //    {
 //        $condition = "";
        
 //        $this->data=select_query_sql("select device_imei,device_type from inventory.device where device_imei='".$DeviceImei."' ",$condition);
        
 //        return $this->data;
        
 //    }
    
    // function getStockModel($model_id)
    // {
    //     $condition = "";
    //     $this->data=select_query_sql("select item_name from inventory.item_master where item_id=".$model_id,$condition);
        
    //     return $this->data;
    // }

    function insertImage($file_name,$installation_id,$image_nos,$request_type)
    {

        $condition = "";
        
        if($request_type=="service")
        {
            if($image_nos==1)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set veh_no_image='".$file_name."' 
                	WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,veh_no_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==2)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set device_image='".$file_name."' 
                	WHERE service_id='".$installation_id."' ",$condition); 
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,device_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}               
            }
            if($image_nos==3)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set earth_con_img='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,earth_con_img) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==4)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set mainpower_img='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,mainpower_img) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==5)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set ignition_image='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,ignition_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==6)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set device_installed_img='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,device_installed_img) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
			if($image_nos==7)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set challan_image='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,challan_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==8)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set sensor_image='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,sensor_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==9)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set sensor_image2='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,sensor_image2) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }            
            if($image_nos==10)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.services_images_tbl where service_id='".$installation_id."'",$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.services_images_tbl set other_image='".$file_name."' 
					WHERE service_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.services_images_tbl(service_id,other_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
        }
        
        if($request_type=="installation")
        {
            if($image_nos==1)
            {                
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set veh_no_image='".$file_name."' 
                	WHERE installion_id='".$installation_id."' ",$condition);					
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,veh_no_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==2)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set device_image='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);    
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,device_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}            
            }
            if($image_nos==3)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set earth_con_img='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,earth_con_img) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==4)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set mainpower_img='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,mainpower_img) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==5)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set ignition_image='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,ignition_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==6)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set device_installed_img='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,device_installed_img) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
			if($image_nos==7)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set challan_image='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,challan_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==8)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set sensor_image='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,sensor_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            if($image_nos==9)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set sensor_image2='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,sensor_image2) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }            
            if($image_nos==10)
            {
                $image_chk = db__select("SELECT * FROM internalsoftware.installation_image_tbl where installion_id='".$installation_id."'",
				$condition);
				
				if(count($image_chk)>0)
				{
					$this->data = db__select("Update internalsoftware.installation_image_tbl set other_image='".$file_name."' 
					WHERE installion_id='".$installation_id."' ",$condition);
				}
				else
				{
					$this->data = db__select("INSERT INTO internalsoftware.installation_image_tbl(installion_id,other_image) 
					VALUES('".$installation_id."','".$file_name."') ",$condition);
				}
            }
            
        }
                
        return count($this->data);
        
    }
    
    function updateInstallation($inst_id,$installation_id,$reason_details,$status,$inst_status)
    {
        //print_r($file_name);
        $condition = "";
          

        $this->data=db__select("INSERT INTO `new_device_addition` (`inst_id`, `date`, `inst_close_date`, `acc_manager`, `client`, `user_id`, `vehicle_no`, `ac`,`immobilizer`,`immobilizer_type`, `device_type`, `device_model`, `device_id`, `device_imei`, `device_sim_num`,installtionRequestID,dimts,sales_manager,inst_name,billing_if_no_reason,billing,comment) VALUES ('".$id."','".$date."','".$rtime."','".$acc_manager."','".$rows[0]['company_name']."',  '".$rows[0]['user_id']."', '".$veh_reg."',  '".$ac."', '".$immobilizer."', '".$immobilizer_type."', '".$device_type."',  '".$resultDevice_inv[0]['item_name']."',  '".$resultDevice_inv[0]['itgc_id']."',  '".$resultDevice_inv[0]['device_imei']."',  '".$resultDevice_inv[0]['phone_no']."', '".$rows[0]['id']."','".$rows[0]['dimts']."','".$sales_name[0]['name']."','".$rows[0]['inst_name']."','".$billing_no_reason."','".$billing."','".$machine."')",$dblink2);

        
        // $this->data=db__select("Update internalsoftware.installation set installation_status='".$inst_status."',failure_reason='".$reason_details."',close_date='".date("Y-m-d")."',inst_date='".date("Y-m-d")."' WHERE id='".$installation_id."'",$condition);
        

                    
        /*$this->data=db__select("Update internalsoftware.installation set installation_status='".$status."', 
                    installer_close_status='".$inst_status."', failure_reason='".$reason_details."' WHERE id='".$installation_id."'",$condition);*/
        //return count($this->data);
        
    }
    
    function updateService($inst_id,$service_id,$reason_details,$status,$inst_status)
    {
        $condition = "";
        
        $this->data=db__select("Update internalsoftware.services set installer_close_status='".$inst_status."', 
                                failure_reason='".$reason_details."' WHERE id='".$service_id."'",$condition);
        
        /*$this->data=db__select("Update internalsoftware.services set service_status='".$status."', installer_close_status='".$inst_status."', 
                                failure_reason='".$reason_details."' WHERE id='".$service_id."'",$condition);*/    
        
        return count($this->data);
        
    }  
	
	function updateDeviceChange($inst_id,$service_id,$reason_details,$status,$inst_status,$change_imei,$replace_with)
    {
        $condition = "";
        
        $this->data=db__select("Update internalsoftware.services set installer_close_status='".$inst_status."', 
                                failure_reason='".$reason_details."', change_imei='".$change_imei."', 
								replace_with='".$replace_with."' WHERE id='".$service_id."'",$condition);
                
        return count($this->data);
        
    }    
    
    function updateVehicleInstallation($installer_id,$installation_id,$vehicle_no)
    {
        $condition = "";
        
        $this->data=db__select("Update internalsoftware.installation set veh_reg='".$vehicle_no."' WHERE id='".$installation_id."'
        and inst_id='".$installer_id."' ",$condition);
                    
        return count($this->data);
        
    }    
    
    function GetKeyByMobile($MobileNum)
    {
        $condition = "";
        
        $this->data = db__select("select * from internalsoftware.mobilekey where mobilenumber=".trim($MobileNum), $condition);
        
        return $this->data;
        
    }
	
	function getClientDeviceData($UserId)
    {
        $condition = "";
		
		$vehicle_id_row = select_query_live_con("SELECT sys_service_id FROM matrix.group_services WHERE sys_group_id=(SELECT sys_group_id FROM matrix.group_users where sys_user_id='".$UserId."')");
	   
		$veh_id_get = "";
		for($re=0;$re<count($vehicle_id_row);$re++)
		{
			$veh_id_get.= $vehicle_id_row[$re]['sys_service_id']."','";
		}
		$veh_id_data=substr($veh_id_get,0,strlen($veh_id_get)-3);
	   		
		$this->data = select_query_live_con("select devices.imei from matrix.services join matrix.devices on devices.id=services.sys_device_id 
		WHERE services.id IN ('".$veh_id_data."')"); 
		       
        return $this->data;
        
    }
    
    
    function send_notification($tokens, $message)
    {
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $fields = array(
            
            'registration_ids' => $tokens,
            
            'data' => $message
            
        );
        
        $headers = array(
            
            'Authorization:key =AIzaSyD9pinPICJTK7ibz_5U69QgZVCyjvGa0DU',
            
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
        
        if ($result === FALSE) {
            
            die('Curl failed: ' . curl_error($ch));
            
        }
        
        curl_close($ch);
        
        return $result;
        
    }
    
    
}
?>