<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
//echo $reasign_from_id=$_POST['reasign_from']; die;
$SelectInstallerSim=select_Procedure("CALL SelectInstallerSim('".$reasign_from_id."')");
$SelectInstallerSim=$SelectInstallerSim[0];
/* echo "<pre>";
print_r($SelectInstallerSim); 
"</pre>";die;    */   
$rowcount=count($SelectInstallerSim);
  if($rowcount>0)
  {
    ?>
   <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
      <th>ReAssign</th>
             <!-- <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>-->
        <th>SIM ID</th>
        <th>Sim NO</th>
        <th>Phone No </th>
        <th>Assign Date</th>
              <th>Operator</th>
              <th>Assign Remarks </th>
        <th>Re-Assign Remarks </th>
            </tr>
          </thead>
          <tbody>
            <?php 

      for($x=0;$x<$rowcount;$x++)
      {
        $y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]"  value="<?php echo $SelectInstallerSim[$x]['sim_id'];?>##<?php echo $SelectInstallerSim[$x]['sim_no'];?>##<?php echo $SelectInstallerSim[$x]['phone_no']; ?>##<?php echo $SelectInstallerSim[$x]['operator']; ?>##<?php echo $SelectInstallerSim[$x]['sim_status']; ?>" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
       
       <input type="hidden" name="row_count" id="row_count" value="<?php echo $rowcount; ?>">
          
        <td><?php echo $SelectInstallerSim[$x]['sim_id']; ?></td>
        <td><?php echo $SelectInstallerSim[$x]['sim_no']; ?></td>
        <td><?php echo $SelectInstallerSim[$x]['phone_no']; ?></td>
        
        <td><?php echo date('d-m-Y H:i:s',strtotime($SelectInstallerSim[$x]['AssignDate']));?></td>
        <td><?php echo $SelectInstallerSim[$x]['operator'];?></td>
        <td><?php echo $SelectInstallerSim[$x]['AssignRemarks'];?></td>
         <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]"  ></textarea> 
              </td>
        
        
            </tr>
            <?php } ?>
    
        </table>
    <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="ReAssign"></td>
  
    <?php
    
  }
  else
  {
      echo '<span style="color:#FF0000;text-align:center;">There is no Record.';
  }
  

  ?>

  