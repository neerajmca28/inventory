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

if(isset($_GET['action']) && $_GET['action']=='dead_device_byDate')
{
	    $start_date1=date('Y-m-d',strtotime($_GET['start_date']));
	    $end_date1=date('Y-m-d',strtotime($_GET['end_date']));
		$SearchDeadDeviceDate=select_Procedure("CALL SearchDeadDeviceDate('".$start_date1."','".$end_date1."')");	
		$SearchDeadDeviceDate=$SearchDeadDeviceDate[0];
		$rowcount=count($SearchDeadDeviceDate);
		//echo '<pre>';print_r($SearchDeadDeviceDate); echo '</pre>'; die;
}?>
 <table class="table table-bordered table-hover" id="filteration" >
         
          <thead>
            <tr>
              <th> Device Sno. </th>
              <th> Device IMEI </th>
              <th> Device Id</th>
              <th> Client Name </th>
			  <th> Veh No </th>
			  <th> Opencase Date </th>
              <th> Manufacture Name </th>
              <th> Manufacture Remarks </th>
			  <th> Send To Client</th>
              <th> Assign To Installer</th>
              <th> Delhi Kept at Delhi</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
		
			  <td><?php echo $SearchDeadDeviceDate[$x]['device_sno']; ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['device_imei']; ?></td>
              <td><?php echo $SearchDeadDeviceDate[$x]['device_id'];?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['client_name']; ?></td>
			  <?php
				
			 
			  ?>
			  <td><?php echo $SearchDeadDeviceDate[$x]['veh_no'];?></td>
			  <?php $dt=date('d-m-Y',strtotime($SearchDeadDeviceDate[$x]['opencase_date'])); 
			   if($dt=='01-01-1970' )
				  {
					  $dt='';
				  }
			  else
				  {
					   $dt=date('d-m-Y H:i:s',strtotime($SearchDeadDeviceDate[$x]['opencase_date']));
					}
				  ?>
			  <td><?php echo $dt ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['ManufactureName']; ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['ManufactureRemarks']; ?></td>
			    <td><a href="#" onclick="return send_client(<?php echo $SearchDeadDeviceDate[$x]["device_id"];?>);"><strong>Device Assign To Installer</strong></a></td>
			  <td><a href="#" onclick="return assign_installer(<?php echo $SearchDeadDeviceDate[$x]["device_id"];?>);"><strong>Device Assign To Installer</strong></a></td>
			   <td><a href="#" onclick="return delhi_kept_delhi(<?php echo $SearchDeadDeviceDate[$x]["device_id"];?>);"><strong>Delhi Kept At Client</strong></a></td>
		
			   
            </tr>
            <?php } ?>
     
          </tbody>
       
        </table>
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
                    'number', 'number','number','string','number','number', 'string','string'
                ]
        }]
    };

    var tf = new TableFilter('filteration', filtersConfig);
    tf.init();

</script>





