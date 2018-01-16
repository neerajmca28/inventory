<?php
include("config.php");
include("device_status.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$condition="";
$masterObj = new master();	
$branch_id=$_SESSION['branch_id'];
$strUsers=db__select_matrix("SELECT id as user_id, sys_username as name FROM matrix.users order by name asc");
if (isset($_POST['Submit']))
{
		if(empty($_POST['user_list']) || $_POST['user_list']==0)
		{
			$errUser="Please Select User";
		}
		else
		{
			$client_id=$_POST['user_list'];
		}
		if(empty($_POST['veh_list']) || $_POST['veh_list']==0)
		{
			$errVeh="Please Select User";
		}
		else
		{
			$vehreg=$_POST['veh_list'];
		}	
		if(empty($_POST['company_name']) || $_POST['company_name']=="")
		{
			$errCompany="Please Insert Company Name";
		}
		else
		{
			$company_name=$_POST['company_name'];
		}
		if(empty($_POST['device_imei']) || $_POST['device_imei']=="")
		{
			$errImei="Please Insert Insert IMEI";
		}
		else
		{
			$device_imei=$_POST['device_imei'];
		}
		if(empty($_POST['itgc_id']) || $_POST['itgc_id']=="")
		{
			$errITGC="Please Insert Insert ITGC ID";
		}
		else
		{
			$itgc_id=$_POST['itgc_id'];
		}
		if($errUser=='' && $errVeh=='' && $errCompany=='' && $errImei=='' && $errITGC==''  )
		{
			$recdDateFromClient=$_POST['recd_date'];
			//$recdFrom=$_POST['recd_from'];
			if($_POST['recd_from']==1)
			{
				$recdFrom="Person";
			}
			else if($_POST['recd_from']==2)
			{
				$recdFrom=="Courier";
			}
			else
			{
				$recdFrom="";
			}
			if($_POST['antina_recd']=="yes")
			{
				 $isAntenaRecd=1;
			}
			else
			{
				$isAntenaRecd=0;
			}
			if($_POST['immob_recd']=="yes")
			{
				$isImmobilizerRecd=1;
			}
			else
			{
				$isImmobilizerRecd=0;
			}
			if($_POST['conn_recd']=="yes")
			{
				$isConnectorRecd=1;
			}
			else
			{
				$isConnectorRecd=0;
			}
			$deviceremarks=$_POST['remarks'];
			$userName=$masterObj->getUserList($client_id);
			$clientName=$userName[0]['name'];
			$device_status=$SendToRepairCentre;
			$dispatchFFCNewdevice=select_Procedure("CALL SaveRepairDevice('".$clientName."','".$vehreg."','".$device_imei."','".$deviceremarks."','".$recdDateFromClient."','".$recdFrom."','".$isAntenaRecd."','".$isImmobilizerRecd."','".$isConnectorRecd."','".$device_status."')");
			if(count($dispatchFFCNewdevice)>0)
			{
				$message='Device has been received'; 
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			else
			{
				$message='Device has not been received.Please try again'; 
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}	
}
?>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
 <form name="device_from_cl" id="device_from_cl" method="post" action="" onsubmit="return deviceRecdFromClient();"  >

<article> 

  <!--page div 1 start-->
  <div class="col-12">
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Device Received From Client</div>
      </div>
      <div class="portlet-body control-box">
      <div class="content-box">
           <div class="left-item"> <span> User Name :</span> </div>
          <div class="right-item"> <select class="form-control" name="user_list" id="user_list" onchange="veh_list1(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($strUsers);$i++)
			{?>
            <option value="<?php echo $strUsers[$i]['user_id']?>"><?php echo $strUsers[$i]['name'];?>
            </option>
            <? } ?>
	
         </select></div><span class="error">* <?php echo $errUser;?>
          </div>
          <div class="content-box">
           <div class="left-item"> <span> Veh No :</span> </div>
          <div class="right-item"> <select class="form-control" name="veh_list" id="veh_list" onchange="companyName(this.value);imeiNo();">
			 <option value="0">Select</option></select></div><span class="error">* <?php echo $errVeh;?>
          </div>
          <div class="content-box">
           <div class="left-item"> <span>Company Name :</span> </div>
          <div class="right-item"><input type="text" name="company_name" id="company_name" class="form-control"></div>
          <span class="error">* <?php echo $errCompany;?>
		  </div>
          <div class="content-box">
           <div class="left-item"> <span>Device IMEI :</span> </div>
          <div class="right-item"> <input type="text" name="device_imei" id="device_imei" class="form-control" onchange="itgcId();"></div>
          <span class="error">* <?php echo $errImei;?>
		  </div>
          <div class="content-box">
           <div class="left-item"> <span>ITGC ID :</span> </div>
          <div class="right-item"> <input type="text" name="itgc_id"  id="itgc_id"  class="form-control"></div>
          <span class="error">* <?php echo $errITGC;?>
		  </div>
          <div class="content-box">
           <div class="left-item"> <span>Recd Date :</span> </div>
          <div class="right-item"> <input type="text" name="recd_date" id="recd_date" class="form-control form_date" value="<?php echo date('Y-m-d H:i:s');?>"></div>
          </div>
          
          <div class="content-box">
           <div class="left-item"> <span> Recd From :</span> </div>
          <div class="right-item"> <select name="recd_from" id="recd_from" class="form-control">
         <option value="">Select</option>
         <option value="1">Person</option>
         <option value="2">Courier</option>
         </select></div>
          </div>
          <div class="content-box">
           <div class="left-item"> <span>Remarks :</span> </div>
          <div class="right-item"> <textarea name="remarks" id="remarks"  class="form-control"></textarea></div>
          </div>
           <div class="content-box">
        <div class="left-item"> <span>Antina Recd:</span> </div>
          <div class="right-item">
          <table>
            <tr>
              <td><input type="radio" name="antina_recd" id="yes" value="yes" ></td>
              <td>Yes </td>
              <td><input type="radio" name="antina_recd" id="no" value="no"></td>
              <td>No </td>
            </tr>
          </table>
          </div>
          </div>
           
           <div class="content-box">
        <div class="left-item"> <span>Immobilizer Recd :</span> </div>
          <div class="right-item">
          <table>
            <tr>
              <td><input type="radio" name="immob_recd" id="yes" value="yes"></td>
              <td>Yes </td>
              <td><input type="radio" name="immob_recd" id="no" value="no" ></td>
              <td>No </td>
            </tr>
          </table>
          </div>
          </div>
          <div class="content-box">
        <div class="left-item"> <span>Connector Recd :</span> </div>
          <div class="right-item">
          <table>
            <tr>
              <td><input type="radio" name="conn_recd" id="yes" value="yes"></td>
              <td>Yes </td>
              <td><input type="radio" name="conn_recd" id="no" value="no"></td>
              <td>No </td>
            </tr>
          </table>
          </div>
          </div>
          
           <div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item"><input  class="btn btn-primary" type="submit" name="Submit" id="device_submit" value="Submit"> <input  class="btn btn-default" type="button" name="Submit" value="Cancel"></div>
          </div>
      </div>
    </div>
  </div>
  <!--page div 1 end-->  
 
</article>
</form>
</body>
<script>
function deviceRecdFromClient() 
{
	var e = document.getElementById("user_list");
	var user_name= e.options[e.selectedIndex].value;
	var m = document.getElementById("veh_list");
	var veh_list= m.options[m.selectedIndex].value;
	 var company_name = document.forms["device_from_cl"]["company_name"].value;
	var device_imei =document.forms["device_from_cl"]["device_imei"].value;
	var itgc_id = document.forms["device_from_cl"]["itgc_id"].value;
	//alert(itgc_id);

	if(user_name==0)
	{
		alert("Please Select User");
		document.device_from_cl.user_list.focus();
		return false;
	} 
	if(veh_list==0)
	{
		alert("Please Select Vehicle");
		document.device_from_cl.veh_list.focus();
		return false;
	}
 	if(company_name==0 || company_name=="")
	{
		alert("Please Company Name");
		document.device_from_cl.company_name.focus();
		return false;
	} 
	if(device_imei==0 || device_imei=="" )
	{
		alert("Please Insert IMEI");
		document.device_from_cl.device_imei.focus();
		return false;
	} 
	if(itgc_id==0 || itgc_id=="" )
	{
		alert("Please Insert ITGC ID");
		document.device_from_cl.itgc_id.focus();
		return false;
	}
}
</script>
<script type="text/javascript">
var $device_from_client = jQuery.noConflict();
function veh_list1(value)
{
	$device_from_client.ajax({
	type:"POST",
	url:"veh_list.php",
	data:'val='+ value,
	success:function(msg)
	{
		//alert(msg);
		var spl2 = msg.split('#');
		var dataLen2=spl2.length;
		if(dataLen2>0)
		{
			$device_from_client('#veh_list').empty();
			for (var i=0; i<dataLen2; i++) 
			{
				var veh_list = spl2[i].split('~');
				$device_from_client('#veh_list').append('<option value="' + veh_list[0] + '">' + veh_list[1] + '</option>');
			} 
			}
		else
		    {
			}
	}
	});
}

function companyName()
{
	var user_id = $device_from_client('#user_list').val();
	$device_from_client.ajax({
			type:"GET",
			url:"userInfo.php?action=company_name",
			//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
			data:"user_id=" + user_id,
			success:function(data){
			//alert(data);
			//var $response=$device_from_client(data);
			// var oneval = $response.filter('#company_name').text();
			//$device_from_client( "#company_name" ).append( data );
			$device_from_client('#company_name').val(data);
						
		}
	});
}


function imeiNo()
{	
	var veh_no=$device_from_client("#veh_list option:selected").text();
	$device_from_client.ajax({
			type:"GET",
			url:"userInfo.php?action=imei_no",
			data:"veh_no=" + veh_no,
			  beforeSend: function(msg){
		 	$device_from_client("#device_submit").prop('disabled', true);
		  }, 
			success:function(msg){
			$device_from_client("#device_submit").prop('disabled', false);
			var imei_itgc=msg.split('##');
			$device_from_client('#device_imei').val(imei_itgc[0]);
			$device_from_client('#itgc_id').val(imei_itgc[1]);
						
		}
	});
}

    $device_from_client('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $device_from_client('.form_date').datetimepicker({
       // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $device_from_client('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });


</script>
</html>