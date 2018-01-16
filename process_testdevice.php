<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php");

if(isset($_POST['device_sno'])){

    $device = $_POST['device_sno'];
    $devicestatus = $Tested;
    //echo "CALL AttachPermentPhoneNo('".$device."','".$simid."','".$devicestatus."')"; die;
    $attachSim=select_Procedure("CALL SetTested('".$device."','".$devicestatus."')");
    print_r($attachSim);
    //$attachSim=$attachSim[0];
}

