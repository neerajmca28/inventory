	<?php
ob_start();
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$ITGC_ID=array();
$masterObj = new master();	
if($_SESSION['user_name_inv']!='aditya')
{
?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$brandList=select_Procedure("CALL SelectDevType()");
$brandList=$brandList[0];  
 $zz=explode('##',$_POST['rowVal'][0]);
 //echo '<pre>'; print_r($_POST['rowVal'][0]); die;
  $service_req_id=$zz[0]; 
  $device_imei=$zz[1]; 
  $serv_crack_id=$zz[2]; 
//echo '<pre>'; print_r($_POST); die;
// $service_req_id=$_POST['id'];
// $device_imei=$_POST['id'];
// $serv_crack_id=$_POST['id'];
$branchId=$_SESSION['branch_id'];
//print_r($_GET); die;
//$service_id=$_GET['service_id'];	

// $installerList=db__select_staging("select inst_name,inst_id from installer where inst_id='".$inst_id."'");
//print_r($installerList); die;
 $simList=db__query("select sim.sim_no,sim.phone_no,sim.sim_id from sim inner join simchallandetail on sim.sim_id=simchallandetail.sim_id WHERE flag=1 and branch_id=1 and sim_status='93'and active_status=1 and RepairName=17");
//$simList=db__query("select sim.sim_no,sim.phone_no from sim inner join simchallandetail on sim.sim_id=simchallandetail.sim_id WHERE sim.flag=1 and sim.active_status=1 and simchallandetail.installerID='".$inst_id."' ");
//echo $simList; die;
//$simList=mysql_fetch_array($tt);
//echo '<pre>'; print_r($simList); die;
// if (isset($_POST['submit']))
// {
	
// }
?>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>
<article>
 <form method="post" action="" name="form1" id="form1" onSubmit="return req_info();">
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Add Crack Device </div>
      </div>
      <div class="portlet-body control-box">
	  
	     
        <div class="content-box">
        <div class="left-item"> <span>Device :</span> </div>
          <div class="right-item">
          <table>
            <tr>
              <td><input type="radio" name="crack_dev" value="crack" checked></td>
              <td>Crack</td>
             <!--  <td><input type="radio" name="gtrac" value="crack_device" onChange="crackDevice(this.value)"></td>
              <td>Cracked Device </td> -->
            </tr>
          </table>
          </div>
          </div>
     <!--       <div class="content-box">
           <div class="left-item"> <span>No.Of Devices :</span> </div>
          <div class="right-item"> <input type="text" name="no_of_device" id="no_of_device" class="form-control" ></div>
         <span class="error">* <?php echo $errNoDevice;?></span> </div> -->
           <div class="content-box">
           <div class="left-item"> <span> Device Type :</span> </div>
          <div class="right-item"> <select class="form-control" name="device_type" id="device_type" onChange="modelList(this.value);">
         <option value="0">Select Device Type</option>
			<?
				for($i=0;$i<count($brandList);$i++)
			{?>
            <option value="<?=$brandList[$i]['item_id']?>"><?php echo $brandList[$i]['item_name'];?>
            </option>
            <? } ?>
	
         </select></div><span class="error">* <?php echo $errdevice_type;?></span> </div>
          
           <div class="content-box">
           <div class="left-item"> <span>Model No :</span> </div>
          <div class="right-item"> <select class="form-control" name="model_type" id="model_type">
         <option>Select Model Type</option>
         
         </select></div><span class="error">* <?php echo $errmodel_type;?></span></div>
          <div class="content-box">
        
           <div class="left-item"> <span>IMEI No :</span> </div>
          <div class="right-item"> <input type="text" name="device_imei" id="device_imei" value="<?php echo $device_imei; ?>" class="form-control" ></div>
          <input type="hidden" name="ser_req_id" id="ser_req_id" value="<?php echo $service_req_id; ?>">
          <input type="hidden" name="ser_req_crack_id" id="ser_req_crack_id" value="<?php echo $serv_crack_id; ?>">
         <span class="error">* <?php echo $errNoDevice;?></span> </div> 
          <!--  <div class="content-box">
           <div class="left-item"> <span>SIM No :</span> </div>
          <div class="right-item"> <input type="text" name="sim_no" id="sim_no" class="form-control" ></div>
         <span class="error">* <?php echo $errNoDevice;?></span> </div>  -->
         <div class="content-box">
           <div class="left-item"> <span>SIM No :</span> </div>
           <div class="right-item"> <select class="form-control" name="sim_no" id="sim_no">
         <option value="0">Select</option>
			<?
			for($i=0;$i<count($simList);$i++)
			{
			?>
            		<option value="<?=$simList[$i]['sim_id']?>"><?php echo $simList[$i]['phone_no'];?>
            		</option>
            <? 
            } 
            ?>
	
         </select>
		 </div>
		 <!-- <input type="hidden" name="installer_list_hidden" id="installer_list_hidden" value="<?php echo $installerList[0]['inst_id']; ?>">
		  <input type="hidden" name="service_req" id="service_req" value="<?php echo $service_req; ?>"> -->
		  </div>

		 
           <div class="content-box">
           <div class="left-item"> <span>Date :</span> </div>
          <div class="right-item"> <input type="text" name="date" id="date" value="<?php echo date('Y-m-d H:i:s');?>" class="form-control form_date"></div>
		<!--    <div id="client_user" class="content-box">
           <div class="left-item"> <span>UserName(if any):</span> </div>
          <div class="right-item"> <input type="text" name="username_client" id="username_client" class="form-control" ></div>
          </div> -->
           </div>

           <div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item"><input  class="btn btn-primary btnaddsim" onClick=""  name="Submit" value="Submit" id="submit"> <input  class="btn btn-default" type="reset" name="Submit" id="cancel" value="Cancel" onclick='cancelAll();'></div>
          </div>
	
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
  </div>
  <div class="col-md-6 col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow" id="multivalue" style="display:none;" >
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Add Device Table </div>
      </div>
	  <div id='tt' style="padding:10px 5px"></div>
      <div class="portlet-body">
	   
      
			    <td><p align="center"><input type="submit" class="btn btn-primary submit"  name="submit" value="Add Device" /></p></td>
		
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>



   </form>
</article>
</body>

 <script type="text/javascript">

var $da = jQuery.noConflict();


    $da('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $da('.form_date').datetimepicker({
       // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $da('.form_time').datetimepicker({
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
<script type="text/javascript">
var $form = jQuery.noConflict();
 $form(document).ready(function () {
	 	 $form('#cancel').click(function () {
			 	$form(".btnaddsim").attr("disabled", !($form(".btnaddsim").attr("disabled")));
				$form("#tt").hide();
				//$form("#MainTable tr").remove(); 
				//var Table = document.getElementById("MainTable");
				//Table.innerHTML = "";
				window.location.reload();
				
				
		 });
	 
	 
    $form('.btnaddsim').click(function (){
		
		var no_of_device = 1;
		var parent_id = $form("#device_type").val();
		var model_type = $form("#model_type").val();
		var device_imei = $form("#device_imei").val();
		var sim_no = $form("#sim_no").val();
		var rec_date = $form("#date").val();
		var inp = $form('#tt');
		if (no_of_device == ''|| no_of_device == 0 || parent_id == '' || parent_id == 0 || model_type == ''  || model_type == 0 || device_imei == '' || device_imei == 0 || sim_no == '' || sim_no == 0 )
		{
			alert('Pls enter all the Fields');
			return false;
		}
		else{

			$form(".btnaddsim").attr("disabled", !($form(".btnaddsim").attr("disabled")));
				//var Table = document.getElementById("MainTable");
					//Table.innerHTML = "";
				$form.ajax({
				type:"POST",
				url:"userInfo.php?action=raw_device",
				data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id,
				success:function(msg)
				{
					//alert(msg);
					//$form("#MainTable tr").remove(); 
				
				//document.getElementById('.btnaddsim').disabled = true;
					var serial_no=msg;
					for (var i = 0; i < no_of_device; i++) 
					{
						serial_no++;
						 //var s= document.getElementById('hidden');
							//s.value = serial_no;
							//alert(s.value);
						$form('<div class="content-box" id="MainTable"><div class="left-item"><span id="lbl_itgcid">'+serial_no+ 'X </span><input type="hidden" name="serial_no[]" id="serial_no" value="'+serial_no+'"></div> <div class="right-item"><input type="text" class="form-control" id="txtVisionTekId" class="" name="txtVisionTekId[]" maxlength="15" /></div></div>').appendTo(inp);
						
						document.getElementById('multivalue').style.display = "block";
					}
		
				}
		});
		}
		return false;
			
			});
			
	 $form('.submit').click(function (){
		//alert('t');
		var firstvalue = new Array()
		var no_of_device = 1;
		// var parent_id = $form("#device_type").val();
		// var model_type = $form("#model_type").val();
		// var device_imei = $form("#device_imei").val();
		// var sim_no = $form("#sim_no").val();
		// var rec_date = $form("#date").val();
		$form.ajax({
				type:"GET",
				url:"userInfo.php?action=CrackAdd",
				data: $form('#form1').serialize(),
				//data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id + '&model_type=' + model_type,
				success:function(msg)
				{
					alert(msg);
					var data = $form.trim(msg);
					if(data == "Insert Successfully")
					{
					   document.location.href = 'addDevice_crack.php';
					}
						//window.location.href = "client_group.php";
					//$form("#MainTable tr").remove(); 
		
				}
			});
		
		return false;
			
			}); 		
});



function modelList(value)
	{
				//alert(value);
				$form.ajax({
				type:"POST",
				url:"modelList.php",
				data:'val='+ value,
				success:function(msg)
				{
					//alert(msg);
					var spl2 = msg.split('#');
					var dataLen2=spl2.length;
					if(dataLen2>0)
					{
						$form('#model_type').empty();
						for (var i=0; i<dataLen2; i++) 
						{
						  var model_list = spl2[i].split('~');
						  $form('#model_type').append('<option value="' + model_list[0] + '">' + model_list[1] + '</option>');
					 
						} 
					}
					else
					{
						
					}
			}
		});
	}



	</script>
</html>