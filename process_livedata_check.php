<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
$masterObj = new master();
 function array_msort($array, $cols)
	{
		$colarr = array();
		foreach ($cols as $col => $order) {
	  $colarr[$col] = array();
	  foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
	 }

	 $eval = 'array_multisort(';
	 
	 foreach ($cols as $col => $order) {
	  $eval .= '$colarr[\''.$col.'\'],'.$order.',';
	 }

	 $eval = substr($eval,0,-1).');';
	 eval($eval);
	 $ret = array();
	 foreach ($colarr as $col => $arr) 
	 {
		  foreach ($arr as $k => $v) 
		  {
		   $k = substr($k,1);
		   if (!isset($ret[$k])) $ret[$k] = $array[$k];
		   $ret[$k][$col] = $array[$k][$col];
		  }
	}
	return $ret;

	} 
if($_POST)
{
	   
	
	$imei_no=$_POST['imei_no']; 
		 
		$dataservices=$masterObj->newQryService($imei_no); 
		 
		//echo '<pre>'; print_r($dataservices[0]['veh_reg']);'</pre>'; 
		//echo count($dataservices); die;
	
	if(count($dataservices)>0)
	{
		   $Serviceid=$dataservices[0]["id"];
		 $Veh_reg=$dataservices[0]["veh_reg"];
		//  $queryAppend="where sys_Service_id =".$Serviceid; 
		if($imei_no!="" || $Serviceid!="")
		{ 

			  $navData[]=$masterObj->navData($Serviceid); 
			 $data1=array();
   for($countNavData=0;$countNavData<count($navData);$countNavData++)
   {
    if(is_array($navData[$countNavData]))
    {
     $data1=array_merge($data1,$navData[$countNavData]);
    }
   }
    $data2 = array_msort($data1, array('gps_time'=>SORT_DESC));
    foreach($data2 as $val)
    {
     $data = $val;
    }
			   
		}
		
			 
			 
	}
	 
if(count($data)>0)
{
	for($row=0;$row<1;$row++)
	{
		 $tt='ID-'.$IMEI.',GPSdate-'.$data[$row]['gps_time'].',Indiadate-'.$data[$row]['india_time'].',Lat-'.$data[$row]['gps_latitude'].',Long-'.$data[$row]['gps_longitude'].',Speed-'.$data[$row]['gps_speed'].',AC-'.$data[$row]['AC'].',GPS-'.$data[$row]['gps_fix'].',MainPower-'.$data[$row]['main_powervoltage'].',BatteryPower-1,MainpowerVol-'.$data[$row]['main_powervoltage'].',Temp-'.$data[$row]['tel_temperature'].',IGN-'.$data[$row]['tel_input_0'].',panic-'.$data[$row]['tel_panic'].',Port-'.$data[$row]['port'];
		  "\n";
	}
	?>
<div class="content-box">
		<div class="left-item"><span><strong>String:<?=" " .$Veh_reg." (".$imei_no.")";?></strong></span> </div>
        <td><textarea id="data_string" name="data_string"  class="form-control"><?php echo $tt; ?></textarea></td>
		</div>
		 <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th> gps_time</th>
              <th> india_time</th>
              <th> gps_latitude</th>
              <th> gps_longitude </th>
              <th> gps_speed</th>
              <th> port </th>
			  <th>AC </th>
              <th>tel_panic </th>
              <th> tel_fuel </th>
			  <th> Ignition</th>
              <th> Door</th>
              <th>Bonnet</th>
              <th>tel_input_3 </th>
			  <th> tel_temperature </th>
			    <th>tel_voltage </th>
			  <th> main_powervoltage </th>
			     <th>gps_fix </th>
			  <th> Tel Fuel </th>
			    <th>Odometer</th>
            </tr>
          </thead>
          <tbody>
            <?php 

		for($row=0;$row<count($data);$row++)
			{
				
            ?>
            <tr>
        
  
			  <td><?php echo $data[$row]['gps_time']; ?></td>

					<td><?php echo $data[$row]['india_time']; ?></td>
					<td><?php echo $data[$row]['gps_latitude'];?></td>
					<td><?php echo $data[$row]['gps_longitude']; ?></td>
					<td><?php echo $data[$row]['gps_speed']; ?></td>
					<td><?php echo $data[$row]['port']; ?></td>
					<td><?php echo $data[$row]['AC']; ?></td>
					<td><?php echo $data[$row]['tel_panic']; ?></td>
					<td><?php echo $data[$row]['tel_fuel']; ?></td>
					<td><?php echo $data[$row]['tel_input_0']?></td>
					<td><?php echo $data[$row]['tel_input_1']?></td>
					<td><?php echo $data[$row]['tel_input_2']?></td>
					<td><?php echo $data[$row]['tel_input_3']?></td>
					<td><?php echo $data[$row]['tel_temperature']?></td>
					<td><?php echo $data[$row]['tel_voltage']?></td>
					<td><?php echo $data[$row]['main_powervoltage']?></td>
					<td><?php echo $data[$row]['gps_fix']?></td> 
					<td><?php echo "battery lbl:-> ".$data[$row]['tel_rfid']?></td>
					<td><?php echo $data[$row]['tel_fuel']?></td> 
					<td><?php echo $data[$row]['tel_hours']?></td> 
	
  
             
            </tr>
			<?php } ?>
			 </tbody>
			   </table>
<?php }
else
{
	echo '<span style="color:#FF0000;text-align:center;">There is no Record.';
}
}
	
?>
		



		
