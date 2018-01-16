<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$branch_id=$_SESSION['branch_id'];
if($branch_id==1)
{
	$branch_name="Delhi";
}
$login_name= $_SESSION['user_name_inv'];	
$installerList=db__select_staging("SELECT * FROM internalsoftware.installer where branch_id='".$branch_id."' and is_delete=1");
$SelectBranchRepairDevice1=select_Procedure("CALL SelectBranchRepairDevice1('".$branch_id."')");
$SelectBranchRepairDevice1=$SelectBranchRepairDevice1[0];
$rowcount=count($SelectBranchRepairDevice1);
if(isset($_POST['submit']))
{
	$errorMsg="";
	$count=0;
	//echo '<pre>'; print_r($_POST); '</pre>'; die;

		 for($i=0;$i<count($_POST['rowVal']);$i++)
			{
				//echo 'tt'; die;
				//echo count($_POST['rowVal']); die;
				//echo $_POST['receive_from_installer'][$i]; die;
				if(isset($_POST['rowVal'][$i]))
				{
					$count=1;
						if(($_POST['receive_from_installer'][$i] == "") || ($_POST['receive_from_installer'][$i] == 0))
						{
								$flag=2;
								//echo 'tt'; die;
								break;	
						}
						
						if($_POST['receive_from_installer'][$i] == 111)
						{
							
							if($_POST['other_installer'][$i]=="")
							{
								//$errorMsg="Please Enter Details In Others";
								//echo "<script type='text/javascript'>alert('$errorMsg');</script>";
								$flag=1;
								break;
							}
						}
						if($_POST['antenna'][$i]==1)
						{
							$antena=1;
						}
						if($_POST['antenna'][$i]==2)
						{
							$antena=0;
						}
						/* if($_POST['antenna'][$i]=="" || $_POST['antenna'][$i]==0)
						{
							
							//$errorMsg="Please select antena"; 
							//echo "<script type='text/javascript'>alert('$errorMsg');</script>";
							$flag=2;
							break;							
						} */
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
							//$errorMsg="Please select Immbolizer";
							//echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
							$flag=3;
							break;
						} */
						if($_POST['connectors'][$i]==1)
						{
							$connector=1;
						}
						if($_POST['connectors'][$i]==2)
						{
							$connector=0;
						}
						/* if($_POST['connectors'][$i]=="" || $_POST['connectors'][$i]==0)
						{
							//$errorMsg="Please select Connectors";
							//echo "<script type='text/javascript'>alert('$errorMsg');</script>";
							$flag=4;	
							break;							
						} */
						
				}
				
			}
			if($count!=1)
			{
				echo $errorMsg="<span style='color:red'><b>Please Select Atleast One row</b></span>";
			}
			if($flag==1)
			{
				echo $errorMsg="<span style='color:red'><b>Please Enter Details In Others</b></span>";
			}
			if($flag==2)
			{
				echo $errorMsg="<span style='color:red'><b>Please select Installer Name</b></span>"; 
			}
			/* if($flag==3)
			{
				echo $errorMsg="<span style='color:red'><b>Please select Immbolizer</b></span>";
			}
			if($flag==4)
			{
				echo $errorMsg="<span style='color:red'><b>Please select Connectors</b></span>";
			}
			 */
			if($errorMsg=="")
			{
					$challan_mode=$Dispatch;
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
					$arrDeviceId=array();
				for($i=0;$i<count($_POST['rowVal']);$i++)
				{
					if(isset($_POST['rowVal'][$i]))
					{
				
								$device=$_POST['rowVal'][$i];
								$data=explode('##',$device);
								$deviceId=$data[0];
								$arrDeviceId[$i]=$deviceId;
								$imei=$data[1];
								$itgc_id=$data[2];
								$remarks=$_POST['remark'][$i];
								$dispatchRecdDate=date('Y-m-d H:i:s');
								$deviceStatus=$RecdRemoveDevice;
								$installer_id=$_POST['receive_from_installer'][$i]; 
								
								if($installer_id==111)
								{
									 $Installer_name=$_POST['other_installer'][$i]."(Others)"; 
								}
								else
								{
									$selectInstallerName=$masterObj->selectInstallerName($installer_id);
									$Installer_name=$selectInstallerName[0]['inst_name']; 
								}
						//echo "CALL UpdateDispathRecdDevice1('".$deviceId."','".$remarks."','".$dispatchRecdDate."','".$deviceStatus."','".$Installer_name."','".$imei."','".$antena."','".$immobilzer."','".$connector."')"; 
						//die;
								$UpdateDispathRecdDevice=select_Procedure("CALL UpdateDispathRecdDevice1('".$deviceId."','".$remarks."','".$dispatchRecdDate."','".$deviceStatus."','".$Installer_name."','".$imei."','".$antena."','".$immobilzer."','".$connector."')");
								
								$updateChallanDetails=$masterObj->updateChallanDetails($deviceId); 
								$insertChallanDetails=$masterObj->insertChallanDetails_recd_remove($strChallanNo,$deviceId,$antena,$ImmobilerType,$immobilzer,$connector,$branch_id,$Installer_name); 
								
						}

				}
				$updateApplicationSetting=$masterObj->updateApplicationSetting($strChallanMode,$strResult);
			for($i=0;$i<count($arrDeviceId);$i++)
				{
					$devId.= $arrDeviceId[$i].',';
				}
				 $arrDeviceIdStr=substr($devId,0,strlen($devId)-1);

				echo "<script type='text/javascript'>   
    		   window.open( 'challan_rem_recd.php?challanNo=$strChallanNo&to_installer=$Installer_name&remarks=$remarks&deviceIDList=$arrDeviceIdStr');
    		   </script>";
    		    ?><script><?php echo("location.href = '".__SITE_URL."/branchrepairdevice.php';");?></script><?php
			}
					
	//}

}
?>
<head>
</head>
<body>
 <form name="recd_rmd_device" id="recd_rmd_device" method="post" action="" >		
<article>
  <div class="col-12"> 
			
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Recd Remove Device </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
             
              <th> ITGC ID </th>
              <th> IMEI </th>
			  <th> Veh No.</th>
			  <th> Client Name </th>
              <th> Device Removed Date </th>
			  <th> Received From </th>
			  <th> InstallerName(In case Other) </th>
              <th> Antenna </th>
			  <th>Immobilizer </th>
              <th> Connectors</th>
              <th> Remarks </th>
			  <th> IsBranchReceived </th>
			  
			  <th> Device Removed Problem </th>
			  <th> RemoveInstallerName </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectBranchRepairDevice1[$x]['device_id'];?>##<?php echo $SelectBranchRepairDevice1[$x]['device_imei'];?>##<?php echo $SelectBranchRepairDevice1[$x]['itgc_id']; ?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $SelectBranchRepairDevice1[$x]['itgc_id']; ?></td>
			  <td><?php echo $SelectBranchRepairDevice1[$x]['device_imei']; ?></td>
	
			  <td><?php echo $SelectBranchRepairDevice1[$x]['veh_no']; ?></td>
			   <td><?php echo $SelectBranchRepairDevice1[$x]['client_name']; ?></td>
			   <td><?php echo $SelectBranchRepairDevice1[$x]['device_removed_date']; ?></td>
			     <td>
                <select id="receive_from_installer<?php echo $y;?>" name="receive_from_installer[]" onChange="rec_from_installer(this.value,<?php echo $y;?>)" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($i=0;$i<COUNT($installerList);$i++){ ?>
                  <option role="presentation" value="<?php echo $installerList[$i]['inst_id']; ?>"><?php echo $installerList[$i]['inst_name'];?></option>
                  <?php } ?>
                </select>  
              </td>
			   
			   <td><input type="text" name="other_installer[]" id="other_installer<?php echo $y;?>" value="" disabled ></td>
			 	<td>
			  <select id="antenna<?php echo $y;?>" name="antenna[]" disabled />
             
				  <option role="presentation" value="1">Yes</option>
				  <option role="presentation" value="2">No</option>
			  </select></td>
			   <td>
			  <select id="immob<?php echo $y;?>" name="immob[]" disabled />
          
				  <option role="presentation" value="1">Yes</option>
				  <option role="presentation" value="2">No</option>
			  </select></td>
			 <td>
			  <select id="connectors<?php echo $y;?>" name="connectors[]" disabled />
                 
				  <option role="presentation" value="1">Yes</option>
				  <option role="presentation" value="2">No</option>
			  </select></td>
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea> 
              </td>
			  <?php $receive_from=$SelectBranchRepairDevice1[$x]['Is_Branch_Recevied'];
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
			 
			  <td><?php echo $SelectBranchRepairDevice1[$x]['device_removed_problem']; ?></td>
			  <td><?php echo $SelectBranchRepairDevice1[$x]['Remove_installer_name']; ?></td>

              
            </tr>
            <?php } ?>
       
          </tbody>
       
        </table>
			<input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Receive">
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
                    'number', 'number','number','number','number','number', 'string','number','number','string','string','string','string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>
