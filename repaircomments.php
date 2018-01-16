<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

//Comment Add Repair

if(isset($_POST['devid'])){
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
    