<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
//ini_set('memory_limit', '8192M');

// Search ITGC Id
if(isset($_POST['it1'])){
    $itgcid = $_POST['it1']."X".$_POST['it2'];
    $searchitgcid=select_Procedure("CALL SearchItgcId('".$itgcid."')");
    $searchitgcid=$searchitgcid[0]; //Check -- 4120X1359495
  
    if(count($searchitgcid) > 0) {
    for($i=0;$i<count($searchitgcid);$i++){
        $state=$searchitgcid[$i]['dispatch_branch'];
        if($state == 1){
          $state1 = "Delhi";
        }
        if($state == 2){
          $state1 = "Mumbai";
        }
        if($state == 3){
          $state1 = "Jaipur";
        }
        if($state == 4){
          $state1 = "Sonepat";
        }
        if($state == 5){
          $state1 = "Kanpur";
        }
        if($state == 6){
          $state1 = "Ahmedabad";
        }
        if($state == 7){
          $state1 = "Kolkata";
        }

        $abc[$i] = array(
            "itgc_id"  => $searchitgcid[$i]['itgc_id'],
            "device_id" => $searchitgcid[$i]['device_id'],
            "device_sno" => $searchitgcid[$i]['device_sno'],
            "device_imei" => $searchitgcid[$i]['device_imei'],
            "recd_date" => date('d-m-Y H:i:s',strtotime($searchitgcid[$i]['recd_date'])),
            "item_name" => $searchitgcid[$i]['item_name'],
            "status" => $searchitgcid[$i]['status'],
            "dispatch_branch" => $state,
            "phone_no" => $searchitgcid[$i]['phone_no'],
            "sim_no" => $searchitgcid[$i]['sim_no']
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
  }
  else{
    echo $err = "Error";
  }  
}    
// Search End ITGC Id

// Search Filter ID
if(isset($_POST['key'])){
    $filterkey = $_POST['key']; 

    $searchid=select_Procedure("CALL UniversalSearch('".$filterkey."','".$filterkey."','".$filterkey."','".$filterkey."','".$filterkey."')");

    $searchid=$searchid[0];
   
   // print_r($searchid); die;
	if(count($searchid) > 0) {
    for($i=0;$i<count($searchid);$i++){
      
        $state=$searchid[$i]['dispatch_branch'];
        if($state == 1){
          $state1 = "Delhi";
        }
        if($state == 2){
          $state1 = "Mumbai";
        }
        if($state == 3){
          $state1 = "Jaipur";
        }
        if($state == 4){
          $state1 = "Sonepat";
        }
        if($state == 5){
          $state1 = "Kanpur";
        }
        if($state == 6){
          $state1 = "Ahmedabad";
        }
        if($state == 7){
          $state1 = "Kolkata";
        }

        $abc[$i] = array(
            "itgc_id"  => $searchid[$i]['itgc_id'],
            "device_id" => $searchid[$i]['device_id'],
            "device_sno" => $searchid[$i]['device_sno'],
            "device_imei" => $searchid[$i]['device_imei'],
            "recd_date" => date('d-m-Y H:i:s',strtotime($searchid[$i]['recd_date'])),
            "item_name" => $searchid[$i]['item_name'],
            "status" => $searchid[$i]['status'],
            "dispatch_branch" => $state1,
            "phone_no" => $searchid[$i]['phone_no'],
            "sim_no" => $searchid[$i]['sim_no']
        );
        $s[$i]=$abc[$i]; 
        //print_r($abc[$i]);
    }
    echo json_encode($s);
 }
  else{
    echo $err = "Error";
  }  
}
// End Search Filter ID

// Search Device Type & Status
if(isset($_POST['dtype'])){
    $dtype = $_POST['dstatus'];
    $dstatus = $_POST['dtype'];

    $searchdate=select_Procedure("CALL SearchDeviceStatus('".$dstatus."','".$dtype."')"); // Installed -----  Pointer
    $searchdate=$searchdate[0]; 
    //print_r($searchdate);
    if(count($searchdate) > 0) {
    for($i=0;$i<count($searchdate);$i++){
      
        $state=$searchdate[$i]['dispatch_branch'];
        if($state == 1){
          $state1 = "Delhi";
        }
        if($state == 2){
          $state1 = "Mumbai";
        }
        if($state == 3){
          $state1 = "Jaipur";
        }
        if($state == 4){
          $state1 = "Sonepat";
        }
        if($state == 5){
          $state1 = "Kanpur";
        }
        if($state == 6){
          $state1 = "Ahmedabad";
        }
        if($state == 7){
          $state1 = "Kolkata";
        }

        $abc[$i] = array(

            "itgc_id"  => $searchdate[$i]['itgc_id'],
            "device_id" => $searchdate[$i]['device_id'],
            "device_sno" => $searchdate[$i]['device_sno'],
            "device_imei" => $searchdate[$i]['device_imei'],
            "recd_date" => date('d-m-Y H:i:s',strtotime($searchdate[$i]['recd_date'])),
            "item_name" => $searchdate[$i]['item_name'],
            "status" => $searchdate[$i]['status'],
            "dispatch_branch" => $state1,
            "phone_no" => $searchdate[$i]['phone_no'],
            "sim_no" => $searchdate[$i]['sim_no']
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
  }
  else{
    echo $err = "Error";
  }  
}
// End Search Device Type & Status

// Search Date
if(isset($_POST['dt1'])){
    $dt1 = $_POST['dt1'];
    $dt2 = $_POST['dt2'];
    $searchdate=select_Procedure("CALL SearchDate('".$dt1."','".$dt2."',1)");
    $searchdate=$searchdate[0]; 
    //print_r($searchdate);
    for($i=0;$i<count($searchdate);$i++){

        $simno1 = $searchdate[$i]['sim_no'];
        //print_r($simno1);
        if($simno1 == null){
            $simno1 = "";
        }

        $state=$searchdate[$i]['dispatch_branch'];
        if($state == 1){
          $state1 = "Delhi";
        }
        if($state == 2){
          $state1 = "Mumbai";
        }
        if($state == 3){
          $state1 = "Jaipur";
        }
        if($state == 4){
          $state1 = "Sonepat";
        }
        if($state == 5){
          $state1 = "Kanpur";
        }
        if($state == 6){
          $state1 = "Ahmedabad";
        }
        if($state == 7){
          $state1 = "Kolkata";
        }

        $abc[$i] = array(

            "itgc_id"  => $searchdate[$i]['itgc_id'],
            "device_id" => $searchdate[$i]['device_id'],
            "device_sno" => $searchdate[$i]['device_sno'],
            "device_imei" => $searchdate[$i]['device_imei'],
            "recd_date" => date('d-m-Y H:i:s',strtotime($searchdate[$i]['recd_date'])),
            "item_name" => $searchdate[$i]['item_name'],
            "status" => $searchdate[$i]['status'],
            "dispatch_branch" => $state1,
            "phone_no" => $searchdate[$i]['phone_no'],
            "sim_no" => $simno1
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
}
// End Search Date

// Search Cleint Name
if(isset($_POST['clientName'])){
    $clientName = $_POST['clientName'];
    
    $searchclnt=select_Procedure("CALL SearchClient('".$clientName."')"); // prabhakar
    $searchclnt=$searchclnt[0];
    
    if(count($searchclnt) > 0) {
    for($i=0;$i<count($searchclnt);$i++){

        $simno1 = $searchclnt[$i]['sim_no'];
        if($simno1 == null){
            $simno1 = "";
        }
      
        $state=$searchclnt[$i]['dispatch_branch'];
        if($state == 1){
          $state1 = "Delhi";
        }
        if($state == 2){
          $state1 = "Mumbai";
        }
        if($state == 3){
          $state1 = "Jaipur";
        }
        if($state == 4){
          $state1 = "Sonepat";
        }
        if($state == 5){
          $state1 = "Kanpur";
        }
        if($state == 6){
          $state1 = "Ahmedabad";
        }
        if($state == 7){
          $state1 = "Kolkata";
        }

        $abc[$i] = array(

            "itgc_id"  => $searchclnt[$i]['itgc_id'],
            "device_id" => $searchclnt[$i]['device_id'],
            "device_sno" => $searchclnt[$i]['device_sno'],
            "device_imei" => $searchclnt[$i]['device_imei'],
            "recd_date" => date('d-m-Y H:i:s',strtotime($searchclnt[$i]['recd_date'])),
            "item_name" => $searchclnt[$i]['item_name'],
            "status" => $searchclnt[$i]['device_status'],
            "dispatch_branch" => $state1,
            "phone_no" => $searchclnt[$i]['phone_no'],
            "sim_no" => $simno1
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
    }
  else{
    echo $err = "Error";
  } 
}    
// End Search Cleint Name

// Search Dispatch Report
if(isset($_POST['dt3'])){
    $dt3 = $_POST['dt3'];
    $dt4 = $_POST['dt4'];
    $searchdate=select_Procedure("CALL SearchDate('".$dt3."','".$dt4."',2)");
    $searchdate=$searchdate[0]; 
   // print_r($searchdate);
    for($i=0;$i<count($searchdate);$i++){
      
        $state=$searchdate[$i]['dispatch_branch'];
        if($state == 1){
          $state1 = "Delhi";
        }
        if($state == 2){
          $state1 = "Mumbai";
        }
        if($state == 3){
          $state1 = "Jaipur";
        }
        if($state == 4){
          $state1 = "Sonepat";
        }
        if($state == 5){
          $state1 = "Kanpur";
        }
        if($state == 6){
          $state1 = "Ahmedabad";
        }
        if($state == 7){
          $state1 = "Kolkata";
        }

        $abc[$i] = array(

            "itgc_id"  => $searchdate[$i]['itgc_id'],
            "device_id" => $searchdate[$i]['device_id'],
            "device_sno" => $searchdate[$i]['device_sno'],
            "device_imei" => $searchdate[$i]['device_imei'],
            "recd_date" => date('d-m-Y H:i:s',strtotime($searchdate[$i]['recd_date'])),
            "item_name" => $searchdate[$i]['item_name'],
            "status" => $searchdate[$i]['status'],
            "dispatch_branch" => $state1,
            "phone_no" => $searchdate[$i]['phone_no'],
            "sim_no" => $searchdate[$i]['sim_no']
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
}
// End Search Dispatch Report

?>