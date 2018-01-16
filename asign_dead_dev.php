<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
$branchId=$_SESSION['branch_id'];
$GetDeadDeviceForAssigning=select_Procedure("CALL GetDeadDeviceForAssigning('".$branchId."')");
$GetDeadDeviceForAssigning=$GetDeadDeviceForAssigning[0];
/*  echo "<pre>";
print_r($SelectDeadDevices); 
"</pre>";die;  */
$rowcount=count($GetDeadDeviceForAssigning);

?>
	 <table class="table table-bordered table-hover">
         
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
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <input type="hidden" name="device_id[]" id="device_id" value="<?php echo $GetDeadDeviceForAssigning[$x]['DeviceID']; ?>">
			  <td><?php echo $GetDeadDeviceForAssigning[$x]['itgc_id']; ?></td>
			  <input type="hidden" name="itgc_id[]" id="itgc_id" value="<?php echo $GetDeadDeviceForAssigning[$x]['itgc_id']; ?>">
			  <td><?php echo $GetDeadDeviceForAssigning[$x]['device_imei']; ?></td>
			  <input type="hidden" name="device_imei[]" id="device_imei" value="<?php echo $GetDeadDeviceForAssigning[$x]['device_imei']; ?>">
			  <td><?php echo $GetDeadDeviceForAssigning[$x]['device_type']; ?></td>
			  <td><?php echo $GetDeadDeviceForAssigning[$x]['device_installer_remarks']; ?></td>
			  <td><?php echo date('d-m-Y H:i:s',strtotime($GetDeadDeviceForAssigning[$x]['assign_installer_date']));?></td>
			   <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" ></textarea> 
              </td>
			  <td><?php echo $GetDeadDeviceForAssigning[$x]['DispatchAntennaCount'];?></td>
			    <input type="hidden" name="DispatchAntennaCount[]" id="DispatchAntennaCount" value="<?php echo $GetDeadDeviceForAssigning[$x]['DispatchAntennaCount']; ?>">
				<td><?php echo $GetDeadDeviceForAssigning[$x]['DispatchImmobilizerType'];?></td>
				  <input type="hidden" name="DispatchImmobilizerType[]" id="DispatchImmobilizerType" value="<?php echo $GetDeadDeviceForAssigning[$x]['DispatchImmobilizerType']; ?>">
			   <td> <?php echo $GetDeadDeviceForAssigning[$x]['DispatchImmobilizerCount'];?></td>
			     <input type="hidden" name="DispatchImmobilizerCount[]" id="DispatchImmobilizerCount" value="<?php echo $GetDeadDeviceForAssigning[$x]['DispatchImmobilizerCount']; ?>">
			   <td><?php echo $GetDeadDeviceForAssigning[$x]['DispatchConnectorCount'];?></td>
			     <input type="hidden" name="DispatchConnectorCount[]" id="DispatchConnectorCount" value="<?php echo $GetDeadDeviceForAssigning[$x]['DispatchConnectorCount']; ?>">

            </tr>
            <?php } ?>
            <tr>
              <td colspan="11"><input type="submit" onclick="bulk()" name="submit" id="submit" value="ReAssign"></td>
            </tr>
          </tbody>
  
        </table>	 
		
        </form> 
  