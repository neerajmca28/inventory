<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 

$devType=select_Procedure("CALL SelectDevType()");
$devType=$devType[0];

?>
<article>
	<form method="post" action="" name="form1" id="form1" onSubmit="return req_info();">
	  	<div class="col-12"> 
	    <!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box yellow">
				<div class="portlet-title">
					<div class="caption"> <i class="fa fa"></i>Request New Device</div>
				</div>
				<div class="portlet-body control-box">
					<div class="content-box">
						<div class="left-item"> <span>No.Of Devices *:</span> </div>
						<div class="right-item"> <input type="text" name="no_of_device" id="no_of_device" class="form-control" ></div>
					</div>
					<div class="content-box">
						<div class="left-item"> <span>New/FFC Device :</span> </div>
						<div class="right-item">
							<table>
								<tr>
									<td><input type="radio" name="dtyperadio" id="device_types_radio" value="1" checked ></td>
									<td>New </td>
									<td><input type="radio" name="dtyperadio" id="device_types_radio" value="2"></td>
									<td>FFC </td>
									<td><input type="radio" name="dtyperadio" id="device_types_radio" value="3"></td>
									<td>Cracked </td>
								</tr>
							</table>
						</div>
					</div>
					<div class="content-box">
						<div class="left-item"> <span> Device Type :</span> </div>
						<div class="right-item"> 
							<select class="form-control" name="device_type" id="device_type" onChange="(this.value);">
								<option value="0">Select Device Type</option>
								<?php for($i=0;$i<count($devType);$i++) { ?>
								<option value="<?=$devType[$i]['item_id']?>"><?php echo $devType[$i]['item_name'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="content-box">
						<div class="left-item"> <span>Model No :</span> </div>
						<div class="right-item">
							<select class="form-control" name="model_type" id="model_type" onChange="(this.value);">
								
							</select>
						</div>
					</div>
					<div class="content-box">
						<div class="left-item"><span>Remarks : </span></div>
						<div class="right-item"><input type="text" name="remarks" id="remarks" class="form-control"></div>
					</div>
					<div class="content-box">
						<div class="left-item"></div>
						<div class="right-item">
							<input type="hidden" value="<?php echo $_SESSION['branch_id'] ?>" id="branchid">
							<input class="btn btn-success btnaddsim" type="button" id="Submit" value="Submit">
							<input class="btn btn-primary" type="reset" id="reset" value="Reset">
						</div>
					</div>
				</div>
			</div>
	  	</div>
	</form>
</article>
<script>
	 $(document).ready(function () {

	 	// Select Model No
	 	$('select').on('change', function() {
	      
	      var deviceParentId = $(this).val();
	     
	      // Returns successful data submission message when the entered information is stored in database.
	      var dataString = 'dPId='+ deviceParentId;

	        if(dataString==0)
	        {
	          alert("Please Fill Fields");
	        }
	        else
	        {
	          // AJAX Code To Submit Form.
	          $.ajax({
	            type: "POST",
	            url: "process_rqstnewdevice.php",
	            data: dataString,
	            cache: false,
	            success: function(data){  
	              //alert(data)            
	              var data = JSON.parse(data);
	              var dataLength=data.length; 
	              //alert(dataLength) 
	              var tblBodyData = ''
	                if (data) {
	                  for (var i = 0; i < dataLength;  i++) {
	                    tblBodyData += '<option value="'+data[i].item_id+'">' + data[i].item_name + '</option>';
	                  }
	                }
	                $("#model_type").html(tblBodyData);
	            }
	          });
	        }
	       return false;
	    });
		// End Select Model No

	 	$("#Submit").click(function() {

			var noDevice = $("#no_of_device").val();
			var new_ffc_device = $("input[name=dtyperadio]:checked").val();
			var device_type = $("#device_type").val();
			var remarks = $("#remarks").val();
			var branchid = $("#branchid").val();
			var model = $("#model_type").val();
			//alert('tt');
			// Current Date

			var d = new Date();
			var month = d.getMonth()+1;
			var day = d.getDate();
			var hour=d.getHours();
			var minutes=d.getMinutes();
			var second=d.getSeconds();
			//alert(hour);
			var output = d.getFullYear() + '/' + ((''+month).length<2 ? '0' : '') + month + '/' + ((''+day).length<2 ? '0' : '') + day + ' ' + ((''+hour).length<2 ? '0' : '') + hour + ':' + ((''+minutes).length<2 ? '0' : '') + minutes + ':' + ((''+second).length<2 ? '0' : '') + second;
			//alert(output); 
			// End Current Date 

			var dataString = 'nodev='+ noDevice +'&condition=' + new_ffc_device + '&dvtype=' + device_type + '&remark=' + remarks + '&brnchid=' + branchid + '&date=' + output + '&modelno=' + model;
				//alert(dataString);
         	if(device_type == 0 || noDevice == '' || device_type == '' || remarks == '') {
         		alert('Pls enter all the Fields');
         	}
			else {
				
				$.ajax({
					type:"POST",
					url: "process_rqstnewdevice.php",
	            	data: dataString,
	            	cache: false,
					success: function(data){
						//alert(data);
						data1=$.trim(data);
						//alert(data1);
						if(data="success")
						 { 
						 	alert("Request has been sent to stockist");
							// $("#model_type").val('');
							// $("#no_of_device").val('');
							// $("#branchid").val('');
							// $("#remarks").val('');
							// $('#device_type').val('');
							document.location.href = 'requestednewdevice.php';
						 }
						else 
						{ 
							alert("Request has not sent to stockist.Please try again"); 
						}

					}
				});
			}	
		});	
});		
</script>
</body>
</html>