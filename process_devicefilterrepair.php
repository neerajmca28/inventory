<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

// Search By Filtering By Device IMEI
if(isset($_POST['dimei'])){
    $devimei = $_POST['dimei'];
    $searchdevimei=select_Procedure("CALL UniversalSearch_ByRepair('".$devimei."')");
    $searchdevimei=$searchdevimei[0]; 
  
    if(count($searchdevimei) > 0) {
    for($i=0;$i<count($searchdevimei);$i++){

        $opencasedate = date('d-m-Y h:i:s',strtotime($searchdevimei[$i]['opencase_date']));
        $closecasedate = date("d-m-Y H:i:s",strtotime($searchdevimei[$i]['closecase_date']));

          if($opencasedate == '01-01-1970 05:30:00'){
            $opencasedate = '';
          } 
          else {
            $opencasedate;
          }

          if($closecasedate == '01-01-1970 05:30:00'){
            $closecasedate = '';
          } 
          else {
            $closecasedate;
          }

        $abc[$i] = array(
            "device_id"         => $searchdevimei[$i]['device_id'],
            "itgc_id"           => $searchdevimei[$i]['itgc_id'],
            "device_sno"        => $searchdevimei[$i]['device_sno'],
            "device_imei"       => $searchdevimei[$i]['device_imei'],
            "opencase_date"     => $opencasedate,
            "closecase_date"    => $closecasedate,
            "actual_problem"    => $searchdevimei[$i]['actual_problem'],
            "problem"           => $searchdevimei[$i]['problem'],
            "device_removed"    => $searchdevimei[$i]['device_removed_problem'],
            "veh_no"            => $searchdevimei[$i]['veh_no'],
            "client_name"       => $searchdevimei[$i]['client_name']
        );
       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
  }
  else{
    echo $err = "Error";
  }  
}    
// Search End By Filtering By Device IMEI

// Search By Filtering By Client Name
if(isset($_POST['cnm'])){
    $cleintname = $_POST['cnm'];
    $strdate=$_POST['dt1']." 00:00:00";
    $enddate=$_POST['dt2']." 23:59:59";
    $searchdevcleint=select_Procedure("CALL SearchDate_Client('".$cleintname."','".$strdate."','".$enddate."')");
    $searchdevcleint=$searchdevcleint[0]; 

    if(count($searchdevcleint) > 0) {
    for($i=0;$i<count($searchdevcleint);$i++){
        
        $abc[$i] = array(
            "device_id"         => $searchdevcleint[$i]['device_id'],
            "itgc_id"           => $searchdevcleint[$i]['itgc_id'],
            "device_sno"        => $searchdevcleint[$i]['device_sno'],
            "device_imei"       => $searchdevcleint[$i]['device_imei'],
            "opencase_date"     => $searchdevcleint[$i]['opencase_date'],
            "closecase_date"    => $searchdevcleint[$i]['closecase_date'],
            "actual_problem"    => $searchdevcleint[$i]['actual_problem'],
            "problem"           => $searchdevcleint[$i]['problem'],
            "device_removed"    => $searchdevcleint[$i]['device_removed_problem'],
            "veh_no"            => $searchdevcleint[$i]['veh_no'],
            "client_name"       => $searchdevcleint[$i]['client_name']
        );
       $s[$i]=$abc[$i];
        
    }
    echo json_encode($s);
}
  else{
    echo $err = "Error";
  }  
}      
// Search End By Filtering By Client Name

// Search DeviceID
if(isset($_POST['did'])){
    $cleintname = $_POST['did'];
    $searchdevid=select_Procedure("CALL UniversalSearchDeviceID('".$cleintname."')");
    $searchdevid=$searchdevid[0]; 
    //print_r($searchdevid);
    if(count($searchdevid) > 0) {
    for($i=0;$i<count($searchdevid);$i++){
        
        $abc[$i] = array(
            "device_id"         => $searchdevid[$i]['device_id'],
            "itgc_id"           => $searchdevid[$i]['itgc_id'],
            "device_sno"        => $searchdevid[$i]['device_sno'],
            "device_imei"       => $searchdevid[$i]['device_imei'],
            "opencase_date"     => $searchdevid[$i]['opencase_date'],
            "closecase_date"    => $searchdevid[$i]['closecase_date'],
            "actual_problem"    => $searchdevid[$i]['actual_problem'],
            "problem"           => $searchdevid[$i]['problem'],
            "device_removed"    => $searchdevid[$i]['device_removed_problem'],
            "veh_no"            => $searchdevid[$i]['veh_no'],
            "client_name"       => $searchdevid[$i]['client_name']
        );
       $s[$i]=$abc[$i];
        
    }
    echo json_encode($s);
}
  else{
    echo $err = "Error";
  }  
} 
// End Search DeviceID

// Search By Change IMEI -- Change IMEI
if(isset($_POST['scleint'])){
    $searchcleint = $_POST['scleint'];
    $searchclt=select_Procedure("CALL ChangeIMEI_byClient('".$searchcleint."')");
    $searchclt=$searchclt[0]; 
    //print_r($searchdevid);
    for($i=0;$i<count($searchclt);$i++){
        
        $abc[$i] = array(
            "device_id"         => $searchclt[$i]['device_id'],
            "old_device_imei"   => $searchclt[$i]['old_device_imei'],
            "new_device_imei"   => $searchclt[$i]['new_device_imei'],
            "old_client_name"   => $searchclt[$i]['old_client_name'],
            "old_veh_no"        => $searchclt[$i]['old_veh_no'],
            "veh_no"            => $searchclt[$i]['veh_no'],
            "old_itgc_id"       => $searchclt[$i]['old_itgc_id'],
            "new_itgc_id"       => $searchclt[$i]['new_itgc_id'],
        );
       $s[$i]=$abc[$i];
        
    }
    echo json_encode($s);
}
   
//Search End Change IMEI -- Change IMEI

// Search By Change IMEI -- Old Device IMEI
if(isset($_POST['oldimei'])){
    $searcholdimei = $_POST['oldimei'];
    $oldimei=select_Procedure("CALL ChangeIMEI_byDeviceID('".$searcholdimei."')");
    $oldimei=$oldimei[0];
    
    if(count($oldimei) > 0) {
    for($i=0;$i<count($oldimei);$i++){
        
        $abc[$i] = array(
            "device_id"         => $oldimei[$i]['device_id'],
            "old_device_imei"   => $oldimei[$i]['old_device_imei'],
            "new_device_imei"   => $oldimei[$i]['new_device_imei'],
            "old_client_name"   => $oldimei[$i]['old_client_name'],
            "old_veh_no"        => $oldimei[$i]['old_veh_no'],
            "veh_no"            => $oldimei[$i]['veh_no'],
            "old_itgc_id"       => $oldimei[$i]['old_itgc_id'],
            "new_itgc_id"       => $oldimei[$i]['new_itgc_id'],
        );
       $s[$i]=$abc[$i];
        
    }
    echo json_encode($s);
}
  else{
    echo $err = "Error";
  }  
}    
// Search By Change IMEI -- Old Device IMEI
