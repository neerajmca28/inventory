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
$branchId=$_SESSION['branch_id'];

$strBranchID=$_SESSION['branch_id'];
$condition="";
$installerList=db__select_staging("select * from installer where branch_id='".$_SESSION['branch_id']."' and is_delete=1");
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0];

$SelectDeadDevices=select_Procedure("CALL SelectDeadDevices('".$branchId."')");
$SelectDeadDevices=$SelectDeadDevices[0];
$rowcount=count($SelectDeadDevices);
//echo '<pre>'; print_r($SelectDeadDevices); echo '</pre>'; die;
if (isset($_POST['submit']))
{
	$strResult='';
	
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
	   if($_POST['radio_value']=='by_installer')
		{
			
			if($_POST['installer_list']==0)
			{
				$msg='Please Select Installer Name';
				echo "<script type='text/javascript'>alert('$msg');</script>";	
					
			}
			else
			{
				for($i=0;$i<$rowcount;$i++)
				{
					if(isset($_POST['rowVal'][$i]))
					{
						$data=explode('##',$_POST['rowVal'][$i]);
						//print_r($data);die;
						$DeviceId=$data[0];
						$itgc_id=$data[1];
						$device_imei=$data[2];
						$st1=$data[3];
						if ($st1 == 94 )
						{
							$status = $ReAssignDeadDevice; 
						}
						$status = $ReAssignDeadDevice;
						$antena=$_POST['antenna'][$i];
						$immob_type=$_POST['immob_type'][$i];
						$immob_count=$_POST['immob'][$i];
						$connectors=$_POST['connectors'][$i];
						$dispatch_branch=0;
						$installer_id=$_POST['installer_list'];
						$Insaller_AssignDate=date('Y-m-d H:i:s');
						$selectInstallerName=$masterObj->selectInstallerName($installer_id);
						$Installer_name=$selectInstallerName[0]['inst_name'];
						//echo $strChallanNo;
						$selectChallanDetails=$masterObj->selectChallanDetails($strChallanNo);
						//echo '<pre>';print_r($selectChallanDetails);die;
						//echo count($selectChallanDetails);die;
						$SelectDeadDevices=select_Procedure("CALL AssignedDeadDevices('".$DeviceId."','".$status."','".$dispatch_branch."','".$Insaller_AssignDate."')");
						if(count($selectChallanDetails)<1)
						{
							$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$installer_id,$branchId,$Insaller_AssignDate);
						}
						else
						{
							if(count($selectChallanDetails)>0)
							{
								if($selectChallanDetails[0]["ChallanNo"] != "")
								{
									$updateChallanDetails=$masterObj->updateChallanDetails($DeviceId); 
									$insertChallanDetailsDeadDeviceInstaller=$masterObj->insertChallanDetailsDeadDeviceInstaller($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$installer_id,$branchId,$Insaller_AssignDate);
								
								}
								else
								{
									$updateChallanDetailsNotChallanNoExist=$masterObj->updateChallanDetailsNotChallanNoExist($strChallanNo,$antena,$immob_type,$immob_count,$connectors,$installer_id,$DeviceId); 
								}
								if($installer_id == -1)
								{
									$updateNewDeviceRequest=$masterObj->updateNewDeviceRequest($DeviceId,$selectChallanDetails[0]["BranchID"]); 
									
								}
							}
							
						}
						
						$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);  
						 //header( "Location:challan_installer_dead.php?challanNo=".$strChallanNo ); 

							
					}
				}
					//$playerurl="challan_installer_dead.php";
					//header("location:".$playerurl."?challanNo=".$strChallanNo."&to_installer=".$Installer_name);
					echo "<script type='text/javascript'>   
			       window.open( 'challan_installer_dead.php?challanNo=$strChallanNo&to_installer=$Installer_name');
			       </script>";
			}
		}
		elseif($_POST['radio_value']=='by_branch')
		{ 
			if($_POST['branch_list']==0)
			{
				$msg='Please Select Branch';
				echo "<script type='text/javascript'>alert('$msg');</script>";		
			}
			else
			{
				for($i=0;$i<$rowcount;$i++)
				{
					if(isset($_POST['rowVal'][$i]))
					{
						$data=explode('##',$_POST['rowVal'][$i]);
						//print_r($data);die;
						$DeviceId=$data[0];
						$itgc_id=$data[1];
						$device_imei=$data[2];
						$st1=$data[3];
						if($_POST['branch_list']==0)
						{
							$status=$RecdDeadDevice;
						}
						else
						{
							if ($st1 == 94 )
							{
								$status = $RecdDeadDevice;
							}
						}
						$antena=$_POST['antenna'][$i];
						$immob_type=$_POST['immob_type'][$i];
						$immob_count=$_POST['immob'][$i];
						$connectors=$_POST['connectors'][$i];
						$dispatch_branch_id=$_POST['branch_list'];
						$Branch_Send_Date=date('Y-m-d H:i:s');
						$selectDispatchBranch =$masterObj->selectDispatchBranch($dispatch_branch_id);
						$dispatch_branch=$selectDispatchBranch[0]['branch_name'];
						$SelectDeadDevices=select_Procedure("CALL AssignedDeadDevices('".$DeviceId."','".$status."','".$dispatch_branch_id."','".$Branch_Send_Date."')");
						$updateChallanDetails =$masterObj->updateChallanDetails($DeviceId);
						$insertChallanDetails =$masterObj->insertChallanDetails($strChallanNo,$DeviceId,$antena,$immob_type,$immob_count,$connectors,$dispatch_branch_id);
						
						//header( "Location:challan_byBranch_dead.php?challanNo=".$strChallanNo ); 
					}
				}
				$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
				echo "<script type='text/javascript'>   
			       window.open( 'challan_byBranch_dead.php?challanNo=$strChallanNo');
			       </script>";
			     ?><script><?php echo("location.href = '".__SITE_URL."/assigndeaddevices.php';");?></script><?php
			}
		}
		else
		{
					$errorMsg="Please select either Installer or Branch";
					echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
		}
}
?>
<head>

</head>
 <form name="assignd_dead_devices" id="assignd_dead_devices" method="post" action="" onsubmit="return validateForm();" >
<body>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Assign Dead Devices To Installer </div>
      </div>
      <div class="portlet-body">
           <div class="content-box">
        
           <div class="right-item"> 
		   <table>
            <tr>
              <td><input type="radio" name="radio_value" id="installer_name" value="by_installer"  onchange="by_installerName(this.value);"></td>
              <td>Installer Name</td>
             <td><input type="radio" name="radio_value" id="branch_name" value="by_branch" onChange="by_branchName(this.value);"></td>
              <td>Branch Name </td> 
            </tr>
          </table>
		  </div>
          <div style="max-width:300px;">
		   <select class="form-control" name="installer_list" id="installer_list" style="display:none" onChange="assign_installer(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($installerList);$i++)
			{?>
            <option value="<?=$installerList[$i]['inst_id']?>"><?php echo $installerList[$i]['inst_name'];?>
            </option>
            <? } ?>
	
         </select>
		
		    <select class="form-control" name="branch_list" id="branch_list" style="display:none" onChange="assign_branch(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($branchList);$i++)
			{?>
            <option value="<?=$branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?>
            </option>
            <? } ?>
	
         </select>
		</div>
          </div>
		  
       
    </div>
	<div class="portlet-body" id="tt"  style="">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> DeviceID</th>
			  <th> ITGC ID</th>
			  <th> IMEI </th>
			  <th> Device Sno</th>
              <th>Client Name</th>
              <th> Antenna </th>
			  <th> Immobilizer </th>
			  <th> Connectors </th>
			  <th> Opencase Date </th>
			  <th>  Veh No </th>
			  <th> Dead Device SendDate </th>
			  <th> Send Branch Name </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectDeadDevices[$x]['device_id'];?>##<?php echo $SelectDeadDevices[$x]['itgc_id'];?>##<?php echo $SelectDeadDevices[$x]['device_imei']; ?>##<?php echo $SelectDeadDevices[$x]['device_status'];?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $SelectDeadDevices[$x]['device_id']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['itgc_id']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['device_imei']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['device_sno']; ?></td>
			  <td><?php echo $SelectDeadDevices[$x]['client_name']; ?></td>
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
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SelectDeadDevices[$x]['opencase_date']));?></td>
			    <td><?php echo $SelectDeadDevices[$x]['veh_no'];?></td>
				<td><?php echo $SelectDeadDevices[$x]['deadDeviceSendDate'];?></td>
			    <?php $branch_id=$SelectDeadDevices[$x]['dispatch_branch'];
			  if($branch_id==1)
			  {
				  $branch_id='Delhi';
			  }
			   if($branch_id==2)
			  {
				  $branch_id='Mumbai';
			  }
			   if($branch_id==3)
			  {
				  $branch_id='Jaipur';
			  }
			   if($branch_id==4)
			  {
				  $branch_id='Sonepat';
			  }
			   if($branch_id==5)
			  {
				  $branch_id='Kanpur';
			  }
			    if($branch_id==6)
			  {
				  $branch_id='Ahmedabad';
			  }
			    if($branch_id==7)
			  {
				  $branch_id='kolkata';
			  }
			  ?>
			   <td><?php echo $branch_id; ?></td>
			   <input type="hidden" name="branch_id[]" id="branch_id" value="<?php echo $branch_id; ?>">
             
            </tr>
            <?php } ?>
            
          </tbody>
         
        </table>
		 <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Assign"></td>
      </div>
      </div>
      </div>
	   </form> 
    <!-- END BORDERED TABLE PORTLET--> 
  
</article>
<script type="text/javascript">
function by_installerName(number)
{
	document.getElementById('installer_list').style.display = "block";
	document.getElementById('branch_list').style.display = "none";
	 //document.getElementById('tt').style.display = "none";
	 
}
function by_branchName(number)
{
	 document.getElementById('branch_list').style.display = "block";
	 document.getElementById('installer_list').style.display = "none";
	// document.getElementById('send_delhi').style.display = "none";
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
        document.getElementById("antenna"+i).disabled = false;
        document.getElementById("immob"+i).disabled = false;
		document.getElementById("immob_type"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false;
        }
      else
      {
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
      document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("immob_type"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;
    }else{
      document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("immob_type"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
    }
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
		alert("Please select either Installer Name,Branch Name or Send To Repair Center Delhi");
		return false;
	}
	else
	{
		if(test[0].checked==true)
		{
			var e = document.getElementById("installer_list");
			var inst_name = e.options[e.selectedIndex].value;
			//var strUser1 = e.options[e.selectedIndex].text;
			//alert(strUser1);
			if(inst_name==0)
			{
				alert("Please Select Installer Name");
				document.assignd_dead_devices.installer_list.focus();
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
				document.assignd_dead_devices.branch_list.focus();
				return false;
			} 
		}
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
                    'number', 'number','number','number','number','string', 'number','number','number','number','number','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>