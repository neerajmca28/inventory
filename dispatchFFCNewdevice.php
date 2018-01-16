<?php
include("device_status.php");
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branch_id=$_SESSION['branch_id'];
$login_name=$_SESSION['user_name_inv'];
$masterObj = new master();
$deviceData=select_Procedure("CALL dispatchFFCNewdevice()");
$deviceData=$deviceData[0];
//echo '<pre>';print_r($deviceData); echo '</pre>'; die;
$rowcount=count($deviceData);
/* $dispatchFFCNewdevice=select_Procedure("CALL dispatchFFCNewdevice()");
$dispatchFFCNewdevice=$dispatchFFCNewdevice[0]; */
$dispatchReplaceFFCdevice=select_Procedure("CALL dispatchReplaceFFCdevice()");
$dispatchReplaceFFCdevice=$dispatchReplaceFFCdevice[0];

$branchList=select_Procedure("CALL GetBranch()");
//print_r($brandList); die;
$branchList=$branchList[0];
//$errorMsg=array();
$a=array();

if(isset($_POST['submit']))
{
	if((!isset($_POST['ddlBranchName'])) || (empty($_POST['ddlBranchName'])) || (($_POST['ddlBranchName']==0)))
	{
			//$errorMsg="Please Select Branch";
			$BranchMsg="Please Select Branch";
	}
	if((!isset($_POST['ddlMedium'])) || (empty($_POST['ddlMedium'])) || (($_POST['ddlMedium']==0)))
	{
			//$errorMsg= "Please Select Dispatch Medium";
			$MediumMsg= "Please Select Dispatch Medium";
	}
	if($BranchMsg=='' && $MediumMsg=='')
	{
		if($_POST['ddlBranchName']==1)
		{
		
			//echo $rowcount; die;
			for($i=0;$i<count($_POST['rowVal']);$i++)
			{
				//echo count($_POST['rowVal']); die;
				if(isset($_POST['rowVal'][$i]))
				{
					//echo '<pre>';print_r($_POST); echo '</pre>'; die;
					$ChallanMode=$Dispatch;
					if ($ChallanMode == 1)
					{
						$strChallanMode = "DispatchChallanNo";
					}
					else if ($ChallanMode == 3)
					{
						$strChallanMode = "SimDispatchChallanNo";
					}
					else
					{
						$strChallanMode = "InstallerChallanNo";
					}
					//echo $strChallanMode;
					$strCH = "CHNO";
					$strSqlQuery =$masterObj->selectChallanNo($strChallanMode);
					//	echo '<pre>';print_r($strSqlQuery); '</pre>';
					//echo count($strSqlQuery);
					if (count($strSqlQuery)> 0)
					{
						 $strResult = ($strSqlQuery[0]['Id'] + 1);
					}
					//echo $strResult; die;
					 $strChallanNo=$strCH.$strResult; 
					 $strArrAntenna=$_POST['antenna'][$i];
					 $immob_tp=$_POST['immob_type'][$i];
					 if($immob_tp==1)
					{
						$strArrImmobilerType="24VT";
					}
					if($immob_tp==2)
					{
						$strArrImmobilerType="12VT";
					}
					 $strArrImmobilzerCount=$_POST['immob'][$i];
					 $strArrConnectorCount=$_POST['connectors'][$i];
					 $dispatch_medium_id=$_POST['ddlMedium'];
					 if($dispatch_medium_id==1)
					 {
						 $dispatch_medium="Courier";
					 }
					 if($dispatch_medium_id==2)
					 {
						 $dispatch_medium="Person";
					 }
					 //$branch_id=$_POST['ddlBranchName'];
					 $send_branch=$_POST['ddlBranchName'];
					 $dispatch_medium_remarks=$_POST['txtDispactchRemarks'];
					 $remark=$_POST['remark'][$i];
					 $data=explode('##',$_POST['rowVal'][$i]);
					 $DeviceId=$data[0];
					 $itgc_id=$data[1];
					 $device_imei=$data[2];
					 $intRepaired=$data[3];
					 $intCracked=$data[4];
					 $intFFC=$data[5];
					 $dispatch_date=date('Y-m-d H:i:s');
					 $status=$OutOfStock;
					if($intRepaired==1)
					{
						$device_condition=$Repaired;
						if($intCracked==1)
						{
							 $device_condition=$Cracked;
						}
						if($intFFC==1)
						{
							 $device_condition=$FFC;
						}
						else
						{
							 $device_condition=$New;
						}
					}
					else
					{
						if($intCracked==1)
						{
							 $device_condition=$Cracked;
						}
						if($intFFC==1)
						{
							echo $device_condition=$FFC;
						}
						else
						{
							 $device_condition=$New;
						}
					}
					$SetDispatchDate1=select_Procedure("CALL SetDispatchDate1('".$DeviceId."','".$status."','".$dispatch_medium."','".$dispatch_medium_remarks."','".$remark."','".$branch_id."','".$device_condition."','".$send_branch."','".$dispatch_date."')");
					$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
					$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$strArrAntenna,$strArrImmobilerType,	$strArrImmobilzerCount,$strArrConnectorCount,$send_branch,$dispatch_date); 
					$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);

					
				}	
			}
						?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?php
		}
		else
		{
				//echo $rowcount; die;
			for($i=0;$i<count($_POST['rowVal']);$i++)
			{
					//echo count($_POST['rowVal']); die;
				if(isset($_POST['rowVal'][$i]))
				{
					//echo '<pre>';print_r($_POST); echo '</pre>'; die;
					$ChallanMode=$Dispatch;
					if ($ChallanMode == 1)
					{
						$strChallanMode = "DispatchChallanNo";
					}
					else if ($ChallanMode == 3)
					{
						$strChallanMode = "SimDispatchChallanNo";
					}
					else
					{
						$strChallanMode = "InstallerChallanNo";
					}
						//echo $strChallanMode;
					 $strCH = "CHNO";
					$strSqlQuery =$masterObj->selectChallanNo($strChallanMode);
					//	echo '<pre>';print_r($strSqlQuery); '</pre>';
					//echo count($strSqlQuery);
					if (count($strSqlQuery)> 0)
					{
						 $strResult = ($strSqlQuery[0]['Id'] + 1);
					}
						//echo $strResult; die;
					$strChallanNo=$strCH.$strResult; 
					$antena=$_POST['antenna'][$i];
					$immob_tp=$_POST['immob_type'][$i];
					if($immob_tp==1)
					{
						$immob_type="24VT";
					}
					if($immob_tp==2)
					{
						$immob_type="12VT";
					}
					$immob_count=$_POST['immob'][$i];
					$connectors=$_POST['connectors'][$i];
					$dispatch_medium=$_POST['ddlMedium'];
					$send_branch=$_POST['ddlBranchName'];
					$selectDispatchBranch =$masterObj->selectDispatchBranch($send_branch);
					$dispatch_send=$selectDispatchBranch[0]['branch_name'];

						$dispatch_medium_remarks=$_POST['txtDispactchRemarks'];
						 $remark=$_POST['remark'][$i];
						 $data=explode('##',$_POST['rowVal'][$i]);
						 $DeviceId=$data[0];
						 $itgc_id=$data[1];
						 $device_imei=$data[2];
						 $intRepaired=$data[3];
						 $intCracked=$data[4];
						 $intFFC=$data[5];
						 $dispatch_date=date('Y-m-d H:i:s');
						 $status=$OutOfStock;
						if($intRepaired==1)
						{
							 $device_condition=$Repaired;
							if($intCracked==1)
							{
								 $device_condition=$Cracked;
							}
							if($intFFC==1)
							{
								 $device_condition=$FFC;
							}
							else
							{
								 $device_condition=$New;
							}
						}
						else
						{
						
							if($intCracked==1)
							{
								 $device_condition=$Cracked;
							}
							if($intFFC==1)
							{
								echo $device_condition=$FFC;
							}
							else
							{
								 $device_condition=$New;
							}
						}
							$SetDispatchDate1=select_Procedure("CALL SetDispatchDate1('".$DeviceId."','".$status."','".$dispatch_medium."','".$dispatch_medium_remarks."','".$remark."','".$branch_id."','".$device_condition."','".$send_branch."','".$dispatch_date."')");
							$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId);  
							$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$send_branch,$dispatch_date);
							//echo  $strChallanNo; die;
							$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
							//header( "Location:challan_dispatch.php?challanNo=".$strChallanNo ); 
					}	
			}
			echo "<script type='text/javascript'>   
			window.open('challan_dispatch.php?challanNo=$strChallanNo');
			</script>";
			?><script><?php echo("location.href = '".__SITE_URL."/dispatchFFCNewdevice.php';");?></script><?	
			
			}
		}
		/* else
		{
				//	print_r($errorMsg);
				echo "<script type='text/javascript'>alert('$errorMsg');</script>";		
		} */
}
?>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
 <form name="dispatch_FFCNewdevice" id="dispatch_FFCNewdevice" method="post" action="" onsubmit="return dispatchFFCNewdeviceDevice();">
 
<article> 
 <div class="col-12">
     <div class="portlet box yellow">
				<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Dispatch FFC as New Device</div>
				</div>
					<div class="portlet-body control-box">
					<div class="content-box">
					<div class="left-item"> <span> Branch Name:</span> </div><div class="right-item"><select class="form-control" name="ddlBranchName" id="ddlBranchName" onchange="ddlBranchName_SelectedIndexChanged(this.value);">
					<option value="0">Select</option>
					<?php for($i=0;$i<count($branchList);$i++)
					{?>
						<option value="<?php echo $branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?></option>
					<?php } ?>
					</select></div> <span class="error">* <?php echo $BranchMsg;?></span></div>

					<div class="content-box">
					<div class="left-item"><span>Dispatch Medium:</span> </div>
					<div class="right-item"><select class="form-control" name="ddlMedium" id="ddlMedium" onchange="ddlMedium_SelectedIndexChanged(this.value);">
					<option value="0">Please Select</option>
					<option value="1">Courier</option>
					<option value="2">Person</option>
					</select>  </div>	<span class="error">* <?php echo $MediumMsg;?></span>
					</div>
					
					<div class="content-box">
					<div class="left-item"><span>Dispatch Medium Remarks:</span> </div>
					<div class="right-item"><input type="text" class="form-control" name="txtDispactchRemarks" id="txtDispactchRemarks" onchange="txtDispactchRemarks_TextChanged(this.value);"></div>
					</div>
					<div class="content-box">
					<div class="count-text"><a href="dispatchFFCNewdevice.php"> COUNT:<?php echo count($dispatchFFCNewdevice);?></a></div><div class="count-text"><a href="dispatchReplaceFFCdevice.php">Pending Replace FFC COUNT :<?php echo count($dispatchReplaceFFCdevice); ?></a></div> <div class="count-text"><a href="dispatchFFCNewdevice.php">Pending New FFC:</a>  </div>
					</div>
				</div>
			</div>
		</div>
		
</article>


 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
     <div class="col-12">
<div class="portlet box yellow">
				<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Dispatch Device </div>
				</div>
					<div class="portlet-body fix-table">
      <div class="portlet-body">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> No. </th>
              <th> ITGC ID </th>
              <th> Device IMEI </th>
              <th> Remarks </th>
			  <th> Antenna </th>
			  <th> Immobilizer </th>
              <th> Connectors </th>
              <th> Client Name </th>
			  <th> Veh No.</th>
              <th> Device Remd Remarks </th>
              <th> IsCracked</th>
              <th> Send Branch Name </th>
			  <th> Repair Close Date </th>
			  <th> ISFFCPermanent </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				/*  $repaired=$deviceData[$x]['is_repaired'];
				 $is_ffc=$deviceData[$x]['is_ffc'];
				 $is_permanent_ffc=$deviceData[$x]['is_permanent'];
				// $new_device=$deviceData[$x]['is_cracked'];
				 if($is_permanent_ffc==1 && $is_ffc==0 )
				 {
                   $color="#FF0000";
					$tool_tip="Permanent FFC";
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
				 } */
               
             
            ?>
            <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
			
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $deviceData[$x]['device_id'];?>##<?php echo $deviceData[$x]['itgc_id'];?>##<?php echo $deviceData[$x]['device_imei'];?>##<?php echo $deviceData[$x]['is_repaired'];?>##<?php echo $deviceData[$x]['is_cracked'];?>##<?php echo $deviceData[$x]['is_ffc'];?>" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $y;?></td>
			  <td><?php echo $deviceData[$x]['itgc_id']; ?></td>
			  <!--<input type="hidden" name="itgc_id[]" id="itgc_id" value="<?php echo $deviceData[$x]['itgc_id']; ?>">
			   <input type="hidden" name="is_repaired[]" id="is_repaired" value="<?php echo $deviceData[$x]['is_repaired']; ?>">
			   <input type="hidden" name="is_cracked[]" id="is_cracked" value="<?php echo $deviceData[$x]['is_cracked']; ?>">
			   <input type="hidden" name="is_ffc[]" id="is_ffc" value="<?php echo $deviceData[$x]['is_ffc']; ?>">
			   <input type="hidden" name="is_permanent_ffc[]" id="is_permanent_ffc" value="<?php echo $deviceData[$x]['is_permanent_ffc']; ?>">-->
			  <td><?php echo $deviceData[$x]['device_imei']; ?></td>
			  <!--<input type="hidden" name="device_imei[]" id="device_imei" value="<?php echo $deviceData[$x]['device_imei']; ?>">-->
              <!--<input type="hidden" name="device_id1[]" id="device_id1" value="<?php echo $deviceData[$x]['device_id']; ?>">-->
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea> 
              </td>
              <td>
                <select id="antenna<?php echo $y;?>" name="antenna[]" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($i=1;$i<=10;$i++){ ?>
                  <option role="presentation" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php } ?>
                </select>  
              </td>
              <td>
			  <select id="immob_type<?php echo $y;?>" name="immob_type[]" disabled />
                  <option role="presentation" value="0">Select</option>
				  <option role="presentation" value="1">24VT</option>
				  <option role="presentation" value="2">12VT</option>
			  </select>  
				
                <select id="immob<?php echo $y;?>" name="immob[]" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($j=1;$j<=10;$j++){ ?>
                  <option role="presentation" value="<?php echo $j; ?>"><?php echo $j; ?></option>
                  <?php } ?>
                </select>  
              </td>
			  
			     <td>
                <select id="connectors<?php echo $y;?>" name="connectors[]" disabled />
                  <option role="presentation" value="0">Select</option>
                  <?php for($j=1;$j<=10;$j++){ ?>
                  <option role="presentation" value="<?php echo $j; ?>"><?php echo $j; ?></option>
                  <?php } ?>
                </select>  
              </td>
			  <td><?php echo $deviceData[$x]['client_name']; ?></td>
			  <!--<input type="hidden" name="client_name[]" id="client_name" value="<?php echo $deviceData[$x]['client_name']; ?>">-->
			  <td><?php echo $deviceData[$x]['veh_no']; ?></td>
			   <?php if($deviceData[$x]['device_removed_remarks']=="NULL" || $deviceData[$x]['device_removed_remarks']=="")
			  {
				    $dev_rem_remark="";
			  }
			  else
			  {
				$dev_rem_remark= $deviceData[$x]['device_removed_remarks'];
			  }
			  ?>
			  <td><?php echo $dev_rem_remark; ?></td>
			  <?php if($deviceData[$x]['is_cracked']==1)
			  {
				 $is_cracked='True';
			  }
			 else
			 {
				 $is_cracked='False';
			 }?>
			  <td><?php echo $is_cracked; ?></td>
			  
			<?php $receive_from=$deviceData[$x]['Branch_Send'];
			  
			  if($receive_from==0)
			  {
				  $receive_from='';
			  }
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
			  
			  
			  
			  <td><?php echo date('d-m-Y H:i:s',strtotime($deviceData[$x]['closecase_date'])); ?></td>
			 <?php if($deviceData[$x]['is_permanent']==1){
				 $is_permanent='True';
			 }
			 else{
				 $is_permanent='False';
			 }?>
			  <td><?php echo $is_permanent; ?></td>
			  <!--<input type="hidden" name="is_permanent[]" id="is_permanent" value="<?php echo $deviceData[$x]['is_permanent']; ?>">-->
			  
              
            </tr>
            <?php } ?>
            
          </tbody>
         
        </table>
		<input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Dispatch">
		
      </div>
    </div>
	</div>
    <!-- END BORDERED TABLE PORTLET--> 
</form>
</body>
<script>
function dispatchFFCNewdeviceDevice() 
{
	var e = document.getElementById("ddlBranchName");
	var branch_name= e.options[e.selectedIndex].value;
	var m = document.getElementById("ddlMedium");
	var medium= m.options[m.selectedIndex].value;
	//var e = document.getElementById("installer_list_to");
	//var inst_name_to= e.options[e.selectedIndex].value;
	//var strUser1 = e.options[e.selectedIndex].text;
	//alert(inst_name_to);
	if(branch_name==0)
	{
		alert("Please Select Branch Name");
		document.dispatch_FFCNewdevice.ddlBranchName.focus();
		return false;
	} 
	if(medium==0 )
	{
		alert("Please Select Dispatch Medium");
		document.dispatch_FFCNewdevice.ddlMedium.focus();
		return false;
	} 
}
</script>
<script>
 var $dispatch = jQuery.noConflict()
/*   $dispatch('.checkbox1').on('change', function() {
    var bool = $dispatch('.checkbox1:checked').length === $dispatch('.checkbox1').length;
    $dispatch('#checkAll').prop('checked', bool);
  });
 */
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
		document.getElementById("immob_type"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
        document.getElementById("antenna"+i).disabled = true;
        document.getElementById("immob"+i).disabled = true;
		document.getElementById("immob_type"+i).disabled = true;
		document.getElementById("connectors"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId);
	//alert(row);
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("immob_type"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("immob_type"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
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
                    'number', 'number','number','number','number', 'string','number','number','number',
                    'string','number', 'string','number','string','string','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
   

</html>