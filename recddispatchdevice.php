<?php 
include("config.php");
include("include/header.php");
include("device_status.php");
include(__DOCUMENT_ROOT.'/fpdf/fpdf.php');
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
} 
$branch_id=$_SESSION['branch_id'];
$SelectDispatchedDevice1=select_Procedure("CALL SelectDispatchedDevice1('".$branch_id."')");
$SelectDispatchedDevice1=$SelectDispatchedDevice1[0];
$rowcount=count($SelectDispatchedDevice1);
//echo '<pre>';print_r($SelectDispatchedDevice1); echo '</pre>'; die;
$errorMsg="";
$data=array();
if (isset($_POST['submit']))
{
	//echo 'tt'; die;
	//print_r($_POST); die;
		for($i=0;$i<count($_POST['rowVal']);$i++)
		{
			if(isset($_POST['rowVal'][$i]))
			{
				 $Remarks=$_POST['remark'][$i];
				 $DispatchDate=date('Y-m-d H:i:s');
				 $dispatchBranch=$branch_id;
				 //$devicestatus=$BranchRecd; 
				 $data=explode('##',$_POST['rowVal'][$i]);
			     $DeviceId=$data[0];
			     $imei=$data[2];
				 $st1=$data[4];
				 $temp_ffc=$data[5];
				 $perm_ffc=$data[6];
				  $dispatch_branch=$data[7]; 
				if($dispatch_branch==1)
				 {
				 if($temp_ffc==1 && $perm_ffc==1)
					{	
					 	$dev_rep=mysql_query("select imei_no as count from inventory.device_replace_ffc where imei_no='".$imei."' and Status=99 order by id desc;"); 			
							$row=mysql_num_rows($dev_rep); 		
							if($row>0)				
							{			
								$devicestatus=$FFC_AS_New; 							
							}						
							else
							{						
								$devicestatus=$BranchRecd; 				
							}
					}
					else		
					{				
							$devicestatus=$BranchRecd; 	
					}
				}
				else
				{
					$devicestatus=$BranchRecd;
				}
				 
				 $UpdateDispathRecdDevice_new=select_Procedure("CALL UpdateDispathRecdDevice_new('".$DeviceId."','".$Remarks."','".$DispatchDate."','".$devicestatus."','".$dispatchBranch."')");
				//print_r($SimDispatched);
			}		
		}
	?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?php
}
?>
<head>
</head>
<body>
 <form name="recd_dispatchdevice" id="recd_dispatchdevice" method="post" action="" >
	<div class="color-sign" style="margin: 15px 0 2px 0;">
      <div class="cl-item"><span class="lightblue"></span><span>Light Blue :</span><span>Repaired Device</span></div>
      <div class="cl-item"><span class="white"></span><span>White  :</span><span>New Device</span></div>
	     <div class="cl-item"><span class="lightgreen"></span><span>Light Green </span><span> FFC Device</span></div>
      <div class="cl-item"><span class="aqua"></span><span>Aqua :</span><span>Recevied from Branch</span></div>
   
  </div>	
<article>

  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Recieved Dispatch Device</div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> ITGC ID</th>
			  <th> IMEI </th>
              <th> Dispatched Date</th>
              <th> Dispatched Remarks </th>
              <th> Remarks </th>
			  <th> Send Branch Name </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				$repaired=$SelectDispatchedDevice1[$x]['is_repaired'];
				 $is_ffc=$SelectDispatchedDevice1[$x]['is_ffc'];
				 $branch_send=$SelectDispatchedDevice1[$x]['Branch_Send'];
				 $dispatch_branch=$SelectDispatchedDevice1[$x]['dispatch_branch'];
				// $new_device=$SelectDispatchedDevice1[$x]['is_cracked'];
				 if($is_ffc==1)
				 {
                   $color="LightGreen";
					$tool_tip="FFC device";
                 }
				 else if($repaired==1)
				 {
					$color="#7acde9";
					$tool_tip="repaired";
					
                 }
				 else
				 {
					$color="#FFFFFF";
					$tool_tip="new device";
				 }
				 
				 if($branch_send>=1 && $dispatch_branch>=1)
				 {
					 
					$ff=$SelectDispatchedDevice1[$x]['Is_Branch_Recevied'];
					if($ff==1)
					{
						$color="#97FFFF";
						$branch_name='Delhi';
						$tool_tip = "Device Received From Delhi";
					}
					if($ff==2)
					{
						$color="#97FFFF";
						$branch_name='Mumbai';
						$tool_tip = "Device Received From Mumbai";
					}
					if($ff==3)
					{
						$color="#97FFFF";
						$branch_name='Jaipur';
						$tool_tip = "Device Received From Jaipur";
					}
					if($ff==4)
					{
						$color="#97FFFF";
						$branch_name='Sonepat';
						$tool_tip = "Device Received From Sonepat";
					}
					if($ff==5)
					{
						$color="#97FFFF";
						$branch_name='Kanpur';
						$tool_tip = "Device Received From Kanpur";
					}
					if($ff==6)
					{
						$color="#97FFFF";
					    $branch_name='Ahmedabad';
						$tool_tip = "Device Received From Ahmedabad";
					}
					if($ff==7)
					{
						$color="#97FFFF";
						$branch_name='Kolkata';
						$tool_tip = "Device Received From Kolkata";
					}
					 
				 }
				
				
            ?>
            <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectDispatchedDevice1[$x]['device_id'];?>##<?php echo $SelectDispatchedDevice1[$x]['itgc_id'];?>##<?php echo $SelectDispatchedDevice1[$x]['device_imei'];?>##<?php echo $SelectDispatchedDevice1[$x]['dispatch_branch'];?>##<?php echo $SelectDispatchedDevice1[$x]['device_status'];?>##<?php echo $SelectDispatchedDevice1[$x]['is_ffc'];?>##<?php echo $SelectDispatchedDevice1[$x]['is_permanent'];?>##<?php echo $SelectDispatchedDevice1[$x]['dispatch_branch'];?>" onclick="setRow('<?php echo $y; ?>');" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $SelectDispatchedDevice1[$x]['itgc_id']; ?></td>
			  <input type="hidden" name="itgc_id[]" id="itgc_id" value="">
			  <td><?php echo $SelectDispatchedDevice1[$x]['device_imei']; ?></td>
			  <input type="hidden" name="device_imei[]" id="device_imei" value="">
			  
			  	  <?php $dt=date('d-m-Y',strtotime($SelectDispatchedDevice1[$x]['dispatch_date'])); 
			   if($dt=='01-01-1970' )
				  {
					  $dt='';
				  }
			  else
				  {
					   $dt=date('d-m-Y H:i:s',strtotime($SelectDispatchedDevice1[$x]['dispatch_date']));
					}
				  ?>
			  <td><?php echo $dt ?></td>
			    <td><?php echo $SelectDispatchedDevice1[$x]['dispatch_remarks'];?></td>
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea> 
              </td>
			
			   <td><?php echo $branch_name; ?></td>
		
             
            </tr>
            <?php } ?>
            
          </tbody>
          </form> 
        </table>
        <tr>
              <td colspan="11"><input type="submit" onClick="bulk()" class="btn btn-default table-btn-submit" name="submit" id="submit" value="Recevied"></td>
            </tr>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
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
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;

    }else{
      document.getElementById("remark"+rowId).disabled = true;
    }
  }
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
                    'number','number','number','number','string','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>