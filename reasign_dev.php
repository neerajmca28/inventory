<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
if($_POST)
{
	$reasign_from_id=$_POST['reasign_from']; 
	$SelectInstallerDevices=select_Procedure("CALL SelectInstallerDevices('".$reasign_from_id."')");
	$SelectInstallerDevices=$SelectInstallerDevices[0];
	/* echo "<pre>";
	print_r($SelectInstallerDevices); 
	"</pre>";die;    */
	 $rowcount=count($SelectInstallerDevices); 
	if($rowcount>0)
	{
		?>
		 <table class="table table-bordered table-hover" id="filtertable">
			 
			  <thead>
				<tr>
				<th>ReAssign</th>
				 <!-- <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>-->
				  <th>Serial No.</th>
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
				  <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]"  value="<?php echo $SelectInstallerDevices[$x]['device_id'];?>##<?php echo $SelectInstallerDevices[$x]['itgc_id'];?>##<?php echo $SelectInstallerDevices[$x]['device_imei']; ?>##<?php echo $SelectInstallerDevices[$x]['AssignedAntennaCount']; ?>##<?php echo $SelectInstallerDevices[$x]['AssignedImmobilizerType'];?>##<?php echo $SelectInstallerDevices[$x]['AssignedImmobilizerCount']; ?>##<?php echo $SelectInstallerDevices[$x]['AssignedConnectorCount']; ?>##<?php echo $SelectInstallerDevices[$x]['device_type']; ?>" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
				 <td><?php echo $y; ?></td>
				 <input type="hidden" name="row_count" id="row_count" value="<?php echo $rowcount; ?>">
					  
				  <td><?php echo $SelectInstallerDevices[$x]['itgc_id']; ?></td>
				  <td><?php echo $SelectInstallerDevices[$x]['device_imei']; ?></td>
				  <td><?php echo $SelectInstallerDevices[$x]['device_type']; ?></td>
				  <td><?php echo $SelectInstallerDevices[$x]['device_installer_remarks']; ?></td>
				  <?php $dt=date('d-m-Y',strtotime($SelectInstallerDevices[$x]['assign_installer_date'])); 
				      if($dt=='01-01-1970' )
				      {
				       $dt='';
				      }
				     else
				      {
				        $dt=date('d-m-Y H:i:s',strtotime($SelectInstallerDevices[$x]['assign_installer_date']));
				     }
				      ?>
				     <td><?php echo $dt ?></td>
				   <td>
					<textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled ></textarea> 
				  </td>
				  
				  
				  <td><?php echo $SelectInstallerDevices[$x]['AssignedAntennaCount'];?></td>
				  <td><?php echo $SelectInstallerDevices[$x]['AssignedImmobilizerType'];?></td>
				   <td> <?php echo $SelectInstallerDevices[$x]['AssignedImmobilizerCount'];?></td>
				   <td><?php echo $SelectInstallerDevices[$x]['AssignedConnectorCount'];?></td>
				</tr>
				<?php } ?>
			  <tr>

				   <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="ReAssign"></td>
				</tr>
				</tbody>
			</table>
		
		
		<?php
		
	}
	else
	{
			echo '<span style="color:#FF0000;text-align:center;">There is no Record.';
	}
	
}
	?>
	<script type="text/javascript">
  function checkAllId(){
    var i;
    var row = document.getElementById("checkAll")
    for(i=1;i<=<?php echo $rowcount; ?>;i++){
      if(row.checked){
        document.getElementById("remark"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
	//alert("check"+rowId);
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;

    }else{
      document.getElementById("remark"+rowId).disabled = true;
    }
  }
</script>
		
