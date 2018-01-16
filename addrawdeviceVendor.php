<?php
ob_start();
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$ITGC_ID=array();
$masterObj = new master();	
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$brandList=select_Procedure("CALL SelectDevType()");
$brandList=$brandList[0];  			
 
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
        <div class="caption"> <i class="fa fa"></i>Add Raw Vendor Device</div>
      </div>
      <div class="portlet-body control-box">
	  
	     
           <div class="content-box">
        <div class="left-item"> <span>Device :</span> </div>
          <div class="right-item">
          <table>
            <tr>
              <td><input type="radio" name="gtrac" value="1" checked onChange="vendorDevice(this.value)"></td>
              <td>Vendor Device </td>
            </tr>
          </table>
          </div>
          </div>
           <div class="content-box">
           <div class="left-item"> <span>No.Of Devices :</span> </div>
          <div class="right-item"> <input type="text" name="no_of_device" id="no_of_device" class="form-control" ></div>
         <span class="error">* <?php echo $errNoDevice;?></span> </div>
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
           <div class="left-item"> <span>Date :</span> </div>
          <div class="right-item"> <input type="text" name="date" id="date" value="<?php echo date('Y-m-d H:i:s');?>" class="form-control form_date"></div>
		
           <div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item"><input  class="btn btn-primary btnaddsim" name="Submit" value="Submit" id="submit" width="50%"> <input  class="btn btn-default" type="reset" name="Submit" id="cancel" value="Cancel" onclick='cancelAll();'></div>
          </div>
		 </div>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
  </div>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow" id="multivalue" style="display:none;" >
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i></div>
      </div>
	  
      <div class="portlet-body">
	   
      <table class="table table-bordered table-hover" id="MainTable">
		
          <thead>
            <tr>
			  <th>Itgc Id</th>
              <th> Sim No </th>
              <th> Phone No</th>
			  <th> Imei </th>
			  <th> Operators </th>
			  <th> <input type="submit" class="btn btn-primary submit"  name="submit" value="Add Device" /> </th>
			  
            </tr>
          </thead>
          <tbody>
			  <tr id="FirstRow"> 
			  	<td><div id="tt"></div></td>
              	<td><div id="textA"></div></td>
				<td><div id="textB"></div></td>
				<td><div id="textC"></div></td>
				<td><div id="myDiv"></div></td>
            </tr>
          </tbody>

        </table>
			    <td><p align="center"></p></td>
		
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
		
		var no_of_device = $form("#no_of_device").val();
		var parent_id = $form("#device_type").val();
		var model_type = $form("#model_type").val();
		var rec_date = $form("#date").val();
		var inp = $form('#tt');
		if (no_of_device == ''|| no_of_device == 0 || parent_id == ''  || parent_id == 0 || model_type == ''  || model_type == 0)
		{
			alert('Pls enter all the Fields');
			return false;
		}
			
		else{

			$form(".btnaddsim").attr("disabled", !($form(".btnaddsim").attr("disabled")));
			
				var opert = ["Airtel", "Vodafone", "Aircel","Reliance"]; 
				var options = "";
				for(var i =0; i < no_of_device; i++)
				{
					var sim_no = "<input type='text' class='form-control' name='sim_no[]' maxlength='19' />";
					var phone_no = "<input type='text' class='form-control' name='phone_no[]' maxlength='10' />";
					var imei_no = "<input type='text' class='form-control' name='imei_no[]' />";
					var selectList = document.createElement("select");
					selectList.setAttribute("id", "operater");
					selectList.setAttribute("name", "operater[]");
					selectList.setAttribute("class", "form-control");
					myDiv.appendChild(selectList);
				 	for (var k = 0; k < opert.length; k++) {
					var option = document.createElement("option");
					option.setAttribute("value", opert[k]);
					option.text = opert[k];
					selectList.appendChild(option);
			
				}
				}
				for(var j=0; j < no_of_device ; j++)
				{
					$form("#textA").append(sim_no);
					$form("#textB").append(phone_no);
					$form("#textC").append(imei_no);
				}
				$form.ajax({
				type:"POST",
				url:"userInfo.php?action=raw_device",
				data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id,
				success:function(msg)
				{
					//alert(msg);
					var serial_no=msg;
					for (var i = 0; i < no_of_device; i++) 
					{
						serial_no++;
						$form('<tr><td><span id="lbl_itgcid">'+serial_no+ 'X </span></td><input type="hidden" name="serial_no[]" id="serial_no" value="'+serial_no+'"><div class="right-item"><td><input type="text" class="form-control" id="txtVisionTekId" class="" name="txtVisionTekId[]" maxlength="15" /></div></td></tr>').appendTo(inp);
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
		var no_of_device = $form("#no_of_device").val();
		var parent_id = $form("#device_type").val();
		var model_type = $form("#model_type").val();
		var rec_date = $form("#date").val();
		
				$form.ajax({
				type:"GET",
				url:"userInfo.php?action=vendor_device_addition",
				data: $form('#form1').serialize(),
				//data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id + '&model_type=' + model_type,
				success:function(msg)
				{
					alert(msg);
					var data = $form.trim(msg);
					if(data == "Insert Successfully")
					{
					   document.location.href = 'addrawdeviceVendor.php';
					}

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