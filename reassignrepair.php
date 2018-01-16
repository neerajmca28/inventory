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
//$installerList=db__select_staging("select * from installer where branch_id='".$_SESSION['branch_id']."' and is_delete=1");
$branchId=$_SESSION['branch_id'];
$login_name= $_SESSION['user_name_inv'];
$repairList=select_Procedure("CALL GetRepairUser()");
$repairList=$repairList[0];
//echo '<pre>';print_r($repairList);die;	
	
/* if($branchId==1)
{
	$branch_name='Delhi';
} */

if (isset($_POST['submit']))
{
		//echo count($_POST); die;
		//echo $_POST['row_count']; die;
		//echo '<pre>';print_r($_POST); echo '</pre>';die;
	if((!isset($_POST['installer_list_from'])) || (empty($_POST['installer_list_from'])) || (($_POST['installer_list_from']==0)))
	{
			 $errorMsg="Please Select Repair Name From";
			echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}
	elseif((!isset($_POST['installer_list_to'])) || (empty($_POST['installer_list_to'])) || (($_POST['installer_list_to']==0)))
	{
			 $errorMsg= "Please Select Repair Name To";
			echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}
	if($errorMsg=='')
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
				/* $selectInstallerFrom=$masterObj->selectInstallerName($installer_list_from);
				$installer_from=$selectInstallerFrom[0]['inst_name']; 
				$selectInstallerTo=$masterObj->selectInstallerName($installer_list_to);
				$Installer_name_to=$selectInstallerTo[0]['inst_name'];  */
				$installer_list_from=$masterObj->selectRepairName($installer_list_from);
				//echo '<pre>';print_r($installer_list_from); die;
				 $Installer_name_from=$installer_list_from[0]['name']; 
				$selectInstallerTo=$masterObj->selectRepairName($installer_list_to);
				 $Installer_name_to=$selectInstallerTo[0]['name']; 
				//die;
		if ($installer_list_to == -2)		// Dead//
        {
              // ddlReassignTo.SelectedValue = "-2";
               $status = $Sim_Deactivation;
                //Installer id -> -2 shows device is dead now
				$flag=1;
         }
        else if ($installer_list_to == -1)
        {
                $status = $Sim_Recd;
				$flag=2;
        }
        else
		{
			//$InstallerID = $installer_list_to;
             $status = $Sim_Servies;
        }
		$challan_mode=$Sim;
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
		for($i=0;$i<count($_POST['rowVal']);$i++)
		{
			//echo $_POST['row_count']; die;
			if(isset($_POST['rowVal'][$i]))
			{	
				$data=explode('##',$_POST['rowVal'][$i]);
				//$data=explode('##',$device);
				$sim_id=$data[0];
				$sim_no=$data[1];
				$phone_no=$data[2];
				$status1=$data[4];
				$Insaller_AssignDate=date('Y-m-d H:i:s');
				$remarks=$_POST['remark'][$i]; 
				 //$remarks="tt";
				
				
				//echo $strChallanNo; die;
				//$RepairName=$Installer_name_to;
				$RepairName=$installer_list_to;
				//echo "CALL ReAssignedSIM_branch('".$remarks."','".$branchId."','".$status."','".$sim_id."')"; die;
				$ReAssignedDevicesToInstaller=select_Procedure("CALL ReAssignedSIM_branch('".$remarks."','".$branchId."','".$status."','".$sim_id."')");
				if($flag==2)
				{
					$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
					//echo '<pre>';print_r($selectSIMChallanDetails);die;
					//echo count($selectSIMChallanDetails);die;
					if(count($selectSIMChallanDetails)<1)
					{
						$insertSIMChallanDetailReassignRepair=$masterObj->insertSIMChallanDetailReassignRepair($strChallanNo,$branchId,$RepairName,$sim_id);
					}
					else
					{
						if(count($selectSIMChallanDetails)>0)
						{
								if($selectSIMChallanDetails[0]["DispatchChallanNo"] != "")
								{
									$updateSimChallanDetails=$masterObj->updateSimChallanDetails($sim_id); 
									$insertSIMChallanDetailReassignRepair=$masterObj->insertSIMChallanDetailReassignRepair($strChallanNo,$branchId,$RepairName,$sim_id);
								}
								else
								{
									$updateSIMChallanDetailsExistBranch=$masterObj->updateSIMChallanDetailsExistBranch($strChallanNo,$branchId,$sim_id); 
								}
						}			
					}				
				}
				else
				{
					
					$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
					//echo '<pre>';print_r($selectSIMChallanDetails);die;
					//echo count($selectSIMChallanDetails);die;
					if(count($selectSIMChallanDetails)<1)
					{
						$insertSIMChallanDetailsRepair=$masterObj->insertSIMChallanDetailsRepair($strChallanNo,$sim_id,$branchId,$InstallerID,$remarks,$Insaller_AssignDate,$RepairName);
					}
					else
					{
						if(count($selectSIMChallanDetails)>0)
						{
								if($selectSIMChallanDetails[0]["DispatchChallanNo"] != "")
								{
									$updateSimChallanDetails=$masterObj->updateSimChallanDetails($sim_id); 
									$insertSIMChallanDetailsRepair=$masterObj->insertSIMChallanDetailsRepair($strChallanNo,$sim_id,$branchId,$InstallerID,$remarks,$Insaller_AssignDate,$RepairName);
								}
								else
								{
									$updateSIMChallanDetailsExistBranch=$masterObj->updateSIMChallanDetailsExistBranch($strChallanNo,$branchId,$sim_id); 
								}
						}
									
					}
					
						
				}		
			
			}
		}
		$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
		
				echo "<script type='text/javascript'>   
    			 window.open( 'challan_reass_sim_repair.php?challanNo=$strChallanNo&from_repair=$Installer_name_from&to_repair=$Installer_name_to');
     			</script>"; 
     			 ?><script><?php echo("location.href = '".__SITE_URL."/reassignrepair.php';");?></script><?php
	}
	
}

?>
<head>
</head>
 <form name="reassign_repair" id="reassign_repair" method="post" action="" onsubmit="return reassignRepair();" >
<body>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>ReAssign SIM To Repair </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> 
		  
		  </div>
		  <div>Reassign From</div>
		  <div class="right-item"> <select class="form-control" name="installer_list_from" id="installer_list_from" onchange="reasign_device(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($repairList);$i++)
			{?>
            <option value="<?=$repairList[$i]['id']?>"><?php echo $repairList[$i]['name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		   <div>Reassign To</div>
		   <div class="right-item"> <select class="form-control" name="installer_list_to" id="installer_list_to" onchange="">
		   <option value="0">Select</option>
         <option value="-1">Stock</option>
			<?
				for($i=0;$i<count($repairList);$i++)
			{?>
            <option value="<?=$repairList[$i]['id']?>"><?php echo $repairList[$i]['name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
          </div>
		  
       
    </div>
	<div class="portlet-body" id="tt"  style="display:none">
       
      </div>
	    
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
				url:"reasign_repair.php",
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
function reassignRepair() 
{
	var e = document.getElementById("installer_list_to");
	var inst_name_to= e.options[e.selectedIndex].value;
	//var e = document.getElementById("installer_list_to");
	//var inst_name_to= e.options[e.selectedIndex].value;
	//var strUser1 = e.options[e.selectedIndex].text;
	//alert(inst_name_to);
	if(inst_name_to==0)
	{
		alert("Please Select Installer Name To");
		document.reassign_repair.installer_list_to.focus();
		return false;
	} 
}
</script>
</html>