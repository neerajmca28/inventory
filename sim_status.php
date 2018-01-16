<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
$branch_id=$_POST['branch_id'];
if(isset($_POST['branch_id']))
{
	$branch_id=$_POST['branch_id'];
}
else
{
	$branch_id=0;
}

	$GetRequestedSim=select_Procedure("CALL GetRequestedSim('".$branch_id."')");
	$GetRequestedSim=$GetRequestedSim[0];
	$rowcount=count($GetRequestedSim);
	//echo '<pre>';print_r($GetRequestedSim); echo '</pre>'; die;


 

?>
 <div>

        <table class="table table-bordered table-hover" id="filteration">
             
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

    var tf = new TableFilter('filteration', filtersConfig);
    tf.init();

</script>
	

