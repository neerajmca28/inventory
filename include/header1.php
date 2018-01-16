
<?php include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$result="";
$data=array();
	$menu_id=array();
	$menu_name=array();
	$menu_desc=array();
	$url=array();
	$parent_id=array();
	$menu=array();
	$parent_detail=array();
	$child_detail=array();
	$res_parent="";
	$res_child="";
	$res_parents="";
	$res_childs="";
	$parent_details=array();
	$child_details=array();
	$parent_detail_total=array();
	$child_detail_total=array();
if(isset($_SESSION['userId_inv']) && !empty($_SESSION['userId_inv']) && isset($_SESSION['user_name_inv']) && !empty($_SESSION['user_name_inv']))
{
	//mysql_query("SET @userid = " . "'" .$_SESSION['userId_inv']. "'") or die("Query fail: " . mysql_error());
	//echo $_SESSION['userId_inv'];
	//$data = mysql_query("CALL inventory.SelectMenuParentId(@userid);") or die("Query fail: " . mysql_error());
		//$result=select_Procedure("CALL SelectMenuParentId(".$_SESSION['userId_inv'].")");
		//echo $user_id=$_SESSION['userId_inv']; die;
		$data=select_Procedure("CALL SelectMenuParentId('".$_SESSION['userId_inv']."')");
		$data=$data[0];
		for($i=0;$i<count($data);$i++)
		{
			 if (is_null($data[$i]['parent_id']) || isset($data[$i]['parent_id']) === true && empty($data[$i]['parent_id']) === true || isset($data[$i]['parent_id']) === false && empty($data[$i]['parent_id']) === true)
			 { 
					$res_parent.= $data[$i]['menu_id'].'~'.$data[$i]['menu_name'].'#';
			 }
			else 
			{
				$res_child.=$data[$i]['menu_id'].'~'.$data[$i]['menu_name'].'~'.$data[$i]['url'].'~'.$data[$i]['parent_id'].'#';
			}
		}
				$res_parents.=substr($res_parent,0,strlen($res_parent)-1);
				$parent_details=explode('#',$res_parents);
				for($j=0;$j<count($parent_details);$j++)
				{
					$parent_detail_total[]=explode('~',$parent_details[$j]);
				}
				  /* echo "<pre>"; 
				print_r($parent_detail_total); 
				  echo "</pre>";  */
				  
				
				 $res_childs.=substr($res_child,0,strlen($res_child)-1);
				$child_details=explode('#',$res_childs);
				for($m=0;$m<count($child_details);$m++)
				{
					$child_detail_total[]=explode('~',$child_details[$m]);
				}
				
				/*  echo "<pre>"; 
				print_r($child_detail_total); 
				  echo "</pre>"; 
				  die; */   
				
}
else
{
	 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
			
?>
<!DOCTYPE html>
<html xml:lang="en-IN" lang="en-IN">
<head>



<link rel="stylesheet" type="text/css" href="<?php echo __SITE_URL;?>/file/bootstrap.min.css">


<script src="<?php echo __SITE_URL;?>/bootstrap/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo __SITE_URL;?>/assets/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo __SITE_URL;?>/assets/bootstrap/bootstrap-datetimepicker.js"></script>


</head>
<body>
<!--top div start-->
<div class="div-top">
  <div class="welcome-text"> <span> Welcome to <?php echo $_SESSION['login']; ?></span> </div>
  <ul class="div-top-right">
    <li> <? echo date('d-m-Y H:i:s')?> </li>
    
    <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Logout <span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="logout.php"> <img src="<?php echo __SITE_URL;?>/file/logout.png" class="logout-img"><span>Logout</span></a></li>
      </ul>
    </li>
  </ul>
</div>
<!--top div start--> 

<!--log and menu div start-->
<div class="row header-menu">
  <div class="col-sm-1">


    <div class="logo">

 <?php if($_SESSION['userId_inv']==25)
 {
  echo "<a href='addrawdevice.php'>";
 } 
 if($_SESSION['userId_inv']==24)
 {
  echo "<a href='configuredevice.php'>";
 }
 if($_SESSION['userId_inv']==26 ||$_SESSION['userId_inv']==27 || $_SESSION['userId_inv']==28 || $_SESSION['userId_inv']==29)
 {
  echo "<a href='requestednewdevice.php'>";
 }
 if($_SESSION['userId_inv']==30)
 {
  echo "<a href='dispatchsim.php'>";
 }
 if($_SESSION['userId_inv']==31)
 {
  echo "<a href='recddispatchdevice.php'>";
 }
 if($_SESSION['userId_inv']==34)
 {
  echo "<a href='default2.php'>";
 }
 ?>
<img src="<?php echo __SITE_URL;?>/file/mihome.png"> </a> </div>
  </div>
  <div class="col-sm-11">
    <nav class="navbar my-nav" role="navigation">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" data-hover="dropdown" data-animations="fadeInDown fadeInRight fadeInUp fadeInLeft">
      <ul class="nav navbar-nav navbar-right">
   <?php 
   for($k=0;$k<count($parent_detail_total);$k++)
   {
    echo '<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">';
    echo $parent_detail_total[$k][1].'<span class="caret"></span></a>';
    echo '<ul class="dropdown-menu dropdownhover-bottom" role="menu">';
    for($n=0;$n<count($child_detail_total);$n++)
    {
     if($parent_detail_total[$k][0]==$child_detail_total[$n][3])
     {
      if($child_detail_total[$n][3]=$parent_detail_total[$k][0])
      {
     ?>
       <li><a href="<?php echo $child_detail_total[$n][2]; ?>"><?php echo $child_detail_total[$n][1]; ?></a></li>
       <li class="divider"></li>
       
      <?php 
      }
     }
    }  
    echo '</ul></li>'; 
   
   }
   ?>
        
      </ul>
       
    </div>
  </div>
  </nav>
</div>
<!--log and menu div end-->





</body>

</html>

<?php

 if($_SESSION['userId_inv']==25)
 {
 	?>

<script type="text/javascript">
var $vhlheader = jQuery.noConflict();
$vhlheader(document).ready(function(e) {
		
		
        $vhlheader('.Mydialog').css('display','none');         
		setInterval(function(){ 
		//alert('rr');
	
			 //arr='tt'
			 //arr=content;
			 //$vhlheader('.Mydialog').delay(10000).fadeIn();
				$vhlheader.ajax({	
				url: "popupAlertStock.php",
				data: {"status": 1},
				type: "POST",
				success: function(data)
				{
						
						//alert(data);
						var res = data.split("##");
						if(res[1])
						{

							var data1 ="Assign  Devices to "+res[1];
							//alert(res[2]);
							document.getElementById("hidden").value =res[2];
							//window.location.href = "";
							$vhlheader('.Mydialog').delay(100).fadeIn();
							//$vhlheader('.Mydialog').delay(1000).fadeOut();
							$vhlheader('#ntext').html(data1);

						
						}
						// else
						// {	
						// 	//$vhlheader('#ntext').html(data);
						// 	$vhlheader('.Mydialog').css('display','none'); 

						// }
				
				}
				});
			
			
		
		
    }, 10000);
	
	$vhlheader('#btnaccept').click(function(){
				//alert('ddd');
				var installer_id = $vhlheader("#hidden").val();
			//	alert(installation_id);
				//window.location = "stockAlert_assign.php?installation_id="installation_id;
				//location.href = "stockAlert_assign.php?installation_id="+installation_id;
				 window.open("stockAlert_assign.php?installer_id="+installer_id); 
					
			});
			
			
	 $vhlheader('#btnreject').click(function(){
	 			//alert('ddd');
	 		//window.location.reload();
	 		//vhlheader('.Mydialog').css('display','none');
	 		$vhlheader('.Mydialog').delay(100).fadeOut();
	 		//window.location = "http://www.yoururl.com";
	
				
			
	 		});

});
</script>

<input type="hidden" value="<?php echo $user_id; ?>" name="hidden" id="hidden">
<div class = "modal-dialog Mydialog" id="dialog" style="text-align: left; margin: 18% auto;">
    <div class = "modal-content">
      <div class = "modal-header">
        <button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true"> &times; </button>
        <h4 class = "modal-title" id = "myModalLabel">  </h4>
      </div>
      <div class = "modal-body"> <p id="ntext"> </p></div>
      <div class = "modal-footer">
        <button type="button" class = "btn btn-primary"  id="btnaccept" style="background: rgba(5, 180, 44, 0.8); border: 1px solid rgba(5, 180, 44, 0.8);">Accept</button>
        <button type = "button" class = "btn btn-default" id="btnreject" data-dismiss = "modal">Reject</button>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  <?php
}
  ?>