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
$installerList=db__select_staging("select * from installer where branch_id='".$_SESSION['branch_id']."' and is_delete=1");
$branchId=$_SESSION['branch_id'];
$login_name= $_SESSION['user_name_inv'];	
if($branchId==1)
{
	$branch_name='Delhi';
}
if (isset($_POST['submit']))
{
	if((!isset($_POST['installer_list_from'])) || (empty($_POST['installer_list_from'])) || (($_POST['installer_list_from']==0)))
	{
			 $errorInstallerFrom="Please Select ReAssign Installer From";
			// echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}
	elseif((!isset($_POST['installer_list_to'])) || (empty($_POST['installer_list_to'])) || (($_POST['installer_list_to']==0)))
	{
			 $errorInstallerTo= "Please Select ReAssign Installer To";
			// echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}
	//if($errorMsg=='')
	else
	{				
		if($_POST['installer_list_to']==-1)
		{
			 $status=$OutOfStock;
		}
		else
		{
			 $status=$AssignToInstaller;
		}
		$installer_list_from=$_POST['installer_list_from'];
		$installer_list_to=$_POST['installer_list_to'];
		$selectInstallerFrom=$masterObj->selectInstallerName($installer_list_from);
		$installer_from=$selectInstallerFrom[0]['inst_name']; 
		$selectInstallerTo=$masterObj->selectInstallerName($installer_list_to);
		$Installer_name_to=$selectInstallerTo[0]['inst_name'];
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
				if(count($strSqlQuery)>0)
				{
					$strResult=$strSqlQuery[0]['Id']+1;
				}
				$strChallanNo=$strCH.$strResult; 
		if($_POST['installer_list_to']==-1)
		{
			$arrDeviceId=array();
			for($i=0;$i<count($_POST['rowVal']);$i++)
			{
				if(isset($_POST['rowVal'][$i]))
				{
					$data=explode('##',$_POST['rowVal'][$i]);
					$deviceId=$data[0];
					$arrDeviceId[$i]=$deviceId;
					$itgc_id=$data[1];
					$device_imei=$data[2];
					$AssignedAntennaCount=$data[3];
					$AssignedImmobilizerType=$data[4];
					$AssignedImmobilizerCount=$data[5];
					$AssignedConnectorCount=$data[6];
					$Insaller_AssignDate=date('Y-m-d H:i:s');
					$remarks=$_POST['remark'][$i]; 
					$ReAssignedDevicesToInstaller=select_Procedure("CALL ReAssignedDevicesToInstaller('".$deviceId."','".$status."','".$remarks."','".$installer_from."','".$branchId."')");
					$updateChallanDetails=$masterObj->updateChallanDetails($deviceId); 
					$insertChallanDetails=$masterObj->insertChallanDetails($strChallanNo,$deviceId,$AssignedAntennaCount,$AssignedImmobilizerType,$AssignedImmobilizerCount,$AssignedConnectorCount,$branchId,$Insaller_AssignDate); 
				}
			}
				$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  for($i=0;$i<count($arrDeviceId);$i++)
				{
					$devId.= $arrDeviceId[$i].',';
				}
				 $arrDeviceIdStr=substr($devId,0,strlen($devId)-1);

					//$playerurl1="challan_reassign.php";
					//header("location:".$playerurl1."?challanNo=".$strChallanNo."&from_installer=".$installer_from);	
					echo "<script type='text/javascript'>   
   					    window.open('challan_reassign.php?challanNo=$strChallanNo&from_installer=$installer_from&deviceIDList=$arrDeviceIdStr');
      					</script>";	
      					 ?><script><?php echo("location.href = '".__SITE_URL."/reassigndevice.php';");?></script><?php		
		}
		else
		{
			$arrDeviceId=array();
			for($i=0;$i<count($_POST['rowVal']);$i++)
			{
				if(isset($_POST['rowVal'][$i]))
				{
					$data=explode('##',$_POST['rowVal'][$i]);
					$deviceId=$data[0];
						$arrDeviceId[$i]=$deviceId;
					$itgc_id=$data[1];
					$device_imei=$data[2];
					$AssignedAntennaCount=$data[3];
					$AssignedImmobilizerType=$data[4];
					$AssignedImmobilizerCount=$data[5];
					$AssignedConnectorCount=$data[6];
					$Insaller_AssignDate=date('Y-m-d H:i:s');
					$remarks=$_POST['remark'][$i]; 
					$ReAssignedDevicesToInstaller=select_Procedure("CALL ReAssignedDevicesToInstaller('".$deviceId."','".$status."','".$remarks."','".$installer_from."','".$branchId."')");
					$selectInstallerName=$masterObj->selectInstallerName($installer_list_to);
						$Installer_name=$selectInstallerName[0]['inst_name'];
						$selectChallanDetails=$masterObj->selectChallanDetails($strChallanNo);
						if(count($selectChallanDetails)<1)
						{
							$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$deviceId,$AssignedAntennaCount,$AssignedImmobilizerType,$AssignedImmobilizerCount,$AssignedConnectorCount,$installer_list_to,$branchId,$Insaller_AssignDate);
						}
						else
						{
							if(count($selectChallanDetails)>0)
							{
								if($selectChallanDetails[0]["ChallanNo"] != "")
								{
									$updateChallanDetails=$masterObj->updateChallanDetails($deviceId); 
									$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$deviceId,$AssignedAntennaCount,$AssignedImmobilizerType,$AssignedImmobilizerCount,$AssignedConnectorCount,$installer_list_to,$branchId,$Insaller_AssignDate);
								}
								else
								{
									$updateChallanDetailsNotChallanNoExist=$masterObj->updateChallanDetailsNotChallanNoExist($strChallanNo,$AssignedAntennaCount,$AssignedImmobilizerType,$AssignedImmobilizerCount,$AssignedConnectorCount,$installer_list_to,$deviceId); 
								}
								if($installer_list_to == -1)
								{
									$updateNewDeviceRequest=$masterObj->updateNewDeviceRequest($deviceId,$selectChallanDetails[0]["BranchID"]);	
								}
							}
									
						 }
				}
					 
			}
			$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult); 
						//$playerurl="challan_reassign_installer.php";
						//header("location:".$playerurl."?challanNo=".$strChallanNo."&to_installer=".$Installer_name."&from_installer=".$installer_from);
			for($i=0;$i<count($arrDeviceId);$i++)
				{
					$devId.= $arrDeviceId[$i].',';
				}
				 $arrDeviceIdStr=substr($devId,0,strlen($devId)-1);
		
						echo "<script type='text/javascript'>   
   					    window.open( 'challan_reassign_installer.php?challanNo=$strChallanNo&to_installer=$Installer_name&from_installer=$installer_from&deviceIDList=$arrDeviceIdStr');
      					</script>";	
      					 ?><script><?php echo("location.href = '".__SITE_URL."/reassigndevice.php';");?></script><?php		
		}		
		
	}		
}

?>
<head>

</head>
 <form name="reassign_device1" id="reassign_device1" method="post" action="" onsubmit="return reassignDevice();" >
<body>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>ReAssign To Installer </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> 
		  Reassign From
		  </div>
		  
		  <div class="right-item"> <select class="form-control" name="installer_list_from" id="installer_list_from" onChange="reasign_device(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		   <div class="right-left">Reassign To</div>
		   <div class="right-item"> <select class="form-control" name="installer_list_to" id="installer_list_to" onChange="">
		   <option value="0">Select</option>
         <option value="-1">Stock</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div><span class="error">* <?php echo $errorInstallerTo;?></span>
          </div>
		  
       
    </div>
	<div class="portlet-body fix-table" id="tt"  style="display:none">
       
      </div>
	    
          </div>
         
      </div>
    <!-- END BORDERED TABLE PORTLET--> 
  
</article>
</body>
</form>
<script type="text/javascript">
var $reassign_device = jQuery.noConflict();
function reasign_device(val)
{
    $reassign_device.ajax({
				type:"POST",
				url:"reasign_dev.php",
				 dataType: "html",
				data:'reasign_from='+ val,
				success:function(msg)
				{
					//jQuery(this).html(msg);
					//alert(msg);
					  $reassign_device("#tt").html(msg);
					 document.getElementById('tt').style.display = "block";
					 //document.getElementById("tt").innerHTML = msg; 
				},
				error:function(msg){
            
				}
		}); 	
}
</script>
<script>
function reassignDevice() 
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
		document.reassign_device1.installer_list_to.focus();
		return false;
	} 
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

</html>