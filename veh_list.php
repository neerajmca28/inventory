<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//print_r($_POST); die;
$q=$_POST['val'];
$res_veh="";
$data=db__select_matrix("select services.id as id,veh_reg from matrix.services where services.id in(select distinct sys_service_id from matrix.group_services where active=true and sys_group_id in(select sys_group_id from matrix.group_users where sys_user_id=('".$q."')))"); 
$res_veh.= '0'.'~'."Select".'#'; 
for($x=0;$x<count($data);$x++)
{
	$res_veh.= $data[$x]['id'].'~'.$data[$x]['veh_reg'].'#';
}
echo  $veh_list=substr($res_veh,0,strlen($res_veh)-1);

		
?>