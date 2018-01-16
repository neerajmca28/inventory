<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matrix";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// $result=mysql_query("select device_id,itgc_id,device_sno from device limit 10;");
//  while($row = mysql_fetch_array($result)) {
//         echo "id: " . $row["device_id"]. "<br>";
//     } 			
// //echo $row=mysql_num_rows($dev_rep); 	die;	

$sql="select sys_Service_id,veh_reg,DATE_ADD(gps_time, INTERVAL 330 MINUTE) as gps_time,round(gps_speed*1.609,2) as gps_speed,gps_latitude,gps_longitude  from matrix.overspeed_yesterday left join services on overspeed_yesterday.sys_service_id=services.id where sys_service_id in(33878,46413,49633,49646) and gps_time>'2017-06-05 18:30:59' and round(gps_speed*1.609,2)>70 order by sys_service_id,gps_time";
	$fetch_result=mysqli_query($conn,$sql);
$rowCount = 1; 
if (mysqli_num_rows($fetch_result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_array($fetch_result)) {
       // echo "id: " . $row["sys_Service_id"]. "<br>";
    	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']); 
    	$rowCount++; 
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>