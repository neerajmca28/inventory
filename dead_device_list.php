<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
$start_date=date('Y:m:d',strtotime($_POST['start_date']));
$end_date=date('Y:m:d',strtotime($_POST['end_date']));
$SearchDeadDeviceDate=select_Procedure("CALL SearchDeadDeviceDate('".$start_date."','".$end_date."')");
$SearchDeadDeviceDate=$SearchDeadDeviceDate[0];
$rowcount=count($SearchDeadDeviceDate);
/* echo '<pre>';
print_r($SearchDeadDeviceDate);
echo '</pre>'; */
 
?>

        <table class="table table-bordered table-hover">
         
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
			  <input type="hidden" name="ManufactureDate[]" id="ManufactureDate" value="">
			  <td><?php echo $SearchDeadDeviceDate[$x]['ManufactureName']; ?></td>
			  <td><?php echo $SearchDeadDeviceDate[$x]['ManufactureRemarks']; ?></td>
			  <td><a href="<?php echo __SITE_URL;?>/deaddevice_report.php?task=dead_sent_client"><strong>Dead Device Send To Client</strong></a></td>
			  <td><a href="<?php echo __SITE_URL;?>/deaddevice_report.php?task=assign_installer"><strong>Device Assign To Installer</strong></a></td>
			  <td><a href="<?php echo __SITE_URL;?>/deaddevice_report.php?task=delhi_kept_delhi"><strong>Delhi Kept At Client</strong></a></td>

            </tr>
            <?php } ?>
     
          </tbody>
          </form> 
        </table>
	
 
    <!-- END BORDERED TABLE PORTLET--> 

  