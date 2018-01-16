<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
 $device_type=$_POST['device_type'];
if(isset($_POST['branch_id']))
{
	$branch_id=$_POST['branch_id'];
}
else
{
	$branch_id=0;
}
$deviceDetails=select_Procedure("CALL GetRequestedDevices('".$branch_id."','".$device_type."')");
$deviceDetail=$deviceDetails[0];
//print_R($deviceDetail); die;
?>
    <!-- BEGIN BORDERED TABLE PORTLET-->
      
<div>
        <table class="table table-bordered table-hover" id="filteration">
         
          <thead>
            <tr>
              <th>Branch Name </th>
              <th> Device Type </th>
              <th> Device Model </th>
              <th> Total Requested Devices </th>
              <th> Pending Device </th>
			  <th> LastRequestedUnits </th>
			  <th> LastRequestedDate </th>
              <th> New/FFC/Cracked </th>
              <th> Remarks </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($deviceDetail);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
			  <td><?php echo $deviceDetail[$x]['branch_name']; ?></td>
			  <td><?php echo $deviceDetail[$x]['DeviceType']; ?></td>
              <td><?php echo $c=$deviceDetail[$x]['DeviceModel'];?></td>
			  <td><?php echo $deviceDetail[$x]['total_requested_device']; ?></td>
			  <td><?php echo $deviceDetail[$x]['pending_devices']; ?></td>
			  <td><?php echo $deviceDetail[$x]['last_requested_units']; ?></td>
			  <td><?php echo $deviceDetail[$x]['last_requested_date']; ?></td>
			  <td><?php echo $deviceDetail[$x]['device_condition']; ?></td>
			  <td><?php echo $deviceDetail[$x]['remark']; ?></td> 
            </tr>
            <?php } ?>
          </tbody>
          </form> 
        </table>
 
    <!-- END BORDERED TABLE PORTLET--> 
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
                    'string', 'string','string','number','number', 'number','number','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filteration', filtersConfig);
    tf.init();

</script>
  