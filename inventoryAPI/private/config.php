<?php
//error_reporting(E_ERROR);
ini_set('display_errors', 1);
ob_start();
//session_start(); 
date_default_timezone_set ("Asia/Calcutta");

ini_set('include_path', '/xampp/htdocs/InstallerAPI/private/lib/');

$_SESSION['TimeZoneDiff']=330;
 

/*$hostname = "203.115.101.124";
$username1 = "internal_soft";
$password = "123456";
$databasename = "internalsoftware";*/

$hostname = "localhost";
$username1 = "root";
$password = "";
$databasename = "internalsoftware";

define('__DB_HOST', $hostname);
define('__DB_PORT', '3306');
define('__DB_USER', $username1);
define('__DB_PASSWORD', $password);
define('__DB_DATABASE', $databasename);


function select_query_live_con($query,$condition=0)
{
	$hostname_live = "203.115.101.62";
	$username1_live = "for124server";
	$password_live = "priya@9876";
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

 
//define('__SITE_URL', 'http://localhost/InstallerAPI');
//define('__SITE_URL', 'http://203.115.101.30/InstallerAPI');
define('__SITE_URL', 'http://192.168.1.28/InstallerAPI');

define('__DOCUMENT_ROOT', '/xampp/htdocs/InstallerAPI');
define('__IMAGE_PATH', __SITE_URL.'/reports/assets/img/');

define('__Admin_Email', 'harish@g-trac.in');

define('__ZEND_LOG_FILE', __DOCUMENT_ROOT.'/private/logs/zend.log.txt');
?>