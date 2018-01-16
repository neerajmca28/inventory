<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

if(isset($_POST['portNumber'])){
    $portNo = $_POST['portNumber'];
    $strSqlQuery =db__select_matrix("select  veh_reg,adddate(latest_telemetry.gps_time,INTERVAL 19800 second) as lastconta,latest_telemetry.des_movement_id as port,devices.imei,mobile_simcards.mobile_no from services join latest_telemetry on latest_telemetry.sys_service_id=services.id join devices on devices.id=services.sys_device_id  join mobile_simcards on mobile_simcards.id=devices.sys_simcard where latest_telemetry.des_movement_id='".$portNo."' order by gps_time desc");

    if(count($strSqlQuery) > 0) {
    for($i=0;$i<count($strSqlQuery);$i++){
       
          $abc[$i] = array(
              "veh_reg"  => $strSqlQuery[$i]['veh_reg'],
              "lastconta" => date('d-m-Y H:i:s',strtotime($strSqlQuery[$i]['lastconta'])),
              "port" => $strSqlQuery[$i]['port'],
              "imei" => $strSqlQuery[$i]['imei'],
              "mobile_no" => $strSqlQuery[$i]['mobile_no']
          );
         $s[$i]=$abc[$i]; 
      }
      echo json_encode($s);
    }
    else{
      echo $err = "Error";
    }  
} 