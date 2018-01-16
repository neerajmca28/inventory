<?php
include("config.php");
include("device_status.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 

$condition="";
$masterObj = new master();	
$branch_id=$_SESSION['branch_id'];
$strUsers=db__select_matrix("SELECT id as user_id, sys_username as name FROM matrix.users order by name asc");
$itemList=db__select("select item_id,item_name from item_master order by item_name");
//echo "<pre>"; print_r($itemList); "</pre>";

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
.form-control{
	width: 20%;
}
</style>
</head>
<body>
 <form name="device_from_cl" id="device_from_cl" method="post" action="" onsubmit="return deviceRecdFromClient();"  >

<article> 

  <!--page div 1 start-->
  <div class="col-12">
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Device Material</div>
      </div>
      <div class="portlet-body control-box">
   
       
          <div class="content-box">
           <div class="left-item"> <span> Devices :</span> </div>
          <div class="right-item"> <select class="form-control" name="device" id="device" onchange="veh_list1(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($itemList);$i++)
			{?>
            <option value="<?php echo $itemList[$i]['item_id']?>"><?php echo $itemList[$i]['item_name'];?>
            </option>
            <? } ?>
	
         </select></div>
          </div>
		 <div class="content-box">
           <div class="left-item"> <span> Device Model :</span> </div>
          <div class="right-item"> <select class="form-control" name="model_list" id="model_list" onchange="veh_list1(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($itemList);$i++)
			{?>
            <option value="<?php echo $itemList[$i]['item_id']?>"><?php echo $itemList[$i]['item_name'];?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

           <div class="content-box">
           <div class="left-item"> <span> Immoblizer Type:</span> </div>
          <div class="right-item"> <select class="form-control" name="immob_type" id="immob_type">
         <option value="0">12VT</option>
          <option value="1">24VT</option>
         </select></div>
          </div>

      <div class="content-box">
        <div class="left-item"> <span> Immoblizer Count:</span> </div>
         <div class="right-item"> <select class="form-control" name="immob_count" id="immob_count">
         <option value="0">0</option>
			<?
				for($i=1;$i<=50;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

	 <div class="content-box">
           <div class="left-item"> <span> Connector:</span> </div>
          <div class="right-item"> <select class="form-control" name="connector_count" id="connector_count">
         <option value="0">0</option>
			<?
				for($i=1;$i<=50;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>
         
          <div class="content-box">
           <div class="left-item"> <span> Antenna:</span> </div>
          <div class="right-item"> <select class="form-control" name="antena_count" id="antena_count">
         <option value="0">0</option>
			<?
				for($i=1;$i<=50;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>
		
		 <div class="content-box">
           <div class="left-item"> <span> IP Box:</span> </div>
          <div class="right-item"> <select class="form-control" name="ip_box" id="ip_box">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>


		 <div class="content-box">
           <div class="left-item"> <span> M-Ceal:</span> </div>
          <div class="right-item"> <select class="form-control" name="mceal" id="mceal">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

          	 <div class="content-box">
           <div class="left-item"> <span> Panic Button:</span> </div>
          <div class="right-item"> <select class="form-control" name="panic_button" id="panic_button">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

          <div class="content-box">
           <div class="left-item"> <span> Tye-Belt:</span> </div>
          <div class="right-item"> <select class="form-control" name="tye_belt" id="tye_belt">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

          <div class="content-box">
           <div class="left-item"> <span>Send Date :</span> </div>
          <div class="right-item"> <input type="text" name="recd_date" id="recd_date" class="form-control form_date" value="<?php echo date('Y-m-d H:i:s');?>"></div>
          </div>

          <div class="content-box">
           <div class="left-item"> <span>Remarks :</span> </div>
          <div class="right-item"> <textarea name="remarks" id="remarks"  class="form-control"></textarea></div>
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