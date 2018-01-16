<?php
//include("config.php");

 $mysql = new mysqli("203.115.101.30","attendantapp","attendantapp","livetrack", 3306);


$result = $mysql->query("select id,gps_latitude,gps_longitude from livetrack.tbl_geodata_itgc_internal where status!=1 order by id limit 100");

//$result = $mysql->query("select id,gps_latitude,gps_longitude from livetrack.tbl_geodata_itgc_internal where id=1576  ");
 $rows = array();
while($row = $result->fetch_array(MYSQL_ASSOC)) {
$rows[] = array_map("utf8_encode", $row);
}
echo json_encode($rows);
?>