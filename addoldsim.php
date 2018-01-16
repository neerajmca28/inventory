<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 

$devType=select_Procedure("CALL SelectDevType()");
$devType=$devType[0];

 
// $modelNo=select_Procedure("CALL SelectDevTypeModel()");
// $modelNo=$modelNo[0];
// echo "<pre>";
// print_r($devType) ;die();

if (isset($_POST['submit']))
{
		$check_gtrac=$_POST['gtrac'];
		if($check_gtrac=='gtrac_device')
		{
			$check_gtrac=0;
		}
		if($check_gtrac=='crack_device')
		{
			$check_gtrac=1;
		}
		/* if( $_SESSION['branch_id'])
		{
			$strUsers = "SELECT id as user_id, sys_username as name FROM matrix.users order by name asc";
		} */
		
		if(isset($_POST['username_client']))
		{
			$username_client=$_POST['username_client'];
		}
		else
		{
			$username_client="";
		}
		//echo count($_POST['txtVisionTekId']);die;
		for ($i = 0; $i < count($_POST['txtVisionTekId']); $i++) 
		{
			
			//$no_of_device=$_POST['no_of_device'];
			 $device_type=$_POST['device_type'];
			 $model_type=$_POST['model_type'];
			 $recd_date=date('Y-m-d H:i:s',strtotime($_POST['date']));
			// $txtVisionTekId=$_POST['txtVisionTekId'][$i]. '</br>';
			//$txtVisionTekId=$_POST['txtVisionTekId'][$i]
			/*  if(isset($_POST['serial_no'][$i]))
			 {
				$ITGC_ID=$_POST['serial_no'][$i].'X'.$_POST['txtVisionTekId'][$i];
	
			 } */
			  $device_sno=$_POST['txtVisionTekId'][$i];
			$txtimei="";
			$tt= select_Procedure("CALL SaveRequestedNewDevice('".$device_sno."', '".$txtimei."', '".$model_type."','".$recd_date."','".$device_type."','".$check_gtrac."','".$username_client."')");
			
			 /* mysql_query("UPDATE Application_Setting SET id='".$_POST['serial_no'][$i]."' WHERE parentid='".$device_type."'"); 
			 $insert_device = $masterObj->insertDeviceData($device_sno,$ITGC_ID,$recd_date,$model_type,$check_gtrac,$device_type,$username_client); */
		}	
}
?>
<article>
	<form method="post" action="" name="form1" id="form1" onSubmit="return req_info();">
	  	<div class="col-md-12"> 
	    <!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box yellow">
				<div class="portlet-title">
					<div class="caption"> <i class="fa fa"></i>Add Old Sim </div>
				</div>
				<div class="portlet-body control-box">
					<div class="content-box">
						<div class="left-item"> <span>No.Of Sim :</span> </div>
						<div class="right-item"> <input type="text" name="no_of_device" id="no_of_sim" class="form-control" ></div>
					</div>
					<div class="content-box">
						<div class="left-item"></div>
						<div class="right-item">
							<input type="hidden" value="<?php echo $_SESSION['branch_id'] ?>" id="branchid">
							<input class="btn btn-success btnaddsim" type="button" id="Submit" value="Submit">
							<input class="btn btn-primary" type="reset" id="reset" value="Reset">
						</div>
					</div>
					<div>&#160;</div>
					<div class="content-box" id="divTable">
						<table class="table table-bordered" id="dynamic">
							<thead id="addoldsimid">
					        	<tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
					  	  	    	<th style="text-align: center">Sim No</th>
								    <th style="text-align: center">Phone No</th>
								    <th style="text-align: center">Activation Status</th>
								</tr>
							</thead>
							<tbody id="textA"></tbody>
							<tr style="color:White;background-color:#5D7B9D;font-weight:bold;" >
							  <td></td>
							  <td></td>
		                      <td colspan="11" style='text-align: center' id="footerId">
		                      	<input class="btn btn-success btnaddsim" type="button" id="Submit" value="Add">
		                      </td>  
		                    </tr> 
						</table>
					</div>
				</div>
			</div>
	  	</div>
	</form>
</article>
<script>
	 $(document).ready(function () {
	$("#divTable").hide(); 

	    $("#Submit").on('click', function() {

	    	 $(this).prop("disabled",true);
	    	 $("#divTable").show();
	    	var number = $("#no_of_sim").val();
			//alert(number)

				for(var i =1; i <= number; i++) {
			
				var age1 = "<tr><td><input type='text' class='form-control' required name='date[]' /></td><td><input type='text' class='form-control' required name='date[]' /></td><td style='text-align: center' ><input type='checkbox' name='checkAll' id='checkAll' onClick='checkAllId();'' class='checkAll' checked></td></tr>";
				$("#textA").append(age1);
				$(':input[type="submit"]').prop('disabled', true);

			}

	    });
	});
</script>
</body>
</html>