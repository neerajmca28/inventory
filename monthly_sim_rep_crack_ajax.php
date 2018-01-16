<?php
error_reporting(0);
set_time_limit(0);
ob_start();
include("config.php");
include("device_status.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//include_once(__DOCUMENT_ROOT.'/sqlconnection.php');
$masterObj = new master();
//include($_SERVER["DOCUMENT_ROOT"]."/service/sqlconnection.php");
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branch_id=$_SESSION['branch_id'];

if(isset($_GET['action']) && $_GET['action']=='monthly_sim_crack')
{
	   echo	$start_time=date('Y-m-d',strtotime($_GET['start_date']));
		echo $end_time=date('Y-m-d',strtotime($_GET['end_date'])); 
		$branchID=$_GET['branchID']; die;
		$SimMonthyCrack=select_Procedure("CALL SimMonthyCrack('".$branchID."','".$start_time."','".$end_time."')");
		$SimMonthyCrack=$SimMonthyCrack[0]; 
		$rowcount=count($SimMonthyCrack);
		//echo '<pre>';print_r($SimMonthyRepair); echo '</pre>'; die;
}?>
 <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th> Serial No.	 </th>
              <th> sim_no </th>
              <th> phone_no	</th>
              <th>rec_date </th>
			  <th>dispatch_date </th>
			  <th>device_imei </th>
              <th> branch_name </th>
              <th> client_name </th>
			  <th> item_name</th>
			  <th> status</th>
			   <th> is_cracked</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
			  <td><?php echo $y;?></td>
			  <td><?php echo $SimMonthyCrack[$x]['sim_no']; ?></td>
			  <td><?php echo $SimMonthyCrack[$x]['phone_no']; ?></td>
			  <?php $dt=date('d-m-Y',strtotime($SimMonthyCrack[$x]['rec_date'])); 
			   if($dt=='01-01-1970' )
				  {
					  $dt='';
				  }
			   else
				  {
					   $dt=date('d-m-Y H:i:s',strtotime($SimMonthyCrack[$x]['rec_date']));
				  }
			  ?>
			  <td><?php echo $dt ?></td>
			  <?php $dt1=date('d-m-Y',strtotime($SimMonthyCrack[$x]['dispatch_date'])); 
			  if($dt1=='01-01-1970' )
				{
				  $dt1='';
				}
			  else
				{
					 $dt1=date('d-m-Y H:i:s',strtotime($SimMonthyCrack[$x]['dispatch_date']));
				}
				?>
			  <td><?php echo $dt1 ?></td>
              <td><?php echo $SimMonthyCrack[$x]['device_imei'];?></td>
			  <td><?php echo $SimMonthyCrack[$x]['branch_name']; ?></td>
			  <td><?php echo $SimMonthyCrack[$x]['client_name'];?></td>
			  <td><?php echo $SimMonthyCrack[$x]['item_name']; ?></td>
			  <td><?php echo $SimMonthyCrack[$x]['status']; ?></td>
            </tr>
            <?php } ?>
     
          </tbody>
        </table>
		<script data-config>
$reassigndead_device(document).ready(function () {
    var filtersConfig = {
        base_path: 'dist/tablefilter/',
        paging: false,

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
                    'number', 'number','number','number','number','number', 'string','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
});

</script>		






