<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();	
//$branch_id=$_SESSION['branch_id']; 
 $branch_id=2; 
$repairDevice=select_Procedure("CALL SendToRepairDevice('".$branch_id."')");
$repairDevice=$repairDevice[0];
//$dbselect=$dbselect[0];
/*  echo "<pre>";
print_r($repairDevice); 
"</pre>";die;   */
?>
<head>
</head>

<body>

<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
 
	   <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Send To Repair</div>
      </div>

      
    </div>
	
	<div class="portlet box yellow" id="ss">
      <div class="portlet-title">
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th>ITGC ID </th>
              <th> Imei </th>
              <th> Vehilce No </th>
			  <th> Client Name </th>
			  <th>Remove Date</th>
              <th> Send To Repair Center Date </th>
			  <th>Immobilizer</th>
              <th> Connectors </th>
              <th> Recevied Installer Name </th>
			   <th>Removed Installer Name</th>
              <th> Remarks </th>
              <th> Inventory Status </th>
			  <th> PendingDays </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($repairDevice);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
			  <td><?php echo $repairDevice[$x]['itgc_id']; ?></td>
              <td><?php echo $repairDevice[$x]['device_imei'];?></td>
			  <td><?php echo $repairDevice[$x]['veh_no']; ?></td>
			  <td><?php echo $repairDevice[$x]['client_name']; ?></td>
			  <?php if(date('d-m-Y H:i:s',strtotime($repairDevice[$x]['device_removed_date']))=='01-01-1970 05:30:00')
				{
					 $device_removed_date="";
				}
				else{
					$device_removed_date=date('d-m-Y H:i:s',strtotime($repairDevice[$x]['device_removed_date']));
				}
				?>
				<td><?php echo $device_removed_date; ?></td>
			  
			    

				    <?php if(date('d-m-Y H:i:s',strtotime($repairDevice[$x]['sendtorepaircenter']))=='01-01-1970 05:30:00')
				{
					 $sendtorepaircenter="";
				}
				else{
					$sendtorepaircenter=date('d-m-Y H:i:s',strtotime($repairDevice[$x]['sendtorepaircenter']));
				}
				?>
				<td><?php echo $sendtorepaircenter; ?></td>
			 <?php $is_immobilizer_recd=$repairDevice[$x]['is_immobilizer_recd'];
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
			 <?php $is_connectors_recd=$repairDevice[$x]['is_connectors_recd'];
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
			  
			  
			  
			    <td><?php echo $repairDevice[$x]['Received_installer_name']; ?></td>
			  <td><?php echo $repairDevice[$x]['Remove_installer_name']; ?></td>
              <td><?php echo $repairDevice[$x]['branch_repaired_remarks'];?></td>
			  <td><?php echo $repairDevice[$x]['status']; ?></td>
			  <td><?php echo $repairDevice[$x]['PendingDays']; ?></td>
			 
            </tr>
            <?php } ?>
          </tbody>
          </form> 
        </table>
      </div>
    </div>
	<div id="show_branch"></div>
	
	
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
</article>
<script data-config>
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
                    'number','number','number','number','number','string', 'number','number', 'number','string','string','string','string','string','string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>