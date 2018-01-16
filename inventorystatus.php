<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
 $branchId=$_SESSION['branch_id']; 
$GetCounterNewDevice=select_Procedure("CALL GetCounterNewDevice('".$branchId."')");
$GetCounterNewDevice=$GetCounterNewDevice[0];
$count_new_device=count($GetCounterNewDevice);
$GetCounterRepairDevice=select_Procedure("CALL GetCounterRepairDevice('".$branchId."')");
$GetCounterRepairDevice=$GetCounterRepairDevice[0];
$count_rep_device=count($GetCounterRepairDevice);
/*   echo "<pre>";
print_r($GetCounterNewDevice); 
"</pre>";die;   */ 
$CounterNewDeviceAtReapir=select_Procedure("CALL CounterNewDeviceAtReapir('".$branchId."')");
$CounterNewDeviceAtReapir=$CounterNewDeviceAtReapir[0][0];
$CounterFFCDevice=select_Procedure("CALL CounterFFCDevice('".$branchId."')");
$CounterFFCDevice=$CounterFFCDevice[0][0];
$CounterCrackedDeviceAtRepair=select_Procedure("CALL CounterCrackedDeviceAtRepair('".$branchId."')");
$CounterCrackedDeviceAtRepair=$CounterCrackedDeviceAtRepair[0][0];
$CounterCrackedDevice=select_Procedure("CALL CounterCrackedDevice('".$branchId."')");
$CounterCrackedDevice=$CounterCrackedDevice[0][0];
$CounterRepairDeviceAtRepair=select_Procedure("CALL CounterRepairDeviceAtRepair('".$branchId."')");
$CounterRepairDeviceAtRepair=$CounterRepairDeviceAtRepair[0][0];
$CounteRemoveDevice=select_Procedure("CALL CounteRemoveDevice('".$branchId."')");
$CounteRemoveDevice=$CounteRemoveDevice[0][0];
$CounterRepairDevice=select_Procedure("CALL CounterRepairDevice('".$branchId."')");
$CounterRepairDevice=$CounterRepairDevice[0][0];
$CounterNewDevice=select_Procedure("CALL CounterNewDevice('".$branchId."')");
$CounterNewDevice=$CounterNewDevice[0][0];
$CounterNewDeviceAtRepair=select_Procedure("CALL CounterNewDeviceAtRepair('".$branchId."')");
$CounterNewDeviceAtRepair=$CounterNewDeviceAtRepair[0][0];
$CounterNewDeviceAtReapir=select_Procedure("CALL CounterNewDeviceAtReapir('".$branchId."')");
$CounterNewDeviceAtReapir=$CounterNewDeviceAtReapir[0][0];
$CounterSendtoRepairDelhi=select_Procedure("CALL CounterSendtoRepairDelhi('".$branchId."')");
$CounterSendtoRepairDelhi=$CounterSendtoRepairDelhi[0][0];	
?>
<head>
<script type="text/javascript">

</script>
</head>
<body>
<article>
  <div class="col-12">
    <form name="simfilter" method="post" action="">
      <!-- BEGIN BORDERED TABLE PORTLET-->
      <div class="portlet box yellow">
        <div class="portlet-title">
          <div class="caption"> <i class="fa fa"></i>Inventory Status </div>
        </div>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td><label>New Device(Configured-AtRepair)</label></td>
              <td><?php echo $CounterNewDeviceAtReapir[0]; ?></td>
              <td><label> Device Send to Delhi for Repair (In Stock)</label></td>
              <td><?php echo $CounterSendtoRepairDelhi[0]; ?></td>
            </tr>
            <tr>
              <td><label>New Device (At Stock)</label></td>
              <td><?php echo $CounterNewDevice[0]; ?></td>
              <td><label> FFC Device (In Stock)</label></td>
              <td><?php echo $CounterFFCDevice[0]; ?></td>
            </tr>
            <tr>
              <td><label>Repair Device (In Stock)</label></td>
              <td><?php echo $CounterRepairDevice[0]; ?></td>
              <td><label>Remove Device (In Stock)</label></td>
              <td><?php echo $CounteRemoveDevice[0]; ?></td>
            </tr>
            <tr>
              <td><label>Cracked Device(At Repair) </label></td>
              <td><?php echo $CounterCrackedDeviceAtRepair[0]; ?></td>
              <td><label> New Device(In Repair)</label></td>
              <td><?php echo $CounterNewDeviceAtRepair[0]; ?></td>
            </tr>
            <tr>
              <td><label>Repair Device(At Repair)</label></td>
              <td><?php echo $CounterRepairDeviceAtRepair[0]; ?></td>
              <td><label>Cracked Device (In Stock)</label></td>
              <td><?php echo $CounterCrackedDevice[0]; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <!--    <div class="portlet-body control-box">
     <table class="table table-bordered table-hover" id="filtertable">
         
           <thead>
            <tr>
              <th>Device Name  </th>
              <th>Raw Invtry </th>
              <th>In stock </th>
              <th>Internal Repair </th>
              <th> Assign To Installer</th>
			   <th>Repair At Delhi   </th>
              <th>Device Removed </th>
              <th>ReAssign To Installer </th>
              <th>Recd Dispatch Device  </th>
              <th>FFC As NEW At Stock </th>
			  <th> Replace FFC AtStock   </th>
              <th> Device Send For Repair ToDelhi  </th>
			  <th>Cracked Device At Stock  </th>
              <th>Cracked Device At Repair  </th>
			  <th>Total</th>
              <th>New Devices</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($crack_uncrack);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
			  <td><?php echo $crack_uncrack[$x]['itgc_id']; ?></td>
			  <td><?php echo $crack_uncrack[$x]['device_imei']; ?></td>
              <td><?php echo $crack_uncrack[$x]['client_name'];?></td>
			  <td><?php echo $crack_uncrack[$x]['veh_no']; ?></td>
			  <td><?php echo $crack_uncrack[$x]['uncracked_device_remarks']; ?></td>
			  
            </tr>
            <?php } ?>
          </tbody>
       
        </table>
		  
         
      </div>-->
      <div class="portlet box yellow">
        <div class="portlet-title">
          <div class="caption"> <i class="fa fa"></i>New Device Imei Details </div>
        </div>
        <div class="portlet-body control-box fix-table">
          <table class="table table-bordered table-hover" id="filtertable1">
            <thead>
              <tr>
                <th>itgc_id </th>
                <th>device_imei </th>
                <th>device_sno </th>
                <th>item_name </th>
                <th> status</th>
                <th>dispatch_date</th>
                <th>dispatch_recd_date</th>
              </tr>
            </thead>
            <tbody>
              <?php 

			for($x=0;$x<$count_new_device;$x++)
			{
				$y=$x+1;
            ?>
              <tr>
                <td><?php echo $GetCounterNewDevice[$x]['itgc_id']; ?></td>
                <td><?php echo $GetCounterNewDevice[$x]['device_imei']; ?></td>
                <td><?php echo $GetCounterNewDevice[$x]['device_sno'];?></td>
                <td><?php echo $GetCounterNewDevice[$x]['item_name']; ?></td>
                <td><?php echo $GetCounterNewDevice[$x]['status']; ?></td>
                <td><?php echo $GetCounterNewDevice[$x]['dispatch_date']; ?></td>
                <td><?php echo $GetCounterNewDevice[$x]['dispatch_recd_date']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="portlet box yellow">
        <div class="portlet-title">
          <div class="caption"> <i class="fa fa"></i>Repair Device Imei Details </div>
        </div>
        <div class="portlet-body control-box fix-table">
          <table class="table table-bordered table-hover" id="filtertable2">
            <thead>
              <tr>
                <th>itgc_id </th>
                <th>device_imei </th>
                <th>device_sno </th>
                <th>item_name </th>
                <th> status</th>
              </tr>
            </thead>
            <tbody>
              <?php 

			for($x=0;$x<$count_rep_device;$x++)
			{
				$y=$x+1;
            ?>
              <tr>
                <td><?php echo $GetCounterRepairDevice[$x]['itgc_id']; ?></td>
                <td><?php echo $GetCounterRepairDevice[$x]['device_imei']; ?></td>
                <td><?php echo $GetCounterRepairDevice[$x]['device_sno'];?></td>
                <td><?php echo $GetCounterRepairDevice[$x]['item_name']; ?></td>
                <td><?php echo $GetCounterRepairDevice[$x]['status']; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </form>
    
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
</body>
</html><script data-config>
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
                    'number', 'number','number','number','number', 'string','number','number','number',
                    'string','number', 'string','number','string','string','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

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
                    'number', 'number','number','number','string','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable1', filtersConfig);
    tf.init();

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
                    'number', 'number','number','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable2', filtersConfig);
    tf.init();

</script>