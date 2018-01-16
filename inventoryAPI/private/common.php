<?
//include_once('../gtracapp/config.php');
 include_once(__DOCUMENT_ROOT.'/config.php');
//echo include(DOCUMENT_ROOT.'/private/master.php');


class MyClass 
{ 
	function dateDifferenceSecond($date1, $date2)
    { 
    
        $datetime1 = strtotime($date1);
        
        $datetime2 = strtotime( $date2);
        
        $interval  = abs($datetime2 - $datetime1);
        
        $minutes   = round($interval / 60);
        
        return $minutes*(60);
    
    }

function secstodatetime($Seconds)
{ 
	$mins=$Seconds/60;
 $diff = $mins;
 $hour = $diff/60; // in day
 
 
 $hourFix = floor($hour);
 $hourPen = $hour - $hourFix;
 if($hourPen > 0)
 {
  $min = $hourPen*(60); // in hour (1 hour = 60 min)
  $minFix = floor($min);
  $minPen = $min - $minFix;
  if($minPen > 0)
  {
  $sec = $minPen*(60); // in sec (1 min = 60 sec)
  $secFix = floor($sec);
  }
 }
 
 
  
 if($hourFix > 0)
 $str.= $hourFix." H ";
 
 if($minFix > 0)
 $str.= $minFix." M ";
 
 if($secFix > 0)
 $str.= $secFix." S ";
 return $str;
}



	function addMinuteinTimeStamp($temp,$temp_minute,$format=''){

		$yy=substr($temp,0,4);
		$mm=substr($temp,5,2);
		$dd=substr($temp,8,2);
		$hh=substr($temp,11,2);
		$min=substr($temp,14,2)+$temp_minute;
		$sec=substr($temp,17,2);
 		$v = mktime ( $hh , $min, $sec , $mm , $dd , $yy);

		if($format==""){
				$format="Y/m/d H:i:s";
		}
		return date($format,$v);

	}
	function convertToGMT($temp,$temp_minutes){
	 		$temp_minutes=($temp_minutes*-1);
			$yy=substr($temp,0,4);
		$mm=substr($temp,5,2);
		$dd=substr($temp,8,2);
		$hh=substr($temp,11,2);
		$min=substr($temp,14,2)+$temp_minute;
		$sec=substr($temp,17,2);
 		$v = mktime ( $hh , $min, $sec , $mm , $dd , $yy);

		 
				$format="Y/m/d H:i:s";
		 
		return date($format,$v);

	}
	 
	function UploadImage($storeimage_path,$Width,$Height,$fileName,$ImageName,$UpdateTabName,$UpdateColName,$whereCondition)
	{ 	 
		require_once('Thumbnail.php'); 
	 
		 if (copy($_FILES[$fileName]["tmp_name"],$ImageName)) 
			   { 			
				chmod($ImageName, 0777);
				$ts = new Thumbnail($Width, $Height,true,false);	
				$image=file_get_contents($ImageName); 
				 $ts->loadData($image,'image/jpeg');
			     $ts->buildthumb($ImageName);

			    
			   $data = array($UpdateColName => $storeimage_path);		
			   $condition = array($whereCondition);
			   db__update($UpdateTabName, $data, $condition);   

				
			}
			 
	}

	function CleanUp($Str)
		{
			$Str=trim($Str);		 
			$Str=stripslashes($Str);
			$Str=str_replace("'","\'",$Str);		 
			return $Str;
		}


	function myTruncateStr($string, $limit, $break=" ", $pad="...") 
		{ // return with no change if string is shorter than $limit  
		
		if(strlen($string) <= $limit) return $string; 
		// is $break present between $limit and the end of the string?
		if(false !== ($breakpoint = strpos($string, $break, $limit))) 
			{ 
			 
				if($breakpoint < strlen($string) - 1) 
				{
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
			$finalstring=stripslashes($string);
			return $finalstring;
		}
	

	function check_email_address($email) {
	 // First, we check that there's one @ symbol, and that the lengths are right
	 if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		 // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		 return false;
	 }
	
	 // Split it into sections to make life easier
	 $email_array = explode("@", $email);
	 $local_array = explode(".", $email_array[0]);
	
	 for ($i = 0; $i < sizeof($local_array); $i++) {
		 if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			 return false;
		 }
	 }
	
	 if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		 $domain_array = explode(".", $email_array[1]);
		 if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		 }
	
		 for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			}
		 }
	 }
	return true;
	}


	function dateDifference($date1, $date2)
	
	{ 
	
		$datetime1 = strtotime($date1);
		
		$datetime2 = strtotime( $date2);
		
		$interval  = abs($datetime2 - $datetime1);
		
		$minutes   = round($interval / 60);
		
		return $minutes;
	
	}
	
	
	function minDifference($Seconds)
	
	{ 
	
		$mins=$Seconds/60;
		
		$diff = $mins;
		
		$hour = $diff/60; // in day
	
		
		 $hourFix = floor($hour);
		
		 $hourPen = $hour - $hourFix;
		
		 if($hourPen > 0)
		
		 {
		
			  $min = $hourPen*(60); // in hour (1 hour = 60 min)
			
			  $minFix = floor($min);
			
			  $minPen = $min - $minFix;
			
			  if($minPen > 0)
			
			  {
			
				  $sec = $minPen*(60); // in sec (1 min = 60 sec)
				
				  $secFix = floor($sec);
			
			  }
		
		 }
	
	
		 if($hourFix > 0)
		
		 $str.= $hourFix." Hour ";
		
		
		 if($minFix > 0)
		
		 $str.= $minFix." Min ";
		
		
		 if($secFix > 0)
		
		 $str.= $secFix." Sec ";
		
		 return $str;
	
	}

	
	function minDifferenceForJourney($Seconds)
	
	{ 
	
		$mins=$Seconds/60;
		
		$diff = $mins;
		
		$hour = $diff/60; // in day
	
		
		 $hourFix = floor($hour);
		
		 $hourPen = $hour - $hourFix;
		
		 if($hourPen > 0)
		
		 {
		
			  $min = $hourPen*(60); // in hour (1 hour = 60 min)
			
			  $minFix = floor($min);
			
			  $minPen = $min - $minFix;
			
			  if($minPen > 0)
			
			  {
			
				  $sec = $minPen*(60); // in sec (1 min = 60 sec)
				
				  $secFix = floor($sec);
			
			  }
		
		 }
	
	
		 if($hourFix > 0)
		 {
		 	$str.= $hourFix.":";
		 }
		 else
		 {
			 $str.= "0:";
		 }
		
		 if($minFix > 0)
		 {
		 	$str.= $minFix.":";
		 }
		 else
		 {
			 $str.= "0:";
		 }
		
		 if($secFix > 0)
		 {
		 	$str.= $secFix;
		 }
		 else
		 {
			 $str.= "0";
		 }
		 return $str;
	
	}
	
	function minDifferenceDays($Seconds)
	
	{ 
 
 		$mins=$Seconds/60;
				
		$diff = abs($mins);
 
 		$day = $diff/(60*24); // in day
 
 		$dayFix = floor($day);
 		
		$dayPen = $day - $dayFix;
 
		 if($dayPen > 0)
 
 		 {
  
  			$hour = $dayPen*(24); // in hour (1 day = 24 hour)
  
  			$hourFix = floor($hour);
  
  			$hourPen = $hour - $hourFix;
  
  			if($hourPen > 0)
  
  			 {
   
   				$min = $hourPen*(60); // in hour (1 hour = 60 min)
   	
				$minFix = floor($min);
   				
				$minPen = $min - $minFix;
   
   				if($minPen > 0)
   
   				 {
   		
					$sec = $minPen*(60); // in sec (1 min = 60 sec)
   
   					$secFix = floor($sec);
   
   				 }
  
  			}
 
 		}
 
		 $str = "";
		 
		 if($dayFix > 0)
		 
		 $str.= $dayFix." day ";
		 
		 if($hourFix > 0)
		 
		 $str.= $hourFix." hour ";
		 
		 if($minFix > 0)
		 
		 $str.= $minFix." min ";
		 
		 if($secFix > 0)
		 
		 $str.= $secFix." sec ";
		 
		 return $str;
	
	}
	

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
	
	 
	function GetCalculatedKM($date_StartVal,$date_EndVal,$Service_id,$lat,$long)
	{
		$date_Start= $date_StartVal;
		$date_End= $date_EndVal;
		$sys_service_id=$Service_id;
		$time="";
		$distanceFromdestination=0;
		
		$newQry="select id,sys_msg_type,
		gps_time as gps_time,
		gps_latitude,
		gps_longitude
		from  today_speed where
		sys_service_id=".$sys_service_id." and
		gps_time >= '".convertToGMT($date_Start,$_SESSION['TimeZoneDiff'])."' and gps_time <= '".convertToGMT($date_End,$_SESSION['TimeZoneDiff'])."' and gps_latitude>0
		ORDER BY gps_time asc ";
		
		$data=select_query($newQry);
		
		if($lat!="" && $long!="")
			{
		$newQry1="select id,sys_msg_type,
		gps_time as gps_time,
		gps_latitude,
		gps_longitude,ADDDATE( gps_time, INTERVAL 330 MINUTE) as india_time ,round(((7912*asin ( sqrt ( power ( sin ((".$lat."-gps_latitude ) * 0.00872664625997 ), 2 ) + cos(".$lat." * 0.0174532925) * cos ( gps_latitude*0.0174532925) * power ( sin ((".$long."- gps_longitude ) * 0.00872664625997), 2))))*1.609344)) as distance
		from  today_speed where
		sys_service_id=".$sys_service_id." and
		gps_time >= '".convertToGMT($date_Start,$_SESSION['TimeZoneDiff'])."' and gps_time <= '".convertToGMT($date_End,$_SESSION['TimeZoneDiff'])."' and gps_latitude>0
		ORDER BY distance asc limit 1 ";
		
		$data2=select_query($newQry1);
		
		$distanceFromdestination=round($data2[0]['distance']);
		$time=$data2[0]['india_time'];
			}
		$totalDistance=0;
		$distance=0;
		$j=0;
		
		unset($obj);
		
		
		$currentJourney==new VehicleDebug();
		
		for($i=0;$i<count($data);$i=$i+1)
		{
		
		
		$currentJourney->start_lat = $data[$i]['gps_latitude'];
		$currentJourney->start_long     = $data[$i]['gps_longitude'];
		
		$obj[$j]=$currentJourney;
		$j=$j+1;
		unset($currentJourney);
		
		}
		
		$totalDistance=0;
		// Start Looping Records
		for($objArrayCount=0;$objArrayCount<count($obj);$objArrayCount++)
		{
		/*************************/
		#### Create Object to Calculate Distance
		/*************************/
		$distance=0;
		if($objArrayCount==0){
		$distance=0;
		}
		else{
		if(isset($calcObj) or isset($PointArray)){
		unset($calcObj);
		unset($PointArray);
		}
		$calcObj=new calculate_distance();
		
		$PointArray[0]['lat']=$obj[$objArrayCount]->start_lat;
		$PointArray[0]['long']=$obj[$objArrayCount]->start_long;
		
		$PointArray[1]['lat']=$obj[$objArrayCount-1]->start_lat;
		$PointArray[1]['long']=$obj[$objArrayCount-1]->start_long;
		$distance = $calcObj->calc_distance($PointArray);
		
		}
		
		$totalDistance=$totalDistance+$distance;
		
		}
		
		//echo $totalDistance."##".$distanceFromdestination."##".$time."##".$Service_id;
		//echo "<br/>";
		return $totalDistance."##".$distanceFromdestination."##".$data2[0]['india_time'];
	
	}
	
	
	


}

?>