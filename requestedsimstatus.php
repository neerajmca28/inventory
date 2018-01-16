<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0];
$branch=0;
$GetRequestedSim=select_Procedure("CALL GetRequestedSim('".$branch."')");
$GetRequestedSim=$GetRequestedSim[0];
//echo '<pre>';print_r($GetRequestedSim);'</pre>'; die; 
$rowcount=count($GetRequestedSim);
?>
<head>

</head>
<body>
	<div class="processing-img" id="loadingmessage" style='display:none;'>
			<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
			</div>
<article>
<div class="col-12"> 
 <form name="requested_simstatus" id="requested_simstatus" method="post" action="" >
	<div class="portlet box yellow">
				<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Requested Sim Status </div>
				</div> 
	<div class="portlet-body control-box">
 <div class="content-box">
					<div class="left-item"> <span> Branch Name :</span> </div>
	<div class="right-item"><select class="form-control"  name="operater[]" id="operater" onChange="">
	<option value="">Select</option>
			  <?php for($x=0;$x<count($branchList);$x++)
			  {?>
				<option value="<?php echo $branchList[$x]['id'];?>"><?php echo $branchList[$x]['branch_name'];?></option>
              <?php } ?>
              
            </select> </div>	</div>	</div>	</div>
			 </form> 

</div>

<!-- BEGIN BORDERED TABLE PORTLET-->


		  <div class="col-12"> 

		<div class="portlet box yellow" id="">
				<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Sim Status </div>
				</div>
		<div class="portlet-body" id="default">
	  
			<table class="table table-bordered table-hover" id="filtertable">
         
			  <thead>
				<tr>
				  <th>Branch Name </th>
				  <th> Operator Name </th>
				  <th> Total Requested Sim </th>
				  <th> Pending Sim </th>
				  <th>LastRequestedUnits </th>
				  <th> LastRequestedDate </th>
				  <th>Remarks</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 

				for($x=0;$x<$rowcount;$x++)
				{
					$y=$x+1;
				?>
				<tr>
				  <?php $branch_id=$GetRequestedSim[$x]['branch_id'];
				  if($branch_id==1)
				  {
					  $branch_id='Delhi';
				  }
				   if($branch_id==2)
				  {
					  $branch_id='Mumbai';
				  }
				   if($branch_id==3)
				  {
					  $branch_id='Jaipur';
				  }
				   if($branch_id==4)
				  {
					  $branch_id='Sonepat';
				  }
				   if($branch_id==5)
				  {
					  $branch_id='Kanpur';
				  }
					if($branch_id==6)
				  {
					  $branch_id='Ahmedabad';
				  }
					if($branch_id==7)
				  {
					  $branch_id='kolkata';
				  }
				  ?>
				   <td><?php echo $branch_id; ?></td>
				
				  <?php $service_provider_id=$GetRequestedSim[$x]['service_provider_id'];
				  if($service_provider_id==1)
				  {
					  $service_provider_id='Airtel';
				  }
				   if($service_provider_id==2)
				  {
					  $service_provider_id='Vodafone';
				  }
				   if($service_provider_id==3)
				  {
					  $service_provider_id='Aircel';
				  }
				   if($service_provider_id==4)
				  {
					  $service_provider_id='Reliance';
				  }
				
				  ?>
					<td><?php echo $service_provider_id;?></td>
				   <td><?php echo $GetRequestedSim[$x]['total_requested_sim']; ?></td>
					<td><?php echo $GetRequestedSim[$x]['pending_sim']; ?></td>
					<td><?php echo $GetRequestedSim[$x]['last_requested_units']; ?></td>
					<td><?php echo date('d-m-Y H:i:s',strtotime($GetRequestedSim[$x]['last_requested_date'])); ?></td>
					<td><?php echo $GetRequestedSim[$x]['remarks']; ?></td>
				</tr>
				<?php } ?>
			   
			  </tbody> 
			</table>
		 </div>
	
		<div class="portlet-body" id="ss" style="display:none">
		</div>
	<div id='loadingmessage' style='display:none; width:800px; margin:0 auto';>
  <img src='Page-loading-effect-blogger.gif'/>
</div>
  </div>
</div>
				   	  
    <!-- END BORDERED TABLE PORTLET--> 

</article>

</body>
<script type="text/javascript">
var $sim_status = jQuery.noConflict();
 $sim_status(document).ready(function () {
  $sim_status( document ).ajaxStart(function() {
   $sim_status( "#loadingmessage" ).show();
    });
	    $sim_status( document ).ajaxStop(function() {
      $sim_status( "#loadingmessage" ).hide();
    });

    $sim_status('#operater').change(function() {
		document.getElementById('default').style.display = "none";
		//alert(this.value);
		document.getElementById('ss').style.display = "block";
		$sim_status.ajax({
				type:"POST",
				url:"sim_status.php",
				dataType: "html",
				data:'branch_id='+ this.value,
				success:function(msg)
				{
					 //alert(msg);
					   $sim_status("#ss").html(msg);
					   //document.getElementById('ss').style.display = "block";
					 //document.getElementById("ss").innerHTML = msg; 
					 
				},
				error:function(msg){
            
				}
		});
}); 
});
</script>
<script data-config>
    var filtersConfig = {
        base_path: 'dist/tablefilter/',
        paging: true,

        remember_grid_values: false,
        remember_page_number: false,
        remember_page_length: false,
        alternate_rows: false,
        btn_reset: true,
        rows_counter: true,
        loader: false,

        status_bar: true,

        status_bar_css_class: 'myStatus',

        extensions:[{
            name: 'sort',
          types: [
                    'string','string','number','number','number','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>

</html>