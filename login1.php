<?php
session_start();
$cn=mysql_connect("localhost","root","");
if(!$cn)
{
die('could not connect' . mysql_error());
}
mysql_select_db("services", $cn);
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$contact_person=addslashes($_POST['contact_person']);
$user_password=addslashes($_POST['user_password']);

$sql="SELECT id FROM new_account_creation WHERE contact_person='$contact_person' and user_password='$user_password'";
$result=mysql_query($sql);
//$row=mysql_fetch_array($result, $cn);
$active=$row['active'];
$count=mysql_num_rows($result);

if($count==1)
{
//session_register("contact_person");
$_SESSION['login_user']=$contact_person;

echo "congratulate you have loged";
}
else
{
echo "Your Login Name or Password is invalid or if you have not register then new account create";
}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css"style.css>
</style>
<style type="text/javascript"validation.js></style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Log in</title>
<style type="text/css">
.pwd{
	font-family: Arial, Helvetica, sans-serif;
	color: #000099;
	font-weight: bold;
	font-size: 12px;
	text-align:left;
	width:150px;
}
.txtbox{
	font-family:Arial, Helvetica, sans-serif;
	color:#000066;
	font-weight:bold;
	font-size:14px;                
}
.gobtn{
	background-color:#FFFFFF;
	font-family:Arial, Helvetica, sans-serif;
	color:#990000;
	font-size:12px;
	font-weight:bold;
	height:20px;
}
.bluetext {
	font-family: Arial, Helvetica, sans-serif;
	color: #000066;
	font-weight: bold;
	font-size: 12px;
	text-decoration: none;
}
</style>
</HEAD>
<BODY bgcolor="">
<a href="logout.php">logout</a>
<center>
<div style="padding-top:20%;">
<table align="center" border=0>
			  <tr><td><img src="images/brandon.jpg" width="100" height="50"/>
			  </td></tr></table><br/>
<form method="post" action="" onSubmit="return oklogin()">
<table border="0" width="30%" style="background-color:#33CCCC" cellpadding="0" cellspacing="5">
<tr>
<td align="right" class="txtbox">Username:</td>
<td align="left"><input type="text" class="pwd" name="contact_person" id="username" size="35" maxlength="50"/></td>
</tr>
<tr>
<td align="right" class="txtbox">Password:</td>
<td align="left"><input type="password" class="pwd" name="user_password" id="password" size="35" maxlength="12"/></td>
</tr>
<tr>
<td align="center" colspan="2">
<input type="submit" name="login_btn" class="gobtn" value="Go"/></td>
</tr>
<tr>

<td colspan="2" class="txtbox">
<a href="NewAccountCreation.php?db<?php echo $_GET["db"] ?>" class="bluetext">new account create</a> 

</td>
</tr>
</form>
</center>
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
</BODY>
</HTML>
