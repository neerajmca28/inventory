<?php
include("config.php");

 $mysql = new mysqli("203.115.101.30","attendantapp","attendantapp","livetrack", 3306);
$rows = array();
 $result = array();

$geo_street=$_POST['geo_street'];
$geo_district=$_POST['geo_district'];
$geo_town=$_POST['geo_town'];
$geo_country=$_POST['geo_country'];
$id=$_POST['id'];
$gps_latitude=$_POST['gps_latitude'];
$gps_longitude=$_POST['gps_longitude'];
$location=$_POST['location'];//."priya".$_POST['geo_street'];
//echo 'tt'; die;
//if(($geo_street!='')&& (!empty($geo_street)))
//{
	//echo "UPDATE livetrack.tbl_geodata_itgc_internal SET geo_street='".$geo_street."',geo_district='".$geo_district."',geo_town='".$geo_town."',geo_country='".$geo_country."',location='".$location."',status=1 WHERE id='".$id."' AND gps_latitude='".$gps_latitude."' AND gps_longitude='".$gps_longitude."' AND status!=1"; die;
	$result = $mysql->query("UPDATE livetrack.tbl_geodata_itgc_internal SET geo_district='".$geo_district."',geo_town='".$geo_town."',geo_country='".$geo_country."',geo_street='".$location."',extra='".$geo_street."',status=1 WHERE id='".$id."' AND status!=1");
	if($result)
	{
			$result["message"] = true;
	}
	else
	{
			$result["message"] = false;
	}
	 echo json_encode($result);
	
//}

?>