<?
include_once('../../inc/chk_debug.php');

include_once('../../inc/connect.php');

include_once('../../inc/functions.php');
 
include_once('../../lib/cls_listall_ajax.php');
 
date_default_timezone_set("Asia/Calcutta");
?>

<style>
table.std {
    margin: 1em;
	font-size:11px;
}
table.std td, table.std th {
    padding: 0.3em;
}
table.std th {
   color: white;
}
.bordered {
    border: 1px solid #CCCCCC;
}
.border td, .border th, .hilite td, .hilite th, .clickon td, .clickon th {
    border: 1px solid #CCCCCC;
}
.coll, .hilite, .clickon {
    border-collapse: collapse;
}
.thback thead, .hilite thead, .clickon thead {
    background: none repeat scroll 0 0 #777D6A;
}
.tbback tbody, .hilite tbody, .clickon tbody {
    background: none repeat scroll 0 0 #99CCFF;
}
#highlight tr.hilight {
    background: none repeat scroll 0 0 #CC99FF;
}
#clickme tr.clicked {
    background: none repeat scroll 0 0 #FFFF00;
}
.separate {
    margin-top: 400px;
}
</style> 
<?
$pagesize=20;
  
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
 foreach ($colarr as $col => $arr) {
  foreach ($arr as $k => $v) {
   $k = substr($k,1);
   if (!isset($ret[$k])) $ret[$k] = $array[$k];
   $ret[$k][$col] = $array[$k][$col];
  }
 }
 return $ret;

} 
  $IMEI=trim(safe($_POST['userid']));

  $newQryService="select services.id,veh_reg from services left join devices 
on services.sys_device_id=devices.id 
where devices.imei = ".$IMEI;
			   $dataservices=select_query($newQryService);



if(count($dataservices)>0)
{
	   $Serviceid=$dataservices[0]["id"];
	    $Veh_reg=$dataservices[0]["veh_reg"];
	 $queryAppend="where sys_Service_id =".$Serviceid;
	 // gps_time<=now() and sys_msg_type=1  and

//echo "This service is currently not availbale";die();
  if($IMEI!="" || $queryAppend!="")
  {

	  
 
       $newQry="select sys_Service_id,gps_time,ADDDATE( gps_time, INTERVAL 330 MINUTE) as india_time,gps_latitude,gps_longitude,gps_speed,des_movement_id as port,case when tel_ignition=true then true else false end as AC,case when tel_panic=true then true else false end as tel_panic,tel_rawlog,tel_fuel,case when tel_input_0=true then true else false end as tel_input_0,case when tel_input_1=true then true else false end as tel_input_1,case when tel_input_2=true then true else false end as tel_input_2,tel_input_3,tel_temperature,tel_voltage,main_powervoltage,gps_fix,tel_rfid,tel_fuel,tel_odometer,tel_hours from today_ideal  ".$queryAppend." and ADDDATE(gps_time,INTERVAL 19800 SECOND)>=ADDDATE(NOW(),INTERVAL -65 minute)";
 
			   $navData[]=select_query($newQry); 

// if(count($data)<5)
//{
				   //$queryAppend="where today_ideal.tel_rawlog like '".$IMEI."-%' ";
				     $newQry="select sys_Service_id,gps_time,ADDDATE( gps_time, INTERVAL 330 MINUTE) as india_time,gps_latitude,gps_longitude,gps_speed,des_movement_id as port,case when tel_ignition=true then true else false end as AC,case when tel_panic=true then true else false end as tel_panic,tel_rawlog,tel_fuel,case when tel_input_0=true then true else false end as tel_input_0,case when tel_input_1=true then true else false end as tel_input_1,case when tel_input_2=true then true else false end as tel_input_2,tel_input_3,tel_temperature,tel_voltage,main_powervoltage,gps_fix,tel_rfid,tel_fuel,tel_odometer,today_speed.tel_hours from today_speed ".$queryAppend." and ADDDATE(gps_time,INTERVAL 19800 SECOND)>=ADDDATE(NOW(),INTERVAL -65 minute)";
 
			   $navData[]=select_query($newQry); 

			     $newQry="select sys_Service_id,gps_time,ADDDATE( gps_time, INTERVAL 330 MINUTE) as india_time,gps_latitude,gps_longitude,gps_speed,des_movement_id as port,case when tel_ignition=true then true else false end as AC,case when tel_panic=true then true else false end as tel_panic,tel_rawlog,tel_fuel,case when tel_input_0=true then true else false end as tel_input_0,case when tel_input_1=true then true else false end as tel_input_1,case when tel_input_2=true then true else false end as tel_input_2,tel_input_3,tel_temperature,tel_voltage,main_powervoltage,gps_fix,tel_rfid,tel_fuel,tel_odometer,tel_hours from latest_telemetry ".$queryAppend;
 
			   $navData[]=select_query($newQry);
//} 
 /*$newQry="select sys_Service_id,gps_time,ADDDATE( gps_time, INTERVAL 330 MINUTE) as india_time,gps_latitude,gps_longitude,gps_speed,des_movement_id as port,case when tel_ignition=true then true else false end as AC,case when tel_panic=true then true else false end as tel_panic,tel_rawlog,tel_fuel,case when tel_input_0=true then true else false end as tel_input_0,case when tel_input_1=true then true else false end as tel_input_1,case when tel_input_2=true then true else false end as tel_input_2,tel_input_3,tel_temperature,tel_voltage,main_powervoltage,gps_fix,tel_rfid,tel_fuel,tel_odometer from telemetry ".$queryAppend."
order by gps_time desc limit 300 ";
 
			   $navData[]=select_query($newQry);

*/

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
						$data[] = $val;
							}








if(count($data)>0)
{
	 echo ' <table class="std border coll thback"><tr><td width="950px" style="font-weight: bold;">IMEI: '.$IMEI.' ('.$Veh_reg.')</td></tr></table>';

 echo '<textarea cols="150" rows="5" wrap="hard">';
	 for($row=0;$row<1;$row++)
  {
   
 echo 'ID-'.$IMEI.',GPSdate-'.$data[$row]['gps_time'].',Indiadate-'.$data[$row]['india_time'].',Lat-'.$data[$row]['gps_latitude'].',Long-'.$data[$row]['gps_longitude'].',Speed-'.$data[$row]['gps_speed'].',AC-'.$data[$row]['AC'].',GPS-'.$data[$row]['gps_fix'].',MainPower-'.$data[$row]['main_powervoltage'].',BatteryPower-1,MainpowerVol-'.$data[$row]['main_powervoltage'].',Temp-'.$data[$row]['tel_temperature'].',IGN-'.$data[$row]['tel_input_0'].',panic-'.$data[$row]['tel_panic'].',Port-'.$data[$row]['port'];
  echo "\n";
  }
  echo '</textarea>';
	?>


  <table class="std border coll thback">


<thead>
 <th align="left" width="100px">gps_time</th><th align="left" width="100px">india_time</th><th align="left" width="100px">gps_latitude</th><th align="left" width="100px">gps_longitude</th><th align="left" width="100px">gps_speed</th><th align="left" width="100px">port</th><th align="left" width="100px">AC</th><th align="left" width="100px">tel_panic</th><th align="left" width="100px">tel_fuel</th><th align="left" width="100px">Ignition</th><th align="left" width="100px">Door</th><th align="left" width="100px">Bonnet</th><th align="left" width="100px">tel_input_3</th><th align="left" width="100px">tel_temperature</th><th align="left" width="100px">tel_voltage</th><th align="left" width="100px">main_powervoltage</th><th align="left" width="100px">gps_fix<th><th align="left" width="100px">Tel Fuel</th><th align="left" width="100px">Odometer</th></thead>

 <?
		for($row=0;$row<count($data);$row++)
									{
			?>

 <tr>


  
<td align="left" width="100px"><?=$data[$row]['gps_time']?></td>
<td align="left" width="100px"><?=$data[$row]['india_time']?></td>
<td align="left" width="100px"><?=$data[$row]['gps_latitude']?></td>
<td align="left" width="100px"><?=$data[$row]['gps_longitude']?></td>
<td align="left" width="100px"><?=$data[$row]['gps_speed']?></td>
<td align="left" width="100px"><?=$data[$row]['port']?></td>
<td align="left" width="100px"><?=$data[$row]['AC']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_panic']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_fuel']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_input_0']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_input_1']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_input_2']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_input_3']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_temperature']?></td>
<td align="left" width="100px"><?=$data[$row]['tel_voltage']?></td>
<td align="left" width="100px"><?=$data[$row]['main_powervoltage']?></td>
<td align="left" width="100px"><?=$data[$row]['gps_fix']?></td> 
<td align="left" width="100px"><?="battery lbl:-> ".$data[$row]['tel_rfid']?></td>
 
<td align="left" width="100px"><? echo $data[$row]['tel_fuel']?></td> 
<td align="left" width="100px"><? echo $data[$row]['tel_hours']?></td> 

		</tr>

 
			<?  }
}
else
	  {
	echo "No data found";
	  }
  }
  
  }
else
{
	 //$queryAppend="where today_ideal.tel_rawlog like '".$IMEI."-%' ";
	 $queryAppend="";
}?>
			</table>
			  