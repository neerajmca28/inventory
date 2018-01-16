<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$branch_id=$_SESSION['branch_id'];
$InternalRepairedDevice=select_Procedure("CALL InternalRepairedDevice('".$branch_id."')");
$InternalRepairedDevice=$InternalRepairedDevice[0];
$rowcount=count($InternalRepairedDevice);
//$installer_list=db__select_staging("select * from internalsoftware.installer where",array( 'branch_id'=>'".$branch_id."', 'is_delete'=>1));
//print_r($installer_name); die; 

?>
<head>
</head>
<body>
 <form name="dispatchdevice" id="dispatchdevice" method="post" action="" >

				
<article>

  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Internal Repair Device </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th>ITGC ID </th>
              <th> IMEI </th>
              <th> Vehicle No </th>
              <th> Client Name </th>
			  <th> Remove Date </th>
			  <th> Recevie Date </th>
              <th> Send To Repair Center Date</th>
              <th> Antenna</th>
			  <th> Immobilizer</th>
              <th> Connectors</th>
              <th> Received Installer Name</th>
			  <th> Removed Installer Name</th>
              <th> Remarks</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              
			   
			   <td><?php echo $InternalRepairedDevice[$x]['itgc_id']; ?></td>
			   <td><?php echo $InternalRepairedDevice[$x]['device_imei']; ?></td>
			   <td><?php echo $InternalRepairedDevice[$x]['veh_no']; ?></td>
			   <td><?php echo $InternalRepairedDevice[$x]['client_name']; ?></td>
			   <?php if(date('d-m-Y H:i:s',strtotime($InternalRepairedDevice[$x]['device_removed_date']))=='01-01-1970 05:30:00')
				{
					 $device_removed_date="";
				}
				else{
					$device_removed_date=date('d-m-Y H:i:s',strtotime($InternalRepairedDevice[$x]['device_removed_date']));
				}
				?>
				<td><?php echo $device_removed_date; ?></td>
				
				<?php if(date('d-m-Y H:i:s',strtotime($InternalRepairedDevice[$x]['device_removed_recddate']))=='01-01-1970 05:30:00')
				{
					 $device_removed_recddate="";
				}
				else{
					$device_removed_recddate=date('d-m-Y H:i:s',strtotime($InternalRepairedDevice[$x]['device_removed_recddate']));
				}
				?>
				<td><?php echo $device_removed_recddate; ?></td>
			
				<?php if(date('d-m-Y H:i:s',strtotime($InternalRepairedDevice[$x]['sendtorepaircenter']))=='01-01-1970 05:30:00')
				{
					 $sendToRepairDate="";
				}
				else{
					$sendToRepairDate=date('d-m-Y H:i:s',strtotime($InternalRepairedDevice[$x]['sendtorepaircenter']));
				}
				?>
				<td><?php echo $sendToRepairDate; ?></td>
				
				<?php  $is_antenna_recd= $InternalRepairedDevice[$x]['is_antenna_recd']; 
				if($is_antenna_recd==1)
				{
					$is_antenna_recd='true';
				}
				else
				{
					$is_antenna_recd='false';
				}
				
				?>
				<td><?php echo $is_antenna_recd; ?></td>
				<?php  $is_immobilizer_recd= $InternalRepairedDevice[$x]['is_immobilizer_recd']; 
				if($is_immobilizer_recd==1)
				{
					$is_immobilizer_recd='true';
				}
				else
				{
					$is_immobilizer_recd='false';
				}
				
				?>
				<td><?php echo $is_immobilizer_recd; ?></td>
				<?php  $is_connectors_recd= $InternalRepairedDevice[$x]['is_connectors_recd']; 
				if($is_connectors_recd==1)
				{
					$is_connectors_recd='true';
				}
				else
				{
					$is_connectors_recd='false';
				}
				
				?>
				<td><?php echo $is_connectors_recd; ?></td>
	
				<td><?php echo $InternalRepairedDevice[$x]['Received_installer_name']; ?></td>
				<td><?php echo $InternalRepairedDevice[$x]['Remove_installer_name']; ?></td>
				<td><?php echo $InternalRepairedDevice[$x]['branch_repaired_remarks']; ?></td>
	
            </tr>
            <?php } ?>
           
          </tbody>
          </form> 
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
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
                    'number','number','number','string', 'number','number', 'number','string','string','string','string','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>