<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//print_r($_POST); die;
$brand_id=$_POST['val'];
$res_model="";
$modelList=select_Procedure("CALL SelectDevTypeModel($brand_id)");
$modelList=$modelList[0];
//print_r($modelList);die;
$x=0;
$res_model.= $x.'~'."Select Model Type".'#'; 
for($x=0;$x<count($modelList);$x++)
{
	$res_model.= $modelList[$x]['item_id'].'~'.$modelList[$x]['item_name'].'#';
}
echo  $model_list=substr($res_model,0,strlen($res_model)-1); 

		
?>