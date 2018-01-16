<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
$branchId=$_SESSION['branch_id'];
$login_name= $_SESSION['user_name_inv'];	
$masterObj = new master();
//$branchId=2;
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$SelectSimAssign=select_Procedure("CALL SelectSimAssign('".$branchId."')");
$SelectSimAssign=$SelectSimAssign[0];
/* echo "<pre>";
print_r($SelectSimAssign); 
"</pre>";die;  */
$rowcount=count($SelectSimAssign); 
$installerList=db__select_staging("select * from installer where branch_id='".$_SESSION['branch_id']."' and is_delete=1");
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0];
$repairList=select_Procedure("CALL GetRepairUser()");
$repairList=$repairList[0];
//$repairList=db__select("select * from repair_user");
//$strBranchID=$_SESSION['branch_id'];
if (isset($_POST['submit']))
{
	$strResult='';
	
	$ChallanMode=$Sim;
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
	   if(count($strSqlQuery)>0)
	   {
		   $strResult=$strSqlQuery[0]['Id']+1;
	   }
	   $strChallanNo=$strCH.$strResult; 
	  // echo $strChallanNo; die;
		if(!isset($_POST['radio_value']))
		{
				$errorMsg="Please select either Installer, Branch or DITMS/Amit ";
				echo "<script type='text/javascript'>alert('$errorMsg');</script>";
				?><script><?php echo("location.href = '".__SITE_URL."/assignsiminstaller.php';");?></script><?php
				
		}
		if($_POST['radio_value']=='by_dimts')
		{
				   	 for($i=0;$i<$rowcount;$i++)
					 {
					   if(isset($_POST['rowVal'][$i]))
					   {
							 $remark=$_POST['remark'][$i]; 
							$data=explode('##',$_POST['rowVal'][$i]);
							$sim_id=$data[0];
							$st1=$data[6];
							
							//$selectDeviceType=$masterObj->selectDeviceType($item_id);
							//echo "<pre>";print_r($selectDeviceType[0]['item_name']); die;
							//$device_type=$selectDeviceType[0]['item_name'];
							//$l1=$_SESSION['session_id'];
							$RepairName = "Amit";
							if ($st1 == 89)
							{
								$Sim_status=$Sim_Installed;
							}
							//echo $Sim_status; die;
							$device_Removed_Date=date('Y-m-d H:i:s');
							$AssignedToBranch_Repair=select_Procedure("CALL AssignedSIMToInstaller('".$sim_id."','".$Sim_status."','".$branchId."')");
							$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
							//echo '<pre>';print_r($selectSIMChallanDetails);die;
							//echo count($selectSIMChallanDetails);die;
								if(count($selectSIMChallanDetails)<1)
								{
									$insertSIMChallanDetails=$masterObj->insertSIMChallanDetails($strChallanNo,$sim_id,$branchId,$RepairName,$AssignDate);
								}
								else
								{
									if(count($selectSIMChallanDetails)>0)
									{
										if($selectSIMChallanDetails[0]["DispatchChallanNo"] != "")
										{
											 $updateSIMChallanDetails=$masterObj->updateSIMChallanDetails($sim_id); 
											 $insertSIMChallanDetails=$masterObj->insertSIMChallanDetails($strChallanNo,$sim_id,$branchId,$RepairName,$AssignDate);
										}
										else
										{
											$updateSIMChallanDetailsExist=$masterObj->updateSIMChallanDetailsExist($strChallanNo,$branchId,$RepairName,$sim_id); 
										}
									}	
								}
						} 
					}	
				 $updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  
				 // header("location:challan_sim_ditms.php?challanNo=".$strChallanNo);	
				  	 //$playerurl="challan_sim_ditms.php";
					 //header("location:".$playerurl."?challanNo=".$strChallanNo."&to_repair=".$RepairName);
					 echo "<script type='text/javascript'>   
					window.open( 'challan_sim_ditms.php?challanNo=$strChallanNo&to_repair=$RepairName');
					</script>";
		}
		else if($_POST['radio_value']=='by_installer')
		{
				   if($_POST['installer_list']==0)
				   {
							$errorMsg="Please select Installer";
							echo "<script type='text/javascript'>alert('$errorMsg');</script>";
							?><script><?php echo("location.href = '".__SITE_URL."/assignsiminstaller.php';");?></script><?php
				   }
				   for($i=0;$i<$rowcount;$i++)
					{
					   if(isset($_POST['rowVal'][$i]))
					   {
							$remark=$_POST['remark'][$i];
							$data=explode('##',$_POST['rowVal'][$i]);
							$sim_id=$data[0];
							$st1=$data[6];
							if ($st1 == 89)
							{
								  $Sim_status=$Sim_Servies; 
							}
							$Installer_id=$_POST['installer_list'];
							$selectInstallerName=$masterObj->selectInstallerName($Installer_id);
							$Installer_name=$selectInstallerName[0]['inst_name']; 
						
							//echo $DeviceStatus;
							$Insaller_AssignDate=date('Y-m-d H:i:s');
							$AssignedDevicesToInstaller=select_Procedure("CALL AssignedSIMToInstaller('".$sim_id."','".$Sim_status."','".$branchId."')");
							$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
							//echo '<pre>';print_r($selectSIMChallanDetails);die;
								//echo count($selectSIMChallanDetails);die;
								if(count($selectSIMChallanDetails)<1)
								{
									$insertSIMChallanDetailsInstaller=$masterObj->insertSIMChallanDetailsInstaller($strChallanNo,$sim_id,$branchId,$Installer_id,$remark,$Insaller_AssignDate);
								}
								else
								{
									if(count($selectSIMChallanDetails)>0)
									{
										if($selectSIMChallanDetails[0]["DispatchChallanNo"] != "")
										{
											 $updateSIMChallanDetails=$masterObj->updateSIMChallanDetails($sim_id); 
											 $insertSIMChallanDetailsInstaller=$masterObj->insertSIMChallanDetailsInstaller($strChallanNo,$sim_id,$branchId,$Installer_id,$remark,$Insaller_AssignDate);
										}
										else
										{
											$updateSIMChallanDetailsExist=$masterObj->updateSIMChallanDetailsExistInstaller($strChallanNo,$branchId,$Installer_id,$sim_id); 
										}
									}	
								}
								
									
					   }
					}
							$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  
								// $playerurl="challan_sim_installer.php";
							//header("location:".$playerurl."?challanNo=".$strChallanNo."&to_installer=".$Installer_name);
							 echo "<script type='text/javascript'>   
							window.open( 'challan_sim_installer.php?challanNo=$strChallanNo&to_installer=$Installer_name');
							</script>";		
			}
			else if($_POST['radio_value']=='by_branch')
			{
				    for($i=0;$i<$rowcount;$i++)
					{
					   if($_POST['branch_list']==0)
					   {
								$errorMsg="Please select Branch";
								echo "<script type='text/javascript'>alert('$errorMsg');</script>";
								?><script><?php echo("location.href = '".__SITE_URL."/assignsiminstaller.php';");?></script><?php
					
					   }
					   if(isset($_POST['rowVal'][$i]))
					   {
		
							$data=explode('##',$_POST['rowVal'][$i]);
							 $sim_id=$data[0];
							$st1=$data[6];
							$remarkss=$_POST['remark'][$i];
							if ($st1 == 89)
							{
								if($_POST['branch_list']==1)
								{
									$Sim_status=$Sim_Recd;
								}
								else
								{
									$Sim_status=$Sim_Recd;
								}
							}
							
							$branch_send_date=date('Y-m-d H:i:s');
							$dispatchBranch_id=$_POST['branch_list'];
							/*$selectDispatchBranch =$masterObj->selectDispatchBranch($dispatchBranch_id);
							$dispatch_branch=$selectDispatchBranch[0]['branch_name']; */
			
							$AssignedToBranch_Repair=select_Procedure("CALL AssignedSIM_branch('".$remarkss."','".$dispatchBranch_id."','".$Sim_status."','".$sim_id."')"); 
							$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
							//echo '<pre>';print_r($selectSIMChallanDetails);die;
								//echo count($selectSIMChallanDetails);die;
							if(count($selectSIMChallanDetails)<1)
							{
								$insertSIMChallanDetailsBranch=$masterObj->insertSIMChallanDetailsBranch($strChallanNo,$sim_id,$dispatchBranch_id);
							}
							else
							{
								if(count($selectSIMChallanDetails)>0)
								{
									if($selectSIMChallanDetails[0]["DispatchChallanNo"] != "")
									{
										$updateSimChallanDetails=$masterObj->updateSimChallanDetails($sim_id); 
										$insertSIMChallanDetailsBranch=$masterObj->insertSIMChallanDetailsBranch($strChallanNo,$sim_id,$dispatchBranch_id);
									}
									else
									{
										$updateSIMChallanDetailsExistBranch=$masterObj->updateSIMChallanDetailsExistBranch($strChallanNo,$dispatchBranch_id,$sim_id); 
									}
								}	
							}	
					
				   }
			   }
			$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  
			//header("location:challan_sim_branch.php?challanNo=".$strChallanNo);
			//$playerurl="challan_sim_branch.php";
			//header("location:".$playerurl."?challanNo=".$strChallanNo);
			 echo "<script type='text/javascript'>   
			window.open( 'challan_sim_branch.php?challanNo=$strChallanNo');
			</script>";
			   
		 }
		 else if($_POST['radio_value']=='by_repair')
			{
				    for($i=0;$i<$rowcount;$i++)
					{
					   if($_POST['repair_list']==0)
					   {
								$errorMsg="Please select repair branch user";
								echo "<script type='text/javascript'>alert('$errorMsg');</script>";
								?><script><?php echo("location.href = '".__SITE_URL."/assignsiminstaller.php';");?></script><?php
					
					   }
					   if(isset($_POST['rowVal'][$i]))
					   {
		
							$data=explode('##',$_POST['rowVal'][$i]);
							 $sim_id=$data[0];
							$st1=$data[6];
							$remarkss=$_POST['remark'][$i];
							if ($st1 == 89)
							{
								$Sim_status=$Sim_Repair;
							}
					
							$branch_send_date=date('Y-m-d H:i:s');
							$repair=explode('##',$_POST['repair_list']);
							//print_r($repair);
							 $repair_id=$repair[0];
							 $repair_user=$repair[1];
					
							$AssignedDevicesToInstaller=select_Procedure("CALL AssignedSIMToInstaller('".$sim_id."','".$Sim_status."','".$branchId."')");
							$selectSIMChallanDetails=$masterObj->selectSIMChallanDetails($sim_id);
				
								if(count($selectSIMChallanDetails)<1)
								{
									$insertSIMChallanDetails=$masterObj->insertSIMChallanDetails($strChallanNo,$sim_id,$branchId,$repair_id,$AssignDate);
								}
								else
								{
									if(count($selectSIMChallanDetails)>0)
									{
										if($selectSIMChallanDetails[0]["DispatchChallanNo"] != "")
										{
											 $updateSIMChallanDetails=$masterObj->updateSIMChallanDetails($sim_id); 
											 $insertSIMChallanDetails=$masterObj->insertSIMChallanDetails($strChallanNo,$sim_id,$branchId,$repair_id,$AssignDate);
										}
										else
										{
											$updateSIMChallanDetailsExist=$masterObj->updateSIMChallanDetailsExist($strChallanNo,$branchId,$repair_id,$sim_id); 
										}
									}	
								}
								
					
				   }
			   }
			$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  
			//header("location:challan_sim_branch.php?challanNo=".$strChallanNo);
			//$playerurl="challan_sim_branch.php";
			//header("location:".$playerurl."?challanNo=".$strChallanNo);
			 echo "<script type='text/javascript'>   
			window.open('challan_repair_recd.php?challanNo=$strChallanNo&repair_user=$repair_user');
			</script>";
			   
		 }
ob_end_flush();	   
}
?>
<head>

</head>
<body>
<form name="assg_sim" id="assg_sim" method="post" action="" onsubmit="return validateForm();" >

<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Assign SIM To Installer </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
			   <div class="right-item"> 
			   <table>
				<tr>
				  <td><input type="radio" name="radio_value" id="installer_name" value="by_installer"  onchange="by_installerName(this.value);"></td>
				  <td>Installer Name</td>
				  <td><input type="radio" name="radio_value" id="branch_name" value="by_branch" onchange="by_branchName(this.value);"></td>
				  <td>Branch Name </td>
				    <td><input type="radio" name="radio_value" id="repair_centre" value="by_repair" onchange="by_repairName(this.value);"></td>
				  <td>repair centre </td>
				  <td><input type="radio" name="radio_value" id="dimts_no" value="by_dimts" onchange="by_dimts_no(this.value);"></td>
				  <td>DITMS/Amit</td>
				</tr>
			  </table>
			  </div>
		  <div class="right-item"> <select class="form-control" name="installer_list" id="installer_list" style="display:none" onchange="assign_installer(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		   <div class="right-item"> <select class="form-control" name="branch_list" id="branch_list" style="display:none" onchange="assign_branch(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($branchList);$i++)
			{?>
            <option value="<?=$branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		  <div class="right-item"> <select class="form-control" name="repair_list" id="repair_list" style="display:none" onchange="assign_repair(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($repairList);$i++)
			{?>
            <option value="<?=$repairList[$i]['id']."##".$repairList[$i]['name']?>"><?php echo $repairList[$i]['name'];?>
            </option>
            <? } ?>
	
         </select>
		 </div>
		 
          </div>
		  
       
    </div>
	<div class="portlet-body" id="tt"  style="">
        <table class="table table-bordered"  id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Sim NO</th>
			  <th> Phone No </th>
              <th> Recd SIM Date</th>
              <th> Operator </th>
              <th> Recd SIM Remarks </th>
			  <th> Assign Remarks </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				
			
            ?>
            <tr bgcolor>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectSimAssign[$x]['sim_id'];?>##<?php echo $SelectSimAssign[$x]['sim_no'];?>##<?php echo $SelectSimAssign[$x]['phone_no']; ?>##<?php echo $SelectSimAssign[$x]['rec_date']; ?>##<?php echo $SelectSimAssign[$x]['operator'];?>##<?php echo $SelectSimAssign[$x]['RecdRemarks']; ?>##<?php echo $SelectSimAssign[$x]['sim_status']; ?>" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $SelectSimAssign[$x]['sim_no']; ?></td>
			  <td><?php echo $SelectSimAssign[$x]['phone_no']; ?></td>
			  <td><?php echo $SelectSimAssign[$x]['rec_date'];?></td>
			   <td><?php echo $SelectSimAssign[$x]['operator']; ?></td>
			  <td><?php echo $SelectSimAssign[$x]['RecdRemarks']; ?></td>
              <td><textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea></td>
			  </tr>
			     <?php } ?>
              <!--<td colspan="11"><input type="submit" onclick="bulk()" name="submit" id="submit" value="Assign"></td>-->
            </tr>
          </tbody>
        </table>
		    <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Assign"></td>
      </div>
          </div>
         
      </div>
   
    <!-- END BORDERED TABLE PORTLET--> 
  
</article>
  </form>
  
</body>
<script type="text/javascript">
function by_installerName(number)
{
	document.getElementById('installer_list').style.display = "block";
	document.getElementById('branch_list').style.display = "none";
	document.getElementById('repair_list').style.display = "none";
	 
}
function by_branchName(number)
{
	 document.getElementById('branch_list').style.display = "block";
	 document.getElementById('installer_list').style.display = "none";
	document.getElementById('repair_list').style.display = "none";
}
function by_repairName(number)
{
	 document.getElementById('repair_list').style.display = "block";
	 document.getElementById('installer_list').style.display = "none";
	document.getElementById('branch_list').style.display = "none";
}

function by_dimts_no(number)
{
	 document.getElementById('installer_list').style.display = "none";
	 document.getElementById('branch_list').style.display = "none";
	 document.getElementById('repair_list').style.display = "none";
}

</script>
<script>
function validateForm() 
{
	//var r = document.getElementsByName("radio_value");
      var test = document.getElementsByName("radio_value");
	  var sizes = test.length;
	  var flag=0;
	  //alert(sizes);
      for (i=0; i < sizes; i++) 
	  {
         if (test[i].checked==true)
		  {
             // alert(test[i].value + ' you got a value');     
             //return test[i].value;
			 flag=1;
          }
      }
	//alert(flag);
	//alert(test[1].value);
	if(flag!=1)
	{
		alert("Please select either Installer Name,Branch Name,Repair Centre or DITMS/Amit");
		return false;
	}
	else
	{
		if(test[0].checked==true)
		{
			var e = document.getElementById("installer_list");
			var inst_name = e.options[e.selectedIndex].value;
			//var strUser1 = e.options[e.selectedIndex].text;
			//alert(inst_name);
			if(inst_name==0)
			{
				alert("Please Select Installer Name");
				document.assg_sim.installer_list.focus();
				return false;
			} 
		}
		if(test[1].checked==true)
		{
			var e = document.getElementById("branch_list");
			var branch_name = e.options[e.selectedIndex].value;
			if(branch_name==0)
			{
				alert("Please Select Branch Name");
				document.assg_sim.branch_list.focus();
				return false;
			} 
		}
		if(test[1].checked==true)
		{
			var e = document.getElementById("repair_list");
			var branch_name = e.options[e.selectedIndex].value;
			if(branch_name==0)
			{
				alert("Please Select Repair Centre");
				document.assg_sim.repair_list.focus();
				return false;
			} 
		}
	
		
	}

	
}
</script>

<script>
 var $assign = jQuery.noConflict()
  $assign('.checkbox1').on('change', function() {
    var bool = $assign('.checkbox1:checked').length === $assign('.checkbox1').length;
    $assign('#checkAll').prop('checked', bool);
  });

  $assign('#checkAll').on('change', function() {
    $assign('.checkbox1').prop('checked', this.checked);
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
                    'number', 'number','number',
                    'string','number', 'string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>

</html>