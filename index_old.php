<?php
ob_start();
//include("connection.php");
include_once('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
//include_once(__DOCUMENT_ROOT.'/private/common.php');
 
$menu_id=array();
$menu_name=array();
$menu_desc=array();
$url=array();
$parent_id=array();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$masterObj = new master();
    /* $_SESSION['user_name_inv']="";
    $_SESSION['userId_inv']="";
    $_SESSION['ParentId']="";

    $user=$_POST['user'];
    $old_password=$_POST['old_password'];
    $new_password=$_POST['new_password'];
    $confirm_password=$_POST['confirm_password']; */

    $username=addslashes($_POST['username']);
    $password=addslashes($_POST['password']);
   
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);
   
    //$result=mysql_query("SELECT * FROM user_details WHERE user_name='".$username."' and password='".$password."' ");
   // $row=mysql_fetch_array($result);
    //$count=mysql_num_rows($result);
	$dbselect = $masterObj->getUserData($username,$password);	
	if(count($dbselect)==1)
    {

      $_SESSION['username']=$dbselect[0]["user_name"];; 
      $_SESSION['userId_inv']=$dbselect[0]['user_id'];

			/* mysql_query("SET @userid = " . "'" .$_SESSION['userId_inv']. "'") or die("Query fail: " . mysql_error());

			$result = mysql_query("CALL `SelectMenuParentId`(@userid);") or die("Query fail: " . mysql_error());
			while ($row = mysql_fetch_array($result))
			{ 
			 
			 $menu_id[]=$row['menu_id'];
			 $menu_name[]=$row['menu_name'];
			//$menu_desc[]=$row['menu_desc'];
			 $url[]=$row['url'];
			 $parent_id[]=$row['parent_id'];
			} */
		//print_r($url); die;	
		?><script><?php echo("location.href = '".__SITE_URL."/myAccount.php';");?></script><?php
     }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Inventory Login</title>
<link href="file/g.png" rel="shortcut icon" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="file/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="file/in.css">
</head>

<body class="login-body">
<div class="login-box">

       <div class="login-logo"><img src="file/login-logo.png"></div>
		
      <div class="controls">
      <h2>Gtrac Inventory Login Form</h2>
      <form method="post" action="" onSubmit="return oklogin()">
      	<input type="text" name="username" id="username"  placeholder="User Name" class="form-control" />
		<input type="password" name="password" id="password" placeholder="Password" class="form-control" />
        
       <!-- <a class="btn-login" href="index.html">Login </a>
	   <a class="btn-cancel">Cancel </a>-->
		<input type="submit" name="login_btn" class="btn-login" value="Login"/></td>
		<input type="submit" name="cancel_btn" class="btn-cancel" value="Cancel"/></td>
        </form>
       <a style="text-align: center;width: 100%;display: block;margin-top: 46px;">Login and Use Inventory</a>
      </div>
</div>
<script type="text/javascript">
function oklogin(){
    var u = document.getElementById('username');
    var p = document.getElementById('password');
   
    if((u.value != '' && u.value.length >0) && (p.value != '' && p.value.length >0)){
        return true;
    }else{
        return false;
    }
}   

</script>
</body>
</html>
