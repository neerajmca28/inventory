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
// $repairList=mysql_query("select * from inventory.repair_user where id='17'");
// $repairList=$repairList[0];
/* if($branchId==1)
{
	$branch_name='Delhi';
}
 */
if (isset($_POST['submit']))
{

	if((!isset($_POST['installer_list_from'])) || (empty($_POST['installer_list_from'])) || (($_POST['installer_list_from']==0)))
	{
			 $errorMsg="Please Select Installer Name From";
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
				$status1=93;
				$Insaller_AssignDate=date('Y-m-d H:i:s');
				 $remarks=$_POST['remark'][$i]; 
				$RepairName=$installer_list_to;
				//echo "CALL reassignsimRepair('".$remarks."','".$branchId."','".$status1."','".$sim_id."')"; die;
				$ReAssignedDevicesToInstaller=select_Procedure("CALL reassignsimRepair('".$branchId."','".$status1."','".$sim_id."')");	
			}
			$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
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
		$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
		
				echo "<script type='text/javascript'>   
    			 window.open('challan_reass_sim_repair.php?challanNo=$strChallanNo&from_repair=$Installer_name_from&to_repair=$Installer_name_to');
     			</script>"; 
     			 ?><script><?php echo("location.href = '".__SITE_URL."/reassignsimRepair.php';");?></script><?php
	}
	
}

?>
<head>

</head>
<body>
 <form name="reassign_sim1" id="reassign_sim1" method="post" action="" onsubmit="return reassignForm();">

<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>ReAssign Sim </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> 
		  
		  </div>
		  <div>Reassign From</div>
		  <div class="right-item"> <select class="form-control" name="installer_list_from" id="installer_list_from" onchange="reasign_device(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		 <div id="ss">
		   <div>Reassign To</div>
		   <div class="right-item"> <select class="form-control" name="installer_list_to" id="installer_list_to" onchange="">
		   <option value="0">Select</option>
         <option value="17">RND</option>
			
	
         </select>
		 </div>
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


</form>
</body>
<script type="text/javascript">
var $reass_sim = jQuery.noConflict();
function reasign_device(val)
{
    	$reass_sim.ajax({
				type:"POST",
				url:"reassign_sim_repair.php",
				 dataType: "html",
				data:'reasign_from='+ val,
				success:function(msg)
				{
					//jQuery(this).html(msg);
					// alert(msg);
					 $reass_sim("#tt").html(msg);
					 document.getElementById('tt').style.display = "block";
					 //document.getElementById("tt").innerHTML = msg; 
				},
				error:function(msg){
            
				}
		}); 	
}

</script>
<script>
function reassignForm() 
{
	var e = document.getElementById("installer_list_to");
	var inst_name_to= e.options[e.selectedIndex].value;
	if(inst_name_to==0)
	{
		alert("Please Select Installer Name");
		document.reassign_sim1.installer_list_to.focus();
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