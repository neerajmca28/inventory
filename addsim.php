<?php
ob_start();
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$masterObj = new master();	
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}

		$service_provider=select_Procedure("CALL SelectServiceProvider()");
		$service_provider=$service_provider[0];
		 $count_opt=count($service_provider);

?>
<head>


</head>

<body>
<article>
 <div class="col-12"> 
   
    <!-- BEGIN BORDERED TABLE PORTLET-->
	<form method="post" action="" name="form_addSimPhone" id="form_addSimPhone" onSubmit="">
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Add New Sim  </div>
      </div>
      <div class="portlet-body control-box">
	  
	      <!--<form method="post" action="" name="form1" onSubmit="return req_info();">-->
          
           <div class="content-box">
           <div class="left-item"> <span>No.Of Sim :*</span> </div>
          <div class="right-item"> <input type="text" name="no_of_sim" id="no_of_sim" class="form-control" ></div>
          </div>
           <div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item">
			<div  class="btn btn-primary btnaddsim" >Submit </div>
		  <input  class="btn btn-default" type="reset" name="Submit1"  value="Cancel" id="cancel"></div>
          </div>
		  <!--</form>-->
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 

    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow"  id='tt' style="display:none;margin-top:10px;">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Add Sim Table </div>
      </div>
      <div class="portlet-body">
	   
        <table class="table table-bordered table-hover" id="MainTable">
		
          <thead>
            <tr>
              <th> Sim No </th>
              <th> Phone No</th>
			  <th>Operators</th>
              <th> Activation Status </th>
            </tr>
          </thead>
          <tbody>
			  <tr id="FirstRow"> 
			
              			<td><div id="textA"></div></td>
				 <td><div id="textB"></div></td>
				<td><div id="myDiv"></div></td>
				<td><div id="check"></div></td>
				

			
            </tr>
          </tbody>
		  
		
	
        </table>
			<input type="submit" class="btn btn-primary submit"  name="submit" value="Submit" />    
				
		</form>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 

  </div>
</article>
</body>
<script type="text/javascript">
   var $form_sim = jQuery.noConflict();
  $form_sim(document).ready(function () {
		//alert('tt');
		 $form_sim('#cancel').click(function () {
			 	$form_sim(".btnaddsim").attr("disabled", !($form_sim(".btnaddsim").attr("disabled")));
				$form_sim("#tt").hide();
				//$form_sim("#MainTable tr").remove(); 
				//var Table = document.getElementById("MainTable");
				//Table.innerHTML = "";
				window.location.reload();
				
				
		 });
        $form_sim('.btnaddsim').click(function () {
			var a = $form_sim('#no_of_sim').val();
			//alert(a);
			if(a=="")
			{
				alert('Please Enter No Of SIM');
				return false;
			}
			else
			{
				$form_sim(".btnaddsim").attr("disabled", !($form_sim(".btnaddsim").attr("disabled")));
				document.getElementById('tt').style.display = "block";

				var opert = ["Airtel", "Vodafone", "Aircel","Reliance","Idea","SD-32 GB"];

				var options = "";
				for(var i =0; i < a; i++)
				{
					var sim_no = "<input type='text' class='form-control' name='sim_no[]' maxlength='19' />";
					var phone_no = "<input type='text' class='form-control' name='phone_no[]' maxlength='10' />";
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
					var cb = "<input type='checkbox' class='form-control' name='myCheckbox[]' checked  />";
			
				}
					

				
				}
				for(var j=0; j < a; j++)
				{
					$form_sim("#textA").append(sim_no);
					$form_sim("#textB").append(phone_no);
					$form_sim("#check").append(cb);
				}

		
		return false;
			}
    });  
	
		 $form_sim('.submit').click(function (){
		//alert('t');
		var firstvalue = new Array()

		
				$form_sim.ajax({
				type:"GET",
				url:"userInfo.php?action=sim_add",
				data: $form_sim('#form_addSimPhone').serialize(),
				//data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id + '&model_type=' + model_type,
				success:function(msg)
				{
					alert(msg);
					var data = $form_sim.trim(msg);
					if(data == "Mapping Successfully")
					{
					   //document.location.href = 'sim_display.php';
					   document.location.href = 'addsim.php';
					}
					//window.location.href = "client_group.php";
					//$form_sim("#MainTable tr").remove(); 
				
				
		
				}
		});
		
		return false;
			
			}); 
	
			});
			</script>
</html>
