<?php
include("device_status.php");
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$data=array();
$branch_id=$_SESSION['branch_id'];
$user_name=$_SESSION['user_name_inv']; 
$GetVendorName=select_Procedure("CALL GetVendorName('".$user_name."')");
 $vendor_id=$GetVendorName[0];
//echo '<pre>';print_r($vendor_id[0]['VendorId']); echo '</pre>'; die;
  
 //print_R($vendor_id);die;
 //echo "CALL SelectVendordetails('".$branch_id."','".$vendor_id[0]['VendorId']."')";die;
$SelectVendordetails=select_Procedure("CALL SelectVendordetails('".$branch_id."','".$vendor_id[0]['VendorId']."')");
$SelectVendordetails=$SelectVendordetails[0];
$rowcount=count($SelectVendordetails);
//echo '<pre>';print_r($SelectVendordetails); echo '</pre>'; die;
?>
<head>
</head>
<body>
  <div class="col-12"> 
 <form name="manufacture_device" id="manufacture_device" method="post" action="" >

<article>
			
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> View Device
		</div>
      </div>
      <div class="portlet-body fix-table ">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
			  <th> Serial No. </th>
              <th> Itgc Id </th>
              <th> Device Sno </th>
              <th> DeviceImei</th>
              <th> Sim No </th>
              <th> Phone No</th>

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
			  <td><?php echo $SelectVendordetails[$x]['itgc_id']; ?></td>
			  <td><?php echo $SelectVendordetails[$x]['device_sno']; ?></td>
              <td><?php echo $SelectVendordetails[$x]['device_imei'];?></td>
			  <td><?php echo $SelectVendordetails[$x]['phone_no']; ?></td>
			  <td><?php echo $SelectVendordetails[$x]['sim_no']; ?></td> 
            </tr>
            <?php } ?>
          </tbody>
        </table>
  
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 

</article>
      </form>
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
                    'number', 'number','number','number','number','string', 'number','string','string','string','string','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>

</html>