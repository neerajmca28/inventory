<?php
include("config.php");
include("device_status.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 

$condition="";
$masterObj = new master();	
$branch_id=$_SESSION['branch_id'];
$strUsers=db__select_matrix("SELECT id as user_id, sys_username as name FROM matrix.users order by name asc");
$itemList=db__select("select item_id,item_name from item_master order by item_name");
//echo "<pre>"; print_r($itemList); "</pre>";

if (isset($_POST['Submit']))
{
		if(empty($_POST['user_list']) || $_POST['user_list']==0)
		{
			$errUser="Please Select User";
		}
		else
		{
			$client_id=$_POST['user_list'];
		}
		if(empty($_POST['veh_list']) || $_POST['veh_list']==0)
		{
			$errVeh="Please Select User";
		}
		else
		{
			$vehreg=$_POST['veh_list'];
		}	
		if(empty($_POST['company_name']) || $_POST['company_name']=="")
		{
			$errCompany="Please Insert Company Name";
		}
		else
		{
			$company_name=$_POST['company_name'];
		}
		if(empty($_POST['device_imei']) || $_POST['device_imei']=="")
		{
			$errImei="Please Insert Insert IMEI";
		}
		else
		{
			$device_imei=$_POST['device_imei'];
		}
		if(empty($_POST['itgc_id']) || $_POST['itgc_id']=="")
		{
			$errITGC="Please Insert Insert ITGC ID";
		}
		else
		{
			$itgc_id=$_POST['itgc_id'];
		}
		if($errUser=='' && $errVeh=='' && $errCompany=='' && $errImei=='' && $errITGC==''  )
		{
			$recdDateFromClient=$_POST['recd_date'];
			//$recdFrom=$_POST['recd_from'];
			if($_POST['recd_from']==1)
			{
				$recdFrom="Person";
			}
			else if($_POST['recd_from']==2)
			{
				$recdFrom=="Courier";
			}
			else
			{
				$recdFrom="";
			}
			if($_POST['antina_recd']=="yes")
			{
				 $isAntenaRecd=1;
			}
			else
			{
				$isAntenaRecd=0;
			}
			if($_POST['immob_recd']=="yes")
			{
				$isImmobilizerRecd=1;
			}
			else
			{
				$isImmobilizerRecd=0;
			}
			if($_POST['conn_recd']=="yes")
			{
				$isConnectorRecd=1;
			}
			else
			{
				$isConnectorRecd=0;
			}
			$deviceremarks=$_POST['remarks'];
			$userName=$masterObj->getUserList($client_id);
			$clientName=$userName[0]['name'];
			$device_status=$SendToRepairCentre;
			$dispatchFFCNewdevice=select_Procedure("CALL SaveRepairDevice('".$clientName."','".$vehreg."','".$device_imei."','".$deviceremarks."','".$recdDateFromClient."','".$recdFrom."','".$isAntenaRecd."','".$isImmobilizerRecd."','".$isConnectorRecd."','".$device_status."')");
			if(count($dispatchFFCNewdevice)>0)
			{
				$message='Device has been received'; 
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			else
			{
				$message='Device has not been received.Please try again'; 
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}	
}
?>
<head>
<style>
.error {color: #FF0000;}
.form-control{
	width: 20%;
}
</style>
</head>
<body>
 <form name="device_from_cl" id="device_from_cl" method="post" action="" onsubmit="return deviceRecdFromClient();"  >

<article> 

  <!--page div 1 start-->
  <div class="col-12">
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Device Material</div>
      </div>
      <div class="portlet-body control-box">
   
       
     
		 <div class="content-box">
           <div class="left-item"> <span> Device Model :</span> </div>
          <div class="right-item"> <select class="form-control" name="model_list" id="model_list" onchange="veh_list1(this.value);">
         <option value="0">Select</option>
			<?
				for($i=0;$i<count($itemList);$i++)
			{?>
            <option value="<?php echo $itemList[$i]['item_id']?>"><?php echo $itemList[$i]['item_name'];?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

        

      <div class="content-box">
        <div class="left-item"> <span> Immoblizer Count:</span> </div>
         <div class="right-item"> <select class="form-control" name="immob_count" id="immob_count" onchange="immoblizer_count();">
         <option value="0">0</option>
			<?
				for($i=1;$i<=50;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
         </div>
               <div class="content-box" id="immob_tp" style="display:none" >

               <div class="left-item"> <span> Immoblizer Type:</span> </div>
               <input type="checkbox" name="immob_type" value="12_vt">12 VT
			   <input type="checkbox" name="immob_type" value="24_vt">24 VT
          </div>

      

	 <div class="content-box">
           <div class="left-item"> <span> Connector:</span> </div>
          <div class="right-item"> <select class="form-control" name="conn_count" id="conn_count" onchange="connector_count();">
         <option value="0">0</option>
			<?
				for($i=1;$i<=50;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
       </div>
         
			<div class="content-box" id="conn_type" style="display:none" >

               <div class="left-item"> <span> Connector Type:</span> </div>
               <input type="checkbox" name="immob_type" value="12_vt">Normal Connector
			   <input type="checkbox" name="immob_type" value="24_vt">Harness Connector
          </div>


          <div class="content-box">
           <div class="left-item"> <span> Antenna:</span> </div>
          <div class="right-item"> <select class="form-control" name="antena_count" id="antena_count">
         <option value="0">0</option>
			<?
				for($i=1;$i<=50;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>
		
		 <div class="content-box">
           <div class="left-item"> <span> IP Box:</span> </div>
          <div class="right-item"> <select class="form-control" name="ip_box" id="ip_box">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>


		 <div class="content-box">
           <div class="left-item"> <span> M-Ceal:</span> </div>
          <div class="right-item"> <select class="form-control" name="mceal" id="mceal">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

          	 <div class="content-box">
           <div class="left-item"> <span> Panic Button:</span> </div>
          <div class="right-item"> <select class="form-control" name="panic_button" id="panic_button">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

          <div class="content-box">
           <div class="left-item"> <span> Tye-Belt:</span> </div>
          <div class="right-item"> <select class="form-control" name="tye_belt" id="tye_belt">
         <option value="0">0</option>
			<?
				for($i=1;$i<=10;$i++)
			{?>
            <option value="<?php echo $i; ?>"><?php echo $i;?>
            </option>
            <? } ?>
	
         </select></div>
          </div>

          <div class="content-box">
           <div class="left-item"> <span>Send Date :</span> </div>
          <div class="right-item"> <input type="text" name="recd_date" id="recd_date" class="form-control form_date" value="<?php echo date('Y-m-d H:i:s');?>"></div>
          </div>

          <div class="content-box">
           <div class="left-item"> <span>Remarks :</span> </div>
          <div class="right-item"> <textarea name="remarks" id="remarks"  class="form-control"></textarea></div>
          </div>
  
           
          
           <div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item"><input  class="btn btn-primary" type="submit" name="Submit" id="device_submit" value="Submit"> <input  class="btn btn-default" type="button" name="Submit" value="Cancel"></div>
          </div>
      </div>
    </div>
  </div>
  <!--page div 1 end-->  
 
</article>
</form>
</body>
<script>
function immoblizer_count()
{
	document.getElementById('immob_tp').style.display = "block";
}
function connector_count()
{
	document.getElementById('conn_type').style.display = "block";
}

</script>

</html>