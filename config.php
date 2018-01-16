<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);
ob_start();
session_start(); 
date_default_timezone_set("Asia/Kolkata");


ini_set('include_path', 'c:/xampp/htdocs/inventory/private/lib/');
$_SESSION['TimeZoneDiff']=330;
define('__DB_HOST', 'localhost');
define('__DB_PORT', '3306');
define('__DB_USER', 'root');
define('__DB_PASSWORD', '');
define('__DB_DATABASE', 'inventory');
 $con2 = mysql_connect(__DB_HOST,__DB_USER,__DB_PASSWORD);
$db2 = mysql_select_db("inventory",$con2);
 define('__DB_HOST_STAGING', 'localhost');
define('__DB_PORT_STAGING', '3306');
define('__DB_USER_STAGING', 'root');
define('__DB_PASSWORD_STAGING', '');
define('__DB_DATABASE_STAGING', 'internalsoftware');
//define('__DB_DATABASE1_STAGING', 'livetrack');
 $con3 = mysql_connect(__DB_HOST_STAGING,__DB_USER_STAGING,__DB_PASSWORD);
$db3 = mysql_select_db("internalsoftware",$con3);

function update_query_internal($table_name,$form_data,$condition)
{
   
  global $dblink_inv;
  $hostname_inv = "localhost";
  $username_inv = "root";
  $password_inv = "";
  $databasename_inv = "inventory";
  
  $dblink_inv = mysql_connect($hostname_inv,$username_inv,$password_inv);
  
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
  $update = mysql_query($sql,$dblink_inv);
    return $update;
}

function update_query($table_name,$form_data,$condition)
{
   
  global $dblink2;
  $hostname2 = "localhost";
  $username2 = "root";
  $password2 = "";
  $databasename2 = "internalsoftware";
  
  $dblink2 = mysql_connect($hostname2,$username2,$password2) ;

    // retrieve the keys of the array (column titles)
    //$fields = array_keys($form_data);
  $cond = array();
  foreach($condition as $field => $val) 
  {
     $cond[] = "$field = '$val'";
  }
  
  $fields = array();
  foreach($form_data as $field => $val) 
  {
     $fields[] = "$field = '$val'";
  }
  
    // build the query  
  //$sql = "UPDATE ".$table_name." SET ". join(', ', $fields) ." WHERE ".implode('`,`', $cond)."='".implode("','", $condition)."'";
  $sql = "UPDATE ".$table_name." SET ". join(', ', $fields) ." WHERE ".join(' and ', $cond);
    //echo $sql; die;
    // run and return the query result resource
  $update = mysql_query($sql,$dblink2);
    return $update;
}

define('__DB_HOST_MATRIX', 'localhost');
define('__DB_PORT_MATRIX', '3306');
define('__DB_USER_MATRIX', 'root');
define('__DB_PASSWORD_MATRIX', '');
define('__DB_DATABASE_MATRIX', 'matrix');

//define('__SITE_URL', 'http://localhost/inventory');
define('__SITE_URL', 'http://localhost/inventory');


define('__DOCUMENT_ROOT', 'c:/xampp/htdocs/inventory');
define('__IMAGE_PATH', __SITE_URL.'/reports/assets/img/');

define('__Admin_Email', 'harish@g-trac.in');

//define('__ZEND_LOG_FILE', __DOCUMENT_ROOT.'/private/logs/zend.log.txt');


?>