<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php"); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$branch_id=$_SESSION['branch_id'];
$installerList=db__select_staging("SELECT * FROM internalsoftware.installer where branch_id='".$branch_id."' and is_delete=1");
$SelectBranchRepairDevice_ByBranch=select_Procedure("CALL SelectBranchRepairDevice_ByBranch('".$branch_id."')");
$SelectBranchRepairDevice_ByBranch=$SelectBranchRepairDevice_ByBranch[0];
$rowcount1=count($SelectBranchRepairDevice_ByBranch);
$select_newDevice_byBranch=select_Procedure("CALL select_newDevice_byBranch('".$branch_id."')");
$select_newDevice_byBranch=$select_newDevice_byBranch[0];
$rowcount2=count($SelectBranchRepairDevice_ByBranch);
//echo '<pre>';print_r($select_newDevice_byBranch);die;
$arr_merge=array_merge($SelectBranchRepairDevice_ByBranch,$select_newDevice_byBranch);
$rowcount=count($arr_merge);
//echo '<pre>'; print_r(array_merge($SelectBranchRepairDevice_ByBranch,$select_newDevice_byBranch)); '</pre>'; die;
$condition="";
if(isset($_POST['submit']))
{
	for($i=0;$i<$rowcount;$i++)
	{
			if(isset($_POST['rowVal'][$i]))
			{
				
					$device=$_POST['rowVal'][$i];
					$data=explode('##',$device);
					$deviceId=$data[0];
					$imei=$data[1];
					$itgc_id=$data[2];
					$st1=$data[3];
					$temp_ffc=$data[4];
                    			 $perm_ffc=$data[5];
					if($st1==83)
					{
						if ($_POST['receive_from_installer'][$i] == 0)
						{
							$errorMsg="Please Select Installer Name";
							echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
							?><script><?php echo("location.href = '".__SITE_URL."/recdremovedevice_bybranch.php';");?></script><?php
						}
						if($_POST['antenna'][$i]==1)
						{
							$antena=1;
						}
						if($_POST['antenna'][$i]==2)
						{
							$antena=0;
						}
			
			
						if($_POST['immob'][$i]==1)
						{
							$immobilzer=1;
						}
						if($_POST['immob'][$i]==2)
						{
							$immobilzer=0;
						}
						/* if($_POST['immob'][$i]=="" || $_POST['immob'][$i]==0)
						{
							$errorMsg="Please select Immbolizer";
							echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
							?><script><?php echo("location.href = '".__SITE_URL."/recdremovedevice.php';");?></script><?php	
						} */
						//$connector=$_POST[$i]['connectors'];
						if($_POST['connectors'][$i]==1)
						{
							$connector=1;
						}
						if($_POST['connectors'][$i]==2)
						{
							$connector=0;
						}
						if($errorMsg=="")
						{
						$remarks=$_POST['remark'][$i];
						$dispatchRecdDate=date('Y-m-d H:i:s');
						$deviceStatus=$RecdRemoveDevice;
						$installer_id=$_POST['receive_from_installer'][$i]; 
								
						
						$UpdateDispathRecdDevice_byBranch=select_Procedure("CALL UpdateDispathRecdDevice_byBranch('".$deviceId."','".$remarks."','".$dispatchRecdDate."','".$deviceStatus."','".$installer_id."','".$imei."','".$antena."','".$immobilzer."','".$connector."','".$branch_id."')");
						//print_r($UpdateDispathRecdDevice_byBranch[0]);
						
						}	
					}
			
				
					if($st1==195)
					{									
							if($temp_ffc==1 && $perm_ffc==1)
								{	
									$dev_rep=mysql_query("select imei_no as count from inventory.device_replace_ffc where imei_no='".$imei."' and Status=99 order by id desc;"); 			
									$row=mysql_num_rows($dev_rep); 		
									if($row>0)				
									{			
											$deviceStatus1=$FFC_AS_New; 							
									}						
									else
									{						
											$deviceStatus1=$FinalAttachSim; 				
									}
								}				
							else		
							{				
									$deviceStatus1=$FinalAttachSim; 	
							}
												
							$Update_New_DispathRecdDevice_byBranch=select_Procedure("CALL Update_New_DispathRecdDevice_byBranch('".$deviceId."','".$deviceStatus1."','".$imei."')");
					}
					
			}
	}
	?><script><?php echo("location.href = '".__SITE_URL."/recdremovedevice_bybranch.php';");?></script><?php
}
?>
<head>
</head>
<body>
<form name="recd_remove_device_byBranch" id="recd_remove_device_byBranch" method="post" action="" >	
<div class="color-sign" style="margin: 15px 0 2px 0;">
	 <div class="cl-item"><div class="cl-item"><span class="lightblue"></span><span>Repaired Device</span></div>
      <div class="cl-item"><span class="white"></span><span>New Device</span></div></div>
	   </div>	
						
<article>
<div class="col-12"> 				
<!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Recd Remove Device By Branch </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered" id="filtertable">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Serial No. </th>
              <th> ITGC ID </th>
              <th> IMEI </th>
              <th> Vehilce No </th>
              <th> Client Name </th>
			  <th> Device Removed Date </th>
			  <th> Received From </th>
              <th> 	Antenna </th>
              <th> Immobilizer</th>
			  <th> Connectors</th>
              <th> Remarks</th>
              <th> Status</th>
              <th>	Send Branch Name</th>
			  <th>	Device Removed Problem</th>
			  <th> PendingDays </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				/* $Branch_Recevied= $arr_merge[$x]['Is_Branch_Recevied'];
				if($Branch_Recevied>0)
				{
					 $is_branch_rec=1;
				}
				else
				{
					 $is_branch_rec=0;
				}
				if($is_branch_rec>0)
				{
					$color="#00FFFF";
					$tool_tip="Send By another Branch";
				} */
				if($arr_merge[$x]['device_status']==83)
				{
					$color="#7acde9";
					$tool_tip="repaired";
				}
				if($arr_merge[$x]['device_status']==195)
				{
					$color="#FFFFFF";
					$tool_tip="new device";
				}
            ?>
               <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $arr_merge[$x]['device_id'];?>##<?php echo $arr_merge[$x]['device_imei'];?>##<?php echo $arr_merge[$x]['itgc_id']; ?>##<?php echo $arr_merge[$x]['device_status']; ?>##<?php echo $arr_merge[$x]['is_ffc']; ?>##<?php echo $arr_merge[$x]['is_permanent']; ?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $y;?></td>
			 
			   <td><?php echo $arr_merge[$x]['itgc_id']; ?></td>
			   <td><?php echo $arr_merge[$x]['device_imei']; ?></td>
			   	<?php if($arr_merge[$x]['device_status']==83)
				{?>
				
			   <td><?php echo $arr_merge[$x]['veh_no']; ?></td>
			   <td><?php echo $arr_merge[$x]['client_name']; ?></td>
				<td><?php echo $arr_merge[$x]['device_removed_date']; ?></td>
				     <td>
                <select id="receive_from_installer<?php echo $y;?>" name="receive_from_installer[]"  disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($i=0;$i<COUNT($installerList);$i++){ ?>
                  <option role="presentation" value="<?php echo $installerList[$i]['inst_id']; ?>"><?php echo $installerList[$i]['inst_name'];?></option>
                  <?php } ?>
                </select>  
              </td>
					<td>
			  <select id="antenna<?php echo $y;?>" name="antenna[]" disabled />
                 <option role="presentation" value="2">No</option>
				  <option role="presentation" value="1">Yes</option>
			
			  </select></td>
			      <td>
			  <select id="immob<?php echo $y;?>" name="immob[]" disabled />
               <option role="presentation" value="2">No</option>
				  <option role="presentation" value="1">Yes</option>
				  
			  </select></td>
			   
			   <td>
			  <select id="connectors<?php echo $y;?>" name="connectors[]" disabled />
                <option role="presentation" value="2">No</option>
				  <option role="presentation" value="1">Yes</option>
				 
			  </select></td>
				<?php } else{ 
				?>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<?php }?>
			   <td>
               <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea> 
               </td>
			<?php if($arr_merge[$x]['device_status']==83)
			  {
				$statu="Repair Device";
			  }
			  else
			  {
				  $statu="New Device";
			  }
			  ?>
			  <td><?php echo $statu;?></td>
			 
			  <?php $receive_from=$arr_merge[$x]['Is_Branch_Recevied'];
			  if($receive_from==1)
			  {
				  $receive_from='Delhi';
			  }
			   if($receive_from==2)
			  {
				  $receive_from='Mumbai';
			  }
			   if($receive_from==3)
			  {
				  $receive_from='Jaipur';
			  }
			   if($receive_from==4)
			  {
				  $receive_from='Sonepat';
			  }
			   if($receive_from==5)
			  {
				  $receive_from='Kanpur';
			  }
			    if($receive_from==6)
			  {
				  $receive_from='Ahmedabad';
			  }
			    if($receive_from==7)
			  {
				  $receive_from='kolkata';
			  }
			  ?>
			  <td><?php echo $receive_from;?></td>
			  <td><?php echo $arr_merge[$x]['device_removed_problem'];?></td>
			  <td><?php echo $arr_merge[$x]['PendingDays'];?></td>
            </tr>
            <?php } ?>
          </tbody>
       
        </table>
			<input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Received">
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
      </form>
</article>
<script>
 var $dispatch = jQuery.noConflict()
  $dispatch('.checkbox1').on('change', function() {
    var bool = $dispatch('.checkbox1:checked').length === $dispatch('.checkbox1').length;
    $dispatch('#checkAll').prop('checked', bool);
  });

  $dispatch('#checkAll').on('change', function() {
    $dispatch('.checkbox1').prop('checked', this.checked);
  });
</script>
<script type="text/javascript">
  function checkAllId(){
    var i;
    var row = document.getElementById("checkAll")
    for(i=1;i<=<?php echo $rowcount; ?>;i++){
      if(row.checked){
		// alert(<?php echo $rowcount; ?>);
		 // var tt=document.getElementById("remark"+i);
		    //alert('tt');
        document.getElementById("remark"+i).disabled = false;
        document.getElementById("antenna"+i).disabled = false;
        document.getElementById("immob"+i).disabled = false;
		document.getElementById("receive_from_installer"+i).disabled = false;
		document.getElementById("other_installer"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false;
		document.getElementById("receive_from"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
        document.getElementById("antenna"+i).disabled = true;
        document.getElementById("immob"+i).disabled = true;
		document.getElementById("receive_from_installer"+i).disabled = true;
		//document.getElementById("other_installer"+i).disabled = true;
		document.getElementById("connectors"+i).disabled = true;
		document.getElementById("receive_from"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("receive_from_installer"+rowId).disabled = false;
	  //document.getElementById("other_installer"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;
	  document.getElementById("receive_from"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("receive_from_installer"+rowId).disabled = true;
	  document.getElementById("other_installer"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
	  document.getElementById("receive_from"+rowId).disabled = true;
    }
  }
  function  rec_from_installer(value,rowId)
  {
	 // alert(value);
	 if(value==111)
	 {
		//alert(rowId);
	   document.getElementById("other_installer"+rowId).disabled = false;
	 }
	 else
	 {
		 document.getElementById("other_installer"+rowId).disabled = true;
	 }
  }
  
</script>
<script data-config>
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
                    'number','number','number','number','number','number', 'string','number', 'string','string','string','string','string','string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>
