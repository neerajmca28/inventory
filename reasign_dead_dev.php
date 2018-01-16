<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
  $reasign_from_id=$_POST['reasign_from'];
$SelectDeadDevices=select_Procedure("CALL SelectReassignInstallerDeadDevices('".$reasign_from_id."')");
$SelectDeadDevices=$SelectDeadDevices[0];
/* 	 echo "<pre>";
print_r($SelectDeadDevices); 
"</pre>";die;   */
$rowcount=count($SelectDeadDevices);
if($rowcount>0)
{
	?>
	
	 <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
			  <th>ITGC ID</th>
			  <th>IMEI </th>
			  <th>Device Type</th>
              <th>Installer Remarks</th>
              <th>Installer Assign Date </th>
			  <th>Remarks </th>
			  <th>Anteena </th>
			  <th>Immobilizer Type </th>
			  <th>Immobilizer Count</th>
			  <th>Connector Count </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectDeadDevices[$x]['DeviceID'];?>##<?php echo $SelectDeadDevices[$x]['itgc_id'];?>##<?php echo $SelectDeadDevices[$x]['device_imei']; ?>##<?php echo $SelectDeadDevices[$x]['DispatchAntennaCount']; ?>##<?php echo $SelectDeadDevices[$x]['DispatchImmobilizerType'];?>##<?php echo $SelectDeadDevices[$x]['DispatchImmobilizerCount']; ?>##<?php echo $SelectDeadDevices[$x]['DispatchConnectorCount']; ?>" onclick="setRow('<?php echo $y;?>');" class="checkbox1"></td>
			  <input type="hidden" name="row_count" id="row_count" value="<?php echo $rowcount; ?>">
			  <td><?php echo $SelectDeadDevices[$x]['itgc_id']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['device_imei']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['device_type']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['device_installer_remarks']; ?></td>
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SelectDeadDevices[$x]['assign_installer_date']));?></td>
			   <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea> 
              </td>
			  <td><?php echo $SelectDeadDevices[$x]['DispatchAntennaCount'];?></td>
				<td><?php echo $SelectDeadDevices[$x]['DispatchImmobilizerType'];?></td>
			   <td> <?php echo $SelectDeadDevices[$x]['DispatchImmobilizerCount'];?></td>
			   <td><?php echo $SelectDeadDevices[$x]['DispatchConnectorCount'];?></td>
            </tr>
            <?php } ?>
            
          </tbody>
  
        </table>
		<input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="ReAssign">
	
	
<?php	
}
else
{
			echo '<span style="color:#FF0000;text-align:center;">There is no Record.';
}
?>

	
	

		

  