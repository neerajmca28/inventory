<?php
session_start();
//include_once(__DOCUMENT_ROOT.'/config.php');
include_once(__DOCUMENT_ROOT.'/private/lib/library_common.php');


class master
{


	function getUserData($user_name, $password)
	{
		$condition = "";
		
		$this->data=db__select("select * from internalsoftware.installer where user_name='".$user_name."' and installer_mobile='".$password."' and is_active=1 and is_delete=1", $condition);
		
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
		
		$this->data=db__select("select * from internalsoftware.installer where user_name='".$user_name."' and installer_mobile='".$password."' and is_active=1 and is_delete=1 and inst_id='".$installerid."' and branch_id='".$branchid."'", $condition);
		
		return $this->data;
	}
	
	function getServiceData($installerid,$branchid)
	{
		

		$condition = "";
		$this->data=db__select("select installer.inst_id,installer.inst_name,services.id,services.req_date,services.name as UserName, services.company_name, services.user_id,services.veh_reg,services.device_imei,services.service_status as running_status,services.request_by,services.device_model as model,services.pname as contact_person,services.cnumber as contact_number,services.Zone_area as Zone_area,services.job_type as job_type, re_city_spr_1.name as area,services.location as location,case when services.IP_Box='Yes' then 'Yes' else 'No' end as IP_Box,case when services.ac_status='Yes' then 'Yes' else 'No' end as ac_status,case when services.immobilizer_status='Yes' then 'Yes' else 'No' end as immobilizer_status,re_city_spr_1.id_region,zone.name as zone,'service' as req_type from installer  left join services on installer.inst_id=services.inst_id  left join re_city_spr_1 on services.Zone_area=re_city_spr_1.id left join zone on re_city_spr_1.id_region=zone.id WHERE services.job_type=1 AND services.inst_id=".$installerid." AND services.service_status=2 ORDER BY services.req_date DESC", $condition);
		
		return $this->data;
	
	}
	
	function getInstallationData($installerid,$branchid)
	{
		$condition = "";
		//case when installation.fuel_sensor='Yes' then 'Yes' else 'No' end as fuel_sensor
		$this->data=db__select("select installer.inst_id, installer.inst_name, installation.id, installation.req_date, addclient.UserName, installation.company_name, installation.user_id as user_id,installation.veh_reg,installation.installation_status as running_status, installation.request_by,installation.model as model,installation.Zone_area as Zone_area,installation.job_type as job_type,installation.contact_person,installation.contact_number,re_city_spr_1.name as area,installation.location as location,re_city_spr_1.id_region,zone.name as zone,'installation' as req_type, case when installation.IP_Box='Yes' then 'Yes' else 'No' end as IP_Box,case when installation.fuel_sensor='Yes' then 'Yes' else 'No' end as fuel_sensor,case when installation.bonnet_sensor='Yes' then 'Yes' else 'No' end as bonnet_sensor,case when installation.rfid_reader='Yes' then 'Yes' else 'No' end as rfid_reader,case when installation.speed_alarm='Yes' then 'Yes' else 'No' end as speed_alarm,case when installation.door_lock_unlock='Yes' then 'Yes' else 'No' end as door_lock_unlock,case when installation.temperature_sensor='Yes' then 'Yes' else 'No' end as temperature_sensor,case when installation.duty_box='Yes' then 'Yes' else 'No' end as duty_box,case when installation.panic_button='Yes' then 'Yes' else 'No' end as panic_button  from installer  left join installation on installer.inst_id=installation.inst_id  left join re_city_spr_1 on installation.Zone_area=re_city_spr_1.id  left join zone on re_city_spr_1.id_region=zone.id left join addclient on installation.user_id=addclient.Userid WHERE installation.inst_id=".$installerid." AND installation.installation_status=2  ORDER BY installation.req_date DESC", $condition);
		
		return $this->data;
	
	}
	
	function getStockData($installerid,$branchid)
	{
		
		$condition = "";
		$this->data=select_query_sql("select device.device_id,device.device_imei,device_repair.client_name,device.itgc_id,
									device.dispatch_date,installerid,device.is_repaired,item_master.item_name ,item_master.parent_id from ChallanDetail left join device on ChallanDetail.deviceid=device.device_id left join item_master on device.device_type=item_master.item_id left join device_repair on ChallanDetail.deviceid=device_repair.device_id where  device.device_status=64 and ChallanDetail.branchid=".$branchid." and ChallanDetail.CurrentRecord=1 and ChallanDetail.installerid=".$installerid."",$condition);
		
		return $this->data;
	
	}
	
	function getStockModel($model_id)
	{
		$condition = "";
		$this->data=select_query_sql("select item_name from item_master where item_id=".$model_id."",$condition);
		
		return $this->data;
	}
	
	function insertDeviceImage($file_name,$client_id,$imei_no,$veh_no,$device_id)
	{
		
		//print_r($file_name);
		$condition = "";
		$dispatch_insert = "INSERT INTO internalsoftware.device_image (file_name,client_id,imei_no,veh_reg,device_id) VALUES('".$file_name."','".$client_id."','".$imei_no."','".$veh_no."','".$device_id."')";
		db__select($dispatch_insert,$condition);		
		
		return $this->data;
	}
	
	function updateInstallation($inst_id,$installation_id,$close_status)
	{
		//print_r($file_name);
		$condition = "";
		$installation_update = "Update internalsoftware.installation set installation_status='".$close_status."' WHERE inst_id='".$inst_id."' and id='".$installation_id."'";
		db__select($installation_update,$condition);		
		
		return $this->data;
	}
	
	function updateService($inst_id,$service_id,$close_status)
	{
		//print_r($file_name);
		$condition = "";
		//echo "Update internalsoftware.service set service_status='".$close_status."' WHERE inst_id='".$inst_id."' and id='".$service_id."'"; die;
		$installation_update = "Update internalsoftware.installation set service_status='".$close_status."' WHERE inst_id='".$inst_id."' and id='".$service_id."'";
		db__select($installation_update,$condition);		
		
		return $this->data;
	}


}

?>