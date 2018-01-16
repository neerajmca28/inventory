<?php
include("config.php");
include("device_status.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branch_id=$_SESSION['branch_id'];
$masterObj = new master();
$dispatchReplaceFFCdevice=select_Procedure("CALL dispatchReplaceFFCdevice()");
$dispatchReplaceFFCdevice=$dispatchReplaceFFCdevice[0];
$rowcount=count($dispatchReplaceFFCdevice);
//echo '<pre>';print_r($dispatchReplaceFFCdevice); echo '</pre>'; die;
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0];
$errorMsg="";
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
	if($BranchMsg=='' && $MediumMsg=='' )
	{
		if($_POST['ddlBranchName']==1)
		{
			for($i=0;$i<count($_POST['rowVal']);$i++)
			{
				if(isset($_POST['rowVal'][$i]))
				{
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
					 $strResult = "CHNO";
					$strSqlQuery =$masterObj->selectChallanNo($strChallanMode);
					if (count($strSqlQuery)> 0)
					{
						 $strResult += ($strSqlQuery[0]['Id'] + 1);
					}
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
					 $send_branch=$_POST['ddlBranchName'];
					 $dispatch_medium_remarks=$_POST['txtDispactchRemarks'];
					 $remark=$_POST['remark'][$i];
					 $dispatch_date=date('Y-m-d H:i:s');
					 $status=$OutOfStock;
					 $data=explode('##',$_POST['rowVal'][$i]);
					 $DeviceId=$data[0];
					 $itgc_id=$data[1];
					 $device_imei=$data[2];
					 $intRepaired=$data[3];
					 $intCracked=$data[4];
					 $intFFC=$data[5];
					if($intRepaired==1)
					{
						$device_condition=$Repaired;
						if($intCracked==1)
						{
							 $device_condition=$Cracked;
						}
						else if($intFFC==1)
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
						else if($intFFC==1)
						{
							echo $device_condition=$FFC;
						}
						else
						{
							 $device_condition=$New;
						}
					}
				
					$SetDispatchDate1=select_Procedure("CALL SetDispatchDateffc('".$DeviceId."','".$status."','".$dispatch_medium."','".$dispatch_medium_remarks."','".$remark."','".$branch_id."','".$device_condition."','".$send_branch."','".$dispatch_date."')");
					$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
					$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$strArrAntenna,$strArrImmobilerType,	$strArrImmobilzerCount,$strArrConnectorCount,$send_branch,$dispatch_date); 
					$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);

				}	
		}
			?><script><?php echo("location.href = '".__SITE_URL."/assigndevicesinstaller.php';");?></script><?php

	}
	else
	{
		for($i=0;$i<count($_POST['rowVal']);$i++)
		{
				if(isset($_POST['rowVal'][$i]))
				{
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
					 $strCH = "CHNO";
					$strSqlQuery =$masterObj->selectChallanNo($strChallanMode);
					if (count($strSqlQuery)> 0)
					{
						 $strResult = ($strSqlQuery[0]['Id'] + 1);
					}
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
						
							$SetDispatchDate1=select_Procedure("CALL SetDispatchDateffc('".$DeviceId."','".$status."','".$dispatch_medium."','".$dispatch_medium_remarks."','".$remark."','".$branch_id."','".$device_condition."','".$send_branch."','".$dispatch_date."')");
							$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId);  
							$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$send_branch,$dispatch_date);
							$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
							header( "Location:challan_dispatch.php?challanNo=".$strChallanNo ); 
					}	
			}
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
 <form name="dispatch_FFCReplacedeviceDevice" id="dispatch_FFCReplacedeviceDevice" method="post" action="" onsubmit="return dispatchFFCReplacedeviceDevice();" >
 
<article> 
 <div class="col-12">

     <div class="portlet box yellow">
				<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Dispatch FFC Replace Device </div>
				</div>
					<div class="portlet-body control-box">
					<div class="content-box">
					<div class="left-item"> <span> Branch Name:</span> </div><div class="right-item"><select class="form-control" name="ddlBranchName" id="ddlBranchName" onchange="ddlBranchName_SelectedIndexChanged(this.value);">
					<option value="0">Select</option>
					<?php for($i=0;$i<count($branchList);$i++)
					{?>
						<option value="<?php echo $branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?></option>
					<?php } ?>
					</select></div><span class="error">* <?php echo $BranchMsg;?></span>
					</div>
					<div class="content-box">
					<div class="left-item"><span>Dispatch Medium:</span> </div>
					<div class="right-item"><select class="form-control" name="ddlMedium" id="ddlMedium" onchange="ddlMedium_SelectedIndexChanged(this.value);">
					<option value="0">Please Select</option>
					<option value="1">Courier</option>
					<option value="2">Person</option>
					</select>  </div><span class="error">* <?php echo $MediumMsg;?></span>
					</div>
					
					<div class="content-box">
					<div class="left-item"><span>Dispatch Medium Remarks:</span> </div>
					<div class="right-item"><input type="text" class="form-control" name="txtDispactchRemarks" id="txtDispactchRemarks" onchange="txtDispactchRemarks_TextChanged(this.value);"></div>
					</div>
					<div class="content-box">
					<div class="count-text"><a href="dispatchReplaceFFCdevice.php">Pending Replace FFC COUNT :<?php echo count($dispatchReplaceFFCdevice); ?></a></div> 
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
              <th> New Client Name </th>
			  <th> New Veh No.</th>
              <th> Replace Device Imei </th>
              <th> Replaced Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $dispatchReplaceFFCdevice[$x]['new_device_id'];?>##<?php echo $dispatchReplaceFFCdevice[$x]['imei_no']?>##<?php echo $dispatchReplaceFFCdevice[$x]['is_repaired'];?>##<?php echo $dispatchReplaceFFCdevice[$x]['is_cracked'];?>##<?php echo $dispatchReplaceFFCdevice[$x]['is_ffc'];?>"  onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $y;?></td>
			  <td><?php echo $dispatchReplaceFFCdevice[$x]['imei_no']; ?></td>
			  <td><?php echo $dispatchReplaceFFCdevice[$x]['ffc_date']; ?></td>
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
			  <td><?php echo $dispatchReplaceFFCdevice[$x]['new_client_name']; ?></td>
			  <td><?php echo $dispatchReplaceFFCdevice[$x]['new_veh_no']; ?></td>
			  <td><?php echo $dispatchReplaceFFCdevice[$x]['replace_device_imei']; ?></td>
			  <td><?php echo $dispatchReplaceFFCdevice[$x]['replaced_date']; ?></td>    
            </tr>
            <?php } ?>
         
          </tbody>
        
        </table>
		<input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Dispatch">
      </div>
    </div>
	</div>
	
	  </form>

</body>	  
    <!-- END BORDERED TABLE PORTLET--> 
<script>
function dispatchFFCReplacedeviceDevice() 
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
		document.dispatch_FFCReplacedeviceDevice.ddlBranchName.focus();
		return false;
	} 
	if(medium==0 )
	{
		alert("Please Select Dispatch Medium");
		document.dispatch_FFCReplacedeviceDevice.ddlMedium.focus();
		return false;
	}  
}
</script>
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
    var row = document.getElementById("check"+rowId)
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
</script><script data-config>
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
                    'number', 'number','number','string','number','number','number',
                    'string','number', 'number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>

</html>