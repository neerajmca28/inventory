<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

// Select Model No.
if(isset($_POST['dPId'])){
    $parentId = $_POST['dPId'];

    $devParentId=select_Procedure("CALL SelectDevTypeModel('".$parentId."')"); 
    $devParentId=$devParentId[0];


    for($i=0;$i<count($devParentId);$i++){
      
        $abc[$i] = array(

            "item_id"  => $devParentId[$i]['item_id'],
            "item_name" => $devParentId[$i]['item_name'],
            
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
}    
// End Select Model No.

// Submit Request New Device
if(isset($_POST['brnchid'])){
   // print_r($_POST); die;
    $brnch_id = $_POST['brnchid'];
    $remarks = $_POST['remark'];
    $devicetype = $_POST['dvtype'];
     $crnt_date = date('Y-m-d H:i:s',strtotime($_POST['date']));
    $no_Device = $_POST['nodev'];
    $device_model = $_POST['modelno'];
    $device_condition = $_POST['condition'];
        
    //echo "CALL SaveRequestedNewDevice('".$brnch_id."','".$remarks."','".$devicetype."','".$crnt_date."','".$no_Device."','".$device_model."','".$device_condition."')"; die;

    $reqSaveNewDevice=select_Procedure("CALL SaveRequestedNewDevice('".$brnch_id."','".$remarks."','".$devicetype."','".$crnt_date."','".$no_Device."','".$device_model."','".$device_condition."')"); 
    //echo count($reqSaveNewDevice); die;
    if(count($reqSaveNewDevice)!=0);
    {
        echo "success";
    } 
    //$reqSaveNewDevice=$reqSaveNewDevice[0];
    
}    
// End Submit Request New Device
    