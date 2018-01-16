<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);
ob_start();
session_start(); 
date_default_timezone_set("Asia/Kolkata");


ini_set('include_path', '/xampp/htdocs/inventory/private/lib/');
$_SESSION['TimeZoneDiff']=330;



define('__DB_HOST', '203.115.101.30');
define('__DB_PORT', '3306');
define('__DB_USER', 'visiontek11000');
define('__DB_PASSWORD', '123456');
define('__DB_DATABASE', 'inventory');



 $con2 = mysql_connect(__DB_HOST,__DB_USER,__DB_PASSWORD);
$db2 = mysql_select_db("inventory",$con2);


define('__DB_HOST_STAGING', '203.115.101.109');
define('__DB_PORT_STAGING', '3306');
define('__DB_USER_STAGING', 'inventory_php');
define('__DB_PASSWORD_STAGING', '123456');
define('__DB_DATABASE_STAGING', 'internalsoftware'); 
  

define('__DB_HOST_MATRIX', '203.115.101.62');
define('__DB_PORT_MATRIX', '3306');
define('__DB_USER_MATRIX', 'inventory_php');
define('__DB_PASSWORD_MATRIX', '123456');
define('__DB_DATABASE_MATRIX', 'matrix'); 

//define('__SITE_URL', 'http://localhost/inventory');
define('__SITE_URL', 'http://203.115.101.30/inventory');


define('__DOCUMENT_ROOT', '/xampp/htdocs/inventory');
define('__IMAGE_PATH', __SITE_URL.'/reports/assets/img/');

define('__Admin_Email', 'harish@g-trac.in');

define('__ZEND_LOG_FILE', __DOCUMENT_ROOT.'/private/logs/zend.log.txt');



?>