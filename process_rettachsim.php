<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

// Reattach Sim
//print_r($_POST);die();
if (isset($_POST['oldNumber']) && isset($_POST['newNumber'])) {

    $oldid = $_POST['oldNumber'];
    $newid = $_POST['newNumber'];
    //echo "CALL ReattachSim('".$newid."','".$oldid."')";
    $ReattachSim=select_Procedure("CALL ReattachSim('".$newid."','".$oldid."')"); 
   
}   
// End Reattach Sim

// Deattach Sim
if (isset($_POST['oldNumber'])) {

    $dettach_sim= $_POST['oldNumber'];
   	$deattachsim=select_Procedure("CALL DettachSim('".$dettach_sim."')");
   
}   
// End Deattach Sim