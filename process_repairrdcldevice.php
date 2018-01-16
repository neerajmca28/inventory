<?php
error_reporting(0);
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

// Search Dispatch Report
if(isset($_POST['dt1'])){
    $dt3 = $_POST['dt1'];
    $dt4 = $_POST['dt2'];
    $searchdate=select_Procedure("CALL RepairCloseRDdevice('".$dt3."','".$dt4."')");
    $searchdate=$searchdate[0]; //Check -- 4120X1359495
    //print_r($searchdate);
    for($i=0;$i<count($searchdate);$i++){
      
        $abc[$i] = array(
            "device_id"  => $searchdate[$i]['device_id'],
            "device_imei" => $searchdate[$i]['device_imei'],
            "client_name" => $searchdate[$i]['client_name'],
            "veh_no" => $searchdate[$i]['veh_no'],
            "status" => $searchdate[$i]['status'],
            "opencase_date" => date("d-m-Y H:i:s",strtotime($searchdate[$i]['opencase_date'])),
            "closecase_date" => date("d-m-Y H:i:s",strtotime($searchdate[$i]['closecase_date'])),
            "opencaseproblem" => $searchdate[$i]['opencaseproblem'],
            "closecaseproblem" => $searchdate[$i]['closecaseproblem'],
            "device_removed_remarks" => $searchdate[$i]['device_removed_remarks'],
            "ManufactureRemarks" => $searchdate[$i]['ManufactureRemarks']
         );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
}    
// End Search Dispatch Report
?>