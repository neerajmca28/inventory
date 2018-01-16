<?php
include("config.php");
include("device_status.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
if($branchId==1)
{
	$branch_name='Delhi';
}
$branchId=$_SESSION['branch_id'];
$login_name= $_SESSION['user_name_inv'];
$installerList=db__select_staging("select * from installer where branch_id='".$_SESSION['branch_id']."' and is_delete=1");
$SelectDeadDevices=select_Procedure("CALL SelectDeadDevices('".$branchId."')");
$SelectDeadDevices=$SelectDeadDevices[0];
if (isset($_POST['submit']))
{
	if((!isset($_POST['installer_list_from'])) || (empty($_POST['installer_list_from'])) || (($_POST['installer_list_from']==0)))
	{
			 $errorReassignFrom="Please Select ReAssign Installer From";
			// echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}
	elseif((!isset($_POST['installer_list_to'])) || (empty($_POST['installer_list_to'])) || (($_POST['installer_list_to']==0)))
	{
			 $errorReassignTo= "Please Select ReAssign Installer To";
			//echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}
	//if($errorMsg=='')
	else
	{
	
		if($_POST['installer_list_to']==-1)
		{
			$status=$DeadDevice;
		}
		else
		{
			$status=$ReAssignDeadDevice;
		}
		for($i=0;$i<count($_POST['row_count']);$i++)
		{
			if(isset($_POST['rowVal'][$i]))
			{
				$installer_list_from=$_POST['installer_list_from'];
				$installer_list_to=$_POST['installer_list_to'];
				$selectInstallerName_from=$masterObj->selectInstallerName($installer_list_from);
				$installer_from=$selectInstallerName_from[0]['inst_name'];
		
					$data=explode('##',$_POST['rowVal'][$i]);
							$deviceId=$data[0]; 
							$itgc_id=$data[1];
							 $device_imei=$data[2];
							$antena=$data[3];
							$immob_type=$data[4];
							$immob_count=$data[5];
							$connectors=$data[6];
							 $remarks=$_POST['remark'][$i]; 
							//$remarks="";
							$challan_mode=$Installer;
							if ($challan_mode == 1)
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
							//echo "<pre>";print_r($strSqlQuery); die;
						   if(count($strSqlQuery)>0)
						   {
							   $strResult=$strSqlQuery[0]['Id']+1;
						   }
						    $strChallanNo=$strCH.$strResult; 
							$ReAssignedDevicesToInstaller=select_Procedure("CALL ReAssignedDevicesToInstaller('".$deviceId."','".$status."','".$remarks."','".$installer_from."','".$branchId."')");
							
						if($_POST['installer_list_to']==-1)
						{
						   $updateChallanDetails=$masterObj->updateChallanDetails($deviceId); 
						   $insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$deviceId,$antena,$immob_type,$immob_count,$connectors,$branchId); 
						   $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
						  // header("location:challan_reassign_dead.php?challanNo=strChallanNo&from_installer=installer_from");
						    //$playerurl="challan_reassign_dead.php?";
						    //header("location:".$playerurl."?challanNo=".$strChallanNo."&from_installer=".$installer_from);
						    echo "<script type='text/javascript'>   
      						 window.open( 'challan_reassign_dead.php?challanNo=$strChallanNo&from_installer=$installer_from');
      						 </script>";
							   
						}
						else
						{
							$selectInstallerName=$masterObj->selectInstallerName($installer_list_to);
							$installer_name_to=$selectInstallerName[0]['inst_name'];
							$selectChallanDetails=$masterObj->selectChallanDetails($strChallanNo);
							//echo '<pre>';print_r($selectChallanDetails);die;
							//echo count($selectChallanDetails);die;
							if(count($selectChallanDetails)<1)
							{
								$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$deviceId,$antena,$immob_type,$immob_count,$connectors,$installer_list_to,$branchId,$Insaller_AssignDate);
							}
							else
							{
								if(count($selectChallanDetails)>0)
								{
									if($selectChallanDetails[0]["ChallanNo"] != "")
									{
										 $updateChallanDetails=$masterObj->updateChallanDetails($deviceId); 
										 $insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$deviceId,$antena,$immob_type,$immob_count,$connectors,$installer_list_to,$branchId,$Insaller_AssignDate);
									
									}
									else
									{
										$updateChallanDetailsNotChallanNoExist=$masterObj->updateChallanDetailsNotChallanNoExist($strChallanNo,$antena,$immob_type,$immob_count,$connectors,$installer_list_to,$deviceId); 
									}
									if($installer_id == -1)
									{
										$updateNewDeviceRequest=$masterObj->updateNewDeviceRequest($deviceId,$selectChallanDetails[0]["BranchID"]); 
									}
								}
								
							}
						
							 $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
					
							//$playerurl="challan_reassign_installer_dead.php";
						    //header("location:".$playerurl."?challanNo=".$strChallanNo."&from_installer=".$installer_from."&to_installer=".$installer_name_to);							 
							echo "<script type='text/javascript'>   
      						 window.open( 'challan_reassign_installer_dead.php?challanNo=$strChallanNo&from_installer=$installer_from&to_installer=$installer_name_to');
      						 </script>";
      						  ?><script><?php echo("location.href = '".__SITE_URL."/reassigndeaddevice.php';");?></script><?php
						}			
			}
			
		}
	}
	/* else
	{
		
		//echo "<script type='text/javascript'>alert('$errorMsg');</script>";
	} */
}

?>
<head>

</head>
 <form name="reassigndead_device1" id="reassigndead_device1" method="post" action=""  onsubmit="return reassignDeadDevice();" >
<body>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>ReAssign Dead Devices To Installer </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> 
		  
		  </div>
		  <div>Reassign From</div>
		  <div class="right-item"> <select class="form-control" name="installer_list_from" id="installer_list_from" onchange="reasign_dead_device(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		   <div>Reassign To</div>
		   <div class="right-item"> <select class="form-control" name="installer_list_to" id="installer_list_to" onchange="">
		   <option value="0">Select</option>
         <option value="-1">Stock</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div><span class="error">* <?php echo $errorReassignTo;?></span>
          </div>
		  
       
    </div>
	<div class="portlet-body" id="tt"  style="display:none">
       
      </div>
          </div>
         
      </div>

    <!-- END BORDERED TABLE PORTLET--> 
  
</article>

</form>
</body>
<script>
function reassignDeadDevice() 
{
	var e = document.getElementById("installer_list_to");
	var inst_name_to= e.options[e.selectedIndex].value;
	//var e = document.getElementById("installer_list_to");
	//var inst_name_to= e.options[e.selectedIndex].value;
	//var strUser1 = e.options[e.selectedIndex].text;
	//alert(inst_name_to);
	if(inst_name_to==0 )
	{
		alert("Please Select ReAssign To");
		document.reassigndead_device1.installer_list_to.focus();
		return false;
	}  
}
</script>
<script type="text/javascript">
var $reassigndead_device = jQuery.noConflict();
function reasign_dead_device(val)
{
    $reassigndead_device.ajax({
				type:"POST",
				url:"reasign_dead_dev.php",
				dataType: "html",
				data:'reasign_from='+ val,
				success:function(msg)
				{
					 //alert(msg);
					
					  $reassigndead_device("#tt").html(msg);
					   document.getElementById('tt').style.display = "block";
				},
				error:function(msg){
            
				}
		}); 	
}
</script>
<script data-config>
$reassigndead_device(document).ready(function () {
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
                    'number', 'number','number','string','number','number', 'string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
});

</script>		

</html>