<?php 
ob_start();
session_start();
date_default_timezone_set ("Asia/Calcutta");

define('__SITE_URL', 'http://localhost/inventory');

define('__DOCUMENT_ROOT', 'C:/xampp/htdocs/inventory');


$hostname2 = "localhost";
$username2 = "root";
$password2 = "";
$databasename2 = "inventory";

$dblink2 = mysql_connect($hostname2,$username2,$password2) ;

@mysql_select_db($databasename2,$dblink2);

function getcountRow($query)
{
	global $dblink2;
	$hostname2 = "localhost";
	$username2 = "root";
	$password2 = "";
	$databasename2 = "internalsoftware";
	
	$dblink2 = mysql_connect($hostname2,$username2,$password2) ;

	$Numberofservice = mysql_query($query,$dblink2);
	$count=mysql_num_rows($Numberofservice);
	return $count;
}

function select_query_alert($query,$condition=0){
	
	global $dblink2;

	$hostname2 = "localhost";
	$username2 = "root";
	$password2 = "";
	$databasename2 = "smsapplication";
	
	$dblink2 = mysql_connect($hostname2,$username2,$password2) ;

		if($condition==1){
			//echo "<br>".$query."<br>";
		}
	$qry=@mysql_query($query,$dblink2);  
	 
	  $num=@mysql_num_rows($qry);
	$num_field=@mysql_num_fields($qry);
	for($i=0;$i<$num_field;$i++)
	{
	$fname[]=@mysql_field_name($qry,$i);
	}
	for($i=0;$i<$num;$i++){
	$result=mysql_fetch_array($qry);
	foreach($fname as $key => $value ) {
		$arr[$i][$value]=$result[$value];
		}
	}


	return $arr;
}
 
 
function select_query($query,$condition=0){
	
	global $dblink2;

	$hostname2 = "localhost";
	$username2 = "root";
	$password2 = "";
	$databasename2 = "internalsoftware";
	
	$dblink2 = mysql_connect($hostname2,$username2,$password2) ;

		if($condition==1){
			//echo "<br>".$query."<br>";
		}
	$qry=@mysql_query($query,$dblink2);  
	 
	  $num=@mysql_num_rows($qry);
	$num_field=@mysql_num_fields($qry);
	for($i=0;$i<$num_field;$i++)
	{
	$fname[]=@mysql_field_name($qry,$i);
	}
	for($i=0;$i<$num;$i++){
	$result=mysql_fetch_array($qry);
	foreach($fname as $key => $value ) {
		$arr[$i][$value]=$result[$value];
		}
	}


	return $arr;
}

function insert_query($table_name, $form_data)
{
   
	global $dblink2;

	$hostname2 = "localhost";
	$username2 = "root";
	$password2 = "";
	$databasename2 = "internalsoftware";
	
	$dblink2 = mysql_connect($hostname2,$username2,$password2) ;

    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);
 
    // build the query
     $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";
 
    // run and return the query result resource
	$insert = mysql_query($sql,$dblink2);
    return $insert;
}

function update_query($table_name,$form_data,$condition)
{
   
	global $dblink2;

	$hostname2 = "localhost";
	$username2 = "root";
	$password2 = "";
	$databasename2 = "internalsoftware";
	
	$dblink2 = mysql_connect($hostname2,$username2,$password2) ;
	
	$cond = array();
	foreach($condition as $field => $val) {
	   $cond[] = "$field = '$val'";
	}
	
	$fields = array();
	foreach($form_data as $field => $val) {
	   $fields[] = "$field = '$val'";
	}
	
    // build the query 	
	$sql = "UPDATE ".$table_name." SET ". join(', ', $fields) ." WHERE ".join(' and ', $cond);
 
    // run and return the query result resource
	$update = mysql_query($sql,$dblink2);
    return $update;
}

function getcountRow_live($query)
{
	$hostname = "localhost";
	$username1 = "root";
	$password = "";
	$databasename = "matrix";

	$dblink = mysql_connect($hostname,$username1,$password) ;
	
	$Numberofservice = mysql_query($query,$dblink);
	$count=mysql_num_rows($Numberofservice);
	return $count;
}


function select_query_live($query,$condition=0)
{
	$hostname = "localhost";
	$username1 = "root";
	$password = "";
	$databasename = "matrix";

	$dblink = mysql_connect($hostname,$username1,$password) ;
	
   if($condition==1){
    //echo "<br>".$query."<br>";
   }

  $qry=@mysql_query($query,$dblink);// or die( $query . " ". mysql_error());
  $num=@mysql_num_rows($qry);
  $num_field=@mysql_num_fields($qry);
  for($i=0;$i<$num_field;$i++)
  {
  $fname[]=@mysql_field_name($qry,$i);
  }
  for($i=0;$i<$num;$i++){
  $result=mysql_fetch_array($qry);
  foreach($fname as $key => $value ) {
   $arr[$i][$value]=$result[$value];
   }
  }
  mysql_close();
  return $arr;
}

function update_query_live($table_name,$form_data,$condition)
{
	$hostname = "localhost";
	$username1 = "root";
	$password = "";
	$databasename = "matrix";

	$dblink = mysql_connect($hostname,$username1,$password) ;

    $cond = array();
	foreach($condition as $field => $val) {
	   $cond[] = "$field = '$val'";
	}
		
	$fields = array();
	foreach($form_data as $field => $val) {
	   
		if($val=='0' || $val=='1')
		{
			$fields[] = "$field = $val";
		}
		else
		{
	   		$fields[] = "$field = '$val'";
		}
	}
	
    // build the query 	
	$sql = "UPDATE ".$table_name." SET ". join(', ', $fields) ." WHERE ".join(' and ', $cond);
    // run and return the query result resource
	//$update = mysql_query($sql,$dblink);
    return $update;
}

function select_query_live_con($query,$condition=0)
{
	$hostname_live = "localhost";
	$username1_live = "root";
	$password_live = "";
	$databasename_live = "matrix";

	$dblink_live = mysql_connect($hostname_live,$username1_live,$password_live) ;
	
   if($condition==1){
    //echo "<br>".$query."<br>";
   }

  $qry=@mysql_query($query,$dblink_live);// or die( $query . " ". mysql_error());
  $num=@mysql_num_rows($qry);
  $num_field=@mysql_num_fields($qry);
  for($i=0;$i<$num_field;$i++)
  {
  $fname[]=@mysql_field_name($qry,$i);
  }
  for($i=0;$i<$num;$i++){
  $result=mysql_fetch_array($qry);
  foreach($fname as $key => $value ) {
   $arr[$i][$value]=$result[$value];
   }
  }
  mysql_close();
  return $arr;
}

function insert_query_live_con($table_name, $form_data)
{
	$hostname_live = "localhost";
	$username1_live = "root";
	$password_live = "";
	$databasename_live = "matrix";

	$dblink_live = mysql_connect($hostname_live,$username1_live,$password_live) ;

    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);
 
    // build the query
     $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";
 
    // run and return the query result resource
	//$insert = mysql_query($sql,$dblink_live);
    return $insert;
}


function update_query_live_con($table_name,$form_data,$condition)
{
	$hostname_live = "localhost";
	$username1_live = "root";
	$password_live = "";
	$databasename_live = "matrix";

	$dblink_live = mysql_connect($hostname_live,$username1_live,$password_live) ;

    $cond = array();
	foreach($condition as $field => $val) {
	   $cond[] = "$field = '$val'";
	}
		
	$fields = array();
	foreach($form_data as $field => $val) {
	   
		if($val=='0' || $val=='1')
		{
			$fields[] = "$field = $val";
		}
		else
		{
	   		$fields[] = "$field = '$val'";
		}
	}
	
    // build the query 	
	$sql = "UPDATE ".$table_name." SET ". join(', ', $fields) ." WHERE ".join(' and ', $cond);
 
    // run and return the query result resource
	//$update = mysql_query($sql,$dblink_live);
    return $update;
}

?>