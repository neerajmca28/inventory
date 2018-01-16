<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$masterObj = new master();
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$SearchDeadDeviceKeptAtDelhi=select_Procedure("CALL SearchDeadDeviceKeptAtDelhi()");
$SearchDeadDeviceKeptAtDelhi=$SearchDeadDeviceKeptAtDelhi[0];
//echo '<pre>';print_r($GetRequestedSim);'</pre>'; die; 
$rowcount=count($SearchDeadDeviceKeptAtDelhi);
?>

<head>

</head>
<body>
<article>
<div class="col-12"> 
<!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
		<div class="portlet-title">
			<div class="caption"> <i class="fa fa"></i>Dead Device Kept At Delhi </div>
		</div>
		<div>
		<div class="portlet-body fix-table" id="default">
	  
			<table class="table table-bordered table-hover" id="filtertable">
         
			  <thead>
				<tr>
				  <th>Device Sno.</th>
				  <th> 	Device IMEI</th>
				  <th> Device Id </th>
				  <th> Client Name </th>
				  <th>	Veh No </th>
				  <th> Opencase Date</th>
				  <th>	Manufacture Name</th>
				  <th> Manufacture Remarks</th>
				  <th>Dead Device Send Date</th>
				</tr>
			  </thead>
			  <tbody>
				<?php 

				for($x=0;$x<$rowcount;$x++)
				{
					$y=$x+1;
				?>
				<tr>
				    <td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['device_sno']; ?></td>
					<td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['device_imei']; ?></td>
					<td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['device_id']; ?></td>
					<td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['client_name']; ?></td>
					<td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['veh_no']; ?></td>
				
					<?php 
					$opencase_date=date('d-m-Y',strtotime($SearchDeadDeviceKeptAtDelhi[$x]['opencase_date']));
					if($opencase_date=='01-01-1970')
					{
						$opencase_date='';
					}
					else
					{
						$opencase_date=date('d-m-Y H:i:s',strtotime($SearchDeadDeviceKeptAtDelhi[$x]['opencase_date']));
					}
					?>
					<td><?php echo $opencase_date; ?></td>
			
				
					<td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['ManufactureName']; ?></td>
					<td><?php echo $SearchDeadDeviceKeptAtDelhi[$x]['ManufactureRemarks']; ?></td>
					<?php 
					$deadDeviceSendDate=date('d-m-Y',strtotime($SearchDeadDeviceKeptAtDelhi[$x]['deadDeviceSendDate']));
					if($deadDeviceSendDate=='01-01-1970')
					{
						$deadDeviceSendDate='';
					}
					else
					{
						$deadDeviceSendDate=date('d-m-Y H:i:s',strtotime($SearchDeadDeviceKeptAtDelhi[$x]['deadDeviceSendDate']));
					}
					?>
					<td><?php echo $deadDeviceSendDate; ?></td>
				</tr>
				<?php } ?>
			
			  </tbody> 
			</table>
		 </div>
		 </div>
		
  </div>
 </div>
				   	  
    <!-- END BORDERED TABLE PORTLET--> 

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
                    'number', 'number','number','string','number', 'number','string','string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</html>