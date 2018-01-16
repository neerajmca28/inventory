<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php");

if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}

$masterObj = new master();

$imei = $_POST['imei'];
$simid = $_POST['simid'];
$phno = $_POST['phnumber'];
$device = $_POST['deviceid'];
$devicestatus = $TempraryAttachment;

$strDeviceID = $masterObj->selectServices($phno);

$strSqlQuery = $masterObj->updateDeviceImei($imei,$strDeviceID);

$attachSimTemp=select_Procedure("CALL AttachPhoneNo('".$device."','".$simid."','".$devicestatus."')");

?>