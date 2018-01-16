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
        <div class="caption"> <i class="fa fa"></i>Add Raw Device </div>
      </div>
      <div class="portlet-body control-box">
	  
	     
           <div class="content-box">
        <div class="left-item"> <span>Device :</span> </div>
          <div class="right-item">
          <table>
            <tr>
              <td><input type="radio" name="gtrac" value="gtrac_device" checked onChange="crackDevice(this.value)"></td>
              <td>Gtrac Device </td>
              <td><input type="radio" name="gtrac" value="crack_device" onChange="crackDevice(this.value)"></td>
              <td>Cracked Device </td>
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
          <div class="right-item"> <input type="text" name="date" id="date" value="<?php echo date('Y-m-d');?>" class="form-control form_date"></div>
          </div>
		   <div id="client_user" class="content-box" style="display:none">
           <div class="left-item"> <span>UserName :</span> </div>
          <div class="right-item"> <input type="text" name="username_client" id="username_client" class="form-control" ></div>
          </div>
           <div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item"><input  class="btn btn-primary btnaddsim" onClick=""  name="Submit" value="Submit" id="submit"> <input  class="btn btn-default" type="reset" name="Submit" id="cancel" value="Cancel" onclick='cancelAll();'></div>
          </div>
		 </div>
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
			
		//var no_of_device = document.getElementById("no_of_device").value;
		//var parent_id = document.getElementById("device_type").value;
		//alert(no_of_device);
		//alert(parent_id);
		else{
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
						$form('<div class="content-box" id="MainTable"><div class="left-item"><span id="lbl_itgcid">'+serial_no+ 'X </span><input type="hidden" name="serial_no[]" id="serial_no" value="'+serial_no+'"></div> <div class="right-item"><input type="text" class="form-control" id="txtVisionTekId" class="" name="txtVisionTekId[]" /></div></div>').appendTo(inp);
						
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
		//firstvalue = $form("#serial_no").val();
		//firstvalue = document.form1.serial_no.value;
		//var inp = $form('#tt');
		
			
		//var no_of_device = document.getElementById("no_of_device").value;
		//var firstvalue = document.getElementById("serial_no").value;
		//firstvalue = document.getElementsByName("serial_no[]");
		//alert(no_of_device);
		//alert(firstvalue);
				//var Table = document.getElementById("MainTable");
					//Table.innerHTML = "";
				$form.ajax({
				type:"GET",
				url:"userInfo.php?action=itgc_check",
				data: $form('#form1').serialize(),
				//data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id + '&model_type=' + model_type,
				success:function(msg)
				{
					alert(msg);
					var data = $form.trim(msg);
					if(data == "Insert Successfully")
					{
					   document.location.href = 'addrawdevice.php';
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
/* function cancelAll()
{
	//alert('tt');
	//document.getElementById('multivalue').style.display = "none";
	//$form("#MainTable tr").remove(); 
	var Table = document.getElementById("multivalue");
	Table.innerHTML = "";

} */



function crackDevice(radioValue)
{
	
 if(radioValue=="crack_device")
    {
		document.getElementById('client_user').style.display = "block";
    } 
 if(radioValue=="gtrac_device")
    {
		document.getElementById('client_user').style.display = "none";
    } 
	
	
   
}
	</script>
</html>