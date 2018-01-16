<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 


$masterObj = new master();
$SelectRepairDevices=select_Procedure("CALL SelectRepairDevices()");
$SelectRepairDevices=$SelectRepairDevices[0];
//echo '<pre>';print_r($SelectRepairDevices); echo '</pre>'; die;
$rowcount=count($SelectRepairDevices);
$branchID=$_SESSION['branch_id'];
/* if (isset($_POST['submit']))
{
	  $noofdevices = 1;
      $devicecondition=3;
		for($i=0;$i<count($_POST['rowVal']);$i++)
		{
			if(isset($_POST['rowVal'][$i]))
			{
				if($_POST['is_requested'][$i]=='Yes')
				{
					$msg="Request is alreadyd";
					echo "<script type='text/javascript'>alert('$msg');</script>";		
				}
				echo $remarks=$_POST['remark'][$i];
				echo $devicetype=$_POST['DeviceType'][$i];
				$requesteddate=date('d-m-Y H:i:s');
				$devicemodel=$_POST['device_model'][$i];
				echo $deviceid=$_POST['device_id'][$i];
				$SetDispatchDate1=select_Procedure("CALL SaveRequestedRepairDevice('".$branchID."','".$remarks."','".$devicetype."','".$requesteddate."','".$noofdevices."','".$devicemodel."','".$deviceCondition."','".$deviceid."')");
			}		
		}
} */
?>
<head>
</head>
<body>
 <form name="repair_status" id="repair_status" method="post" action="" >
 
<article>
<div class="col-12">	
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Repair Status </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th> Request Device </th>
              <th> Comments</th>
              <th> Device Type </th>
              <th> IMEI </th>
              <th> Device Status</th>
              <th> Client Name </th>
			  <th> Veh No. </th>
              <th> Device Sent To </th>
              <th> Open Case Date </th>
			  <th> Close Case Date</th>
              <th> Actual Problem </th>
              <th> Spare Cost</th>
              <th>Is Requested </th>
			  <th> Requested Date </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=1;$x<$rowcount;$x++)
			{
				
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $x; ?>" name="rowVal[]" value="" class="checkbox1"></td>
			  <td> <div class="col-md-3" >
			<div class="header-btn bn1 " onClick="setRow('<?php echo $x; ?>');" data-toggle="modal" data-target="#myModal" >
				<span id="subtotal"><font color="#00BFFF">Commment</font></span>
				<input type="hidden" value="<?php echo $SelectRepairDevices[$x]['device_id']; ?>" id="device_id<?php echo $x; ?>">
				<input type="hidden" value="<?php echo $_SESSION['user_name_inv'] ?>" id="usernameId">
			</div>
      
			<!-- Modal -->
	  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Repair Comments</h4>
				</div>
				<div class="modal-body" id="popupbox" style="display:none"></div>
				<div class="modal-body">
					<table class="table" id="filtertable">
                    <thead>
                      	<tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
	                      <th scope="col">S. No</th>
	                      <th scope="col">Comment</th>
	                      <th scope="col">Updated By</th>
	                      <th scope="col">updated Date</th>
	                   	</tr>
                    </thead>
                    <tbody id="repaircomntid"></tbody>
                   </table>
				</div>
				<div class="modal-body">
					<table>
					<tbody>
						<tr>
						<td style="font-size:12px;line-height:20px;text-align:center;">Remark</td>
						<input type="hidden" id="setDeviceId">
						<input type="hidden" id="setUserName">
						<td><textarea name="remark[]" id="remark" rows="2" cols="25" ></textarea></td>
						</tr>
						<tr>
							<td>  
							<div class="right-item">
							<!-- <input name="button1" id="button1" value="Add Comment" class="btn btn-success btnaddsim" type="button">  data-dismiss="modal" -->
							<div class="btn btn-success btnaddsim" data-dismiss="modal" value="<?php echo $SelectRepairDevices[$x]['device_id']; ?>" id="submitId" >Submit </div>
							</div>
							</td>
						</tr>
					</tbody>
					</table>
				</div>
			</div>
		   
		  </div>
		</div>
	  </div>
    </div></td>
			  <td><?php echo $SelectRepairDevices[$x]['DeviceType']; ?></td>
			    
				<input type="hidden" name="DeviceType[]" id="DeviceType" value="<?php echo $deviceData[$x]['DeviceType']; ?>">
				<input type="hidden" name="device_model[]" id="device_model" value="<?php echo $deviceData[$x]['device_model']; ?>">
					<td><?php echo $SelectRepairDevices[$x]['device_id']; ?></td>
					<td><?php echo $SelectRepairDevices[$x]['device_status'];?></td>
					<td><?php echo $SelectRepairDevices[$x]['client_name']; ?></td>
					<td><?php echo $SelectRepairDevices[$x]['veh_no']; ?></td>
					<td><?php echo $SelectRepairDevices[$x]['device_sent_to']; ?></td>
					<?php
						$opencase_date=date('d-m-Y',strtotime($SelectRepairDevices[$x]['opencase_date']));
					if($opencase_date=='01-01-1970')
					{
						$opencase_date='';
					}
					else
					{
						$opencase_date=date('d-m-Y H:i:s',strtotime($SelectRepairDevices[$x]['opencase_date']));
					}
					?>
					<td><?php echo $opencase_date; ?></td>
					<?php
					$closecase_date=date('d-m-Y',strtotime($SelectRepairDevices[$x]['closecase_date']));
					if($closecase_date=='01-01-1970')
					{
						$closecase_date='';
					}
					else
					{
						$closecase_date=date('d-m-Y H:i:s',strtotime($SelectRepairDevices[$x]['closecase_date']));
					}
					?>
					<td><?php echo $closecase_date; ?></td>


					<td><?php echo $SelectRepairDevices[$x]['actual_problem']; ?></td>
					<td><?php echo $SelectRepairDevices[$x]['spare_cost']; ?></td>
					<td><?php echo $SelectRepairDevices[$x]['is_requested']; ?></td>
					<?php
					$requested_date=date('d-m-Y',strtotime($SelectRepairDevices[$x]['requested_date']));
					if($requested_date=='01-01-1970')
					{
						$requested_date='';
					}
					else
					{
						$requested_date=date('d-m-Y H:i:s',strtotime($SelectRepairDevices[$x]['requested_date']));
					}
					?>
					<td><?php echo $requested_date; ?></td>
				</tr>
            <?php } ?>
            <tr>
             
            </tr>
          </tbody>
          </form> 
        </table>
		 <!--<td colspan="11"><input type="submit"  name="submit" class="btn btn-default table-btn-submit" id="submit" value="Request"></td>-->
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 

</article>
<script>
 var $dispatch = jQuery.noConflict();
  $dispatch('.checkbox1').on('change', function() {
    var bool = $dispatch('.checkbox1:checked').length === $dispatch('.checkbox1').length;
    $dispatch('#checkAll').prop('checked', bool);
  });

  $dispatch('#checkAll').on('change', function() {
    $dispatch('.checkbox1').prop('checked', this.checked);
  });
</script>
<script>
  /* function setRow(rowId){
    var row = document.getElementById("check"+rowId);
	//alert(row);
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
  
    }else{
      document.getElementById("remark"+rowId).disabled = true;


    }
  } */
</script>
<script type="text/javascript">
	function setRow(devid){
		 //document.getElementById("remark").innerHTML = "";
		 document.getElementById('remark').value = "";
	 	var hideDeviceId = document.getElementById("device_id"+devid).value;
	 	var setDeviceId = document.getElementById("setDeviceId").value = hideDeviceId;
	 	var usernmid = document.getElementById("usernameId").value;
	 	var dataString = 'devid='+ hideDeviceId;
		//alert(dataString);
		jQuery.ajax({
            type: "POST",
            url: "repaircomments.php",
            data: dataString,
            cache: false,
            success: function(data){ 
            //alert(data);
	    	    var data = JSON.parse(data);

	            var dataLength=data.length; 
	            var tblBodyData = '';
                if (data) {
                	//alert(data);
                  	for (var i = 0; i < dataLength;  i++) {

                    document.getElementById("popupbox").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].comment + '</td><td id="c">' + data[i].updatedBy + '</td><td id="d">' + data[i].updated_date + '</td><tr>';

                  	}
                }
				document.getElementById("repaircomntid").innerHTML = tblBodyData;
			}
        });
		document.getElementById("repaircomntid").innerHTML = "";
		var submitComment = document.getElementById("submitId");

		submitComment.onclick = function() {

		var comment = document.getElementById("remark").value;
		
		var dataString = 'commnt='+ comment + '&devid=' + setDeviceId+ '&usrnm=' + usernmid;

		//alert(dataString)

        jQuery.ajax({
            type: "POST",
            url: "repaircomments1.php",
            data: dataString,
            cache: false,
            success: function(data){ 
            	alert(data);
	    	
				}
          	});
        }
        document.getElementById("remark").innerHTML = "";
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
                    'number','number','string', 'number','number', 'string','string','number','string','number','number','string','number','string','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>