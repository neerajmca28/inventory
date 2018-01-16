<?php
include("device_status.php");
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branch_id=$_SESSION['branch_id'];
$masterObj = new master();
$SelectRemovedRecdDevice=select_Procedure("CALL SelectRemovedRecdDevice('".$branch_id."')");
$SelectRemovedRecdDevice=$SelectRemovedRecdDevice[0];
$rowcount=count($SelectRemovedRecdDevice);
?>
<head>
</head>
<body>		
  <div class="color-sign">
      <div class="cl-item"><span class="lightgreen"></span><span>CASE IS ALREADY OPENED</span></div>
      <div class="cl-item"><span class="brown"></span><span>Device Has Gone to Manufacture</span></div>
      <div class="cl-item"><span class="silver"></span><span>Device Imei has been Changed pending at Stock</span></div>
      <div class="cl-item"><span class="pink"></span><span>Device Has Gone to Internal Manufacture</span></div>
     <div class="cl-item"><span class="yellow"></span><span>New Device Not Open Yet</span></div>
  </div>	
<article>
<div class="col-12"> 
  <!-- BEGIN BORDERED TABLE PORTLET-->  

    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Repair Device  </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>

              <th> Client Name </th>
              <th> ITGC Id </th>
			  <th> IMEI </th>
			  <th> SendToRepair </th>
              <th> Device Remove Remarks </th>
			  <th>ActualProblem </th>
			  <th> ManufactureRemark</th>
              <th> Remarks </th>
              <th> PendingDays</th>
              <th> DeviceModelName </th>
			
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
			 $device_status= $SelectRemovedRecdDevice[$x]['device_status']; 
				 if($device_status==109 )
				 {
					 $remark="Repair Device From Manufacture";
                $color="";
					$tool_tip="This case Repair Device From Manufacture";
                 }
				  if($device_status==86 )
				 {
					 $remark="This case Device Imei has been Changed Only Close Case";
                $color="#e9eae2";
					$tool_tip="Device Imei has been Changed Only Close Case";
                 }
				 if($device_status==79 )
				 {
					 $remark="This case has not open yet";
                   $color="#e0ff33";
					$tool_tip="This case has not open yet";
                 }
				 if($device_status==84 )
				 {
					 $remark="This case has gone to Manufacture";
					$color="#F4A460";
					$tool_tip="This case has gone to Manufacture";
                 }
				 if($device_status==85 )
				 {
					 $remark="This case has gone to Manufacture";
					$color="#F4A460";
					$tool_tip="This case has gone to Manufacture";
                 }
				 if($device_status==84 &&  $SelectRemovedRecdDevice[$x]['Interal_Manufacture']==1)
				 {
					$remark="This case has gone to Internal Manufacture";
					$color="#ff33ff";
					$tool_tip="This case has gone to Internal Manufacture";
                 }
				 if($device_status==85 &&  $SelectRemovedRecdDevice[$x]['Interal_Manufacture']==1)
				 {
					$remark="This case has gone to Internal Manufacture";
					$color="#ff33ff";
					$tool_tip="This case has gone to Internal Manufacture";
                 }
				  if($device_status==68 )
				 {
					 $remark="This case is already open";
					$color="#7CFC00";
					$tool_tip="This case is already open";
                 }
				 
               
             ?>
         
            <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
      
			  <td><?php echo $SelectRemovedRecdDevice[$x]['client_name']; ?></td>
			  <td><?php echo $SelectRemovedRecdDevice[$x]['itgc_id']; ?></td>
			 <td><?php echo $SelectRemovedRecdDevice[$x]['device_imei']; ?></td>
			
			<td>
						<?php 
						  $dt = date('d-m-Y H:i:s',strtotime($SelectRemovedRecdDevice[$x]['SendToRepairCenter']));

						  if($dt == '01-01-1970 05:30:00')
						  {
							$dt = '';
						  } 
						  else {
							echo $dt;
						  }						
						?>
                    </td>
			<td><?php echo $SelectRemovedRecdDevice[$x]['device_removed_problem']; ?></td>
			<td><?php echo $SelectRemovedRecdDevice[$x]['problem']; ?></td>
			<td><?php echo $SelectRemovedRecdDevice[$x]['RecdManufactureRemarkToRepair']; ?></td>
			 <td><?php echo $remark; ?></td>
			  <td><?php echo $SelectRemovedRecdDevice[$x]['PendingDays']; ?></td>
			  <td><?php echo $SelectRemovedRecdDevice[$x]['item_name']; ?></td>
			
			 
			  
              
            </tr>
            <?php } ?>
          
          </tbody> 
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
</body>
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
                    'number','string','number','number','number','string','string','string','string','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</html>