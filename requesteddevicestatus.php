<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//$branch_id=$_SESSION['branch_id']; 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();	
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0];
//$dbselect=$dbselect[0];
/* echo "<pre>";
print_r($branchList); 
"</pre>";die; */
$deviceTypeList=select_Procedure("CALL SelectDevType()");
$deviceTypeList=$deviceTypeList[0];
$branch_default=0;
$device_default='';
$deviceDetails=select_Procedure("CALL GetRequestedDevices('".$branch_default."','".$device_default."')");
$deviceDetails=$deviceDetails[0];
//print_r($deviceDetails);

?>
<head>
</head>
<body>
			<div class="processing-img" id="loadingmessage" style='display:none;'>
			<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
			</div>
<article>
  <div class="col-12"> 
   <form name="requested_devicestatus" id="requested_devicestatus" method="post" action="" >
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Requested Device Status</div>
      </div>
	  	<div class="portlet-body control-box">
	  <div class="content-box" style="margin-top: 10px;">
	  <div class="left-item"> <span>Branch Name:</span> </div><div class="right-item"><select class="form-control" id="branch_name" name="branch_name"  />
                  <option value="0">Select</option>
					<?php for($i=0;$i<count($branchList);$i++)
					{?>
						<option value="<?php echo $branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?></option>
					<?php } ?>
					</select></div>
				</div>
	    <div class="content-box">
	  <div class="left-item"> <span>DeviceType: </span> </div><div class="right-item"><select class="form-control" id="device_type" name="device_type"  />
                  <option role="presentation" value="0">Select</option>
                  <?php for($j=0;$j<=count($deviceTypeList);$j++){ ?>
                  <option role="presentation" value="<?php echo $deviceTypeList[$j]['item_id']; ?>"><?php echo $deviceTypeList[$j]['item_name']; ?></option>
                  <?php } ?>
                </select>  
				</div>
	  </div>
	  </div>
	  
      
    </div>
		 </form> 	</div>
	 <div class="col-12"> 
	
	<div class="portlet box yellow" >
      <div class="portlet-title">
       <div class="caption"> <i class="fa fa"></i> Device Status</div>
      </div>
      <div class="portlet-body fix-table" id="default">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th>Branch Name </th>
              <th> Device Type </th>
              <th> Device Model </th>
              <th> Total Requested Devices </th>
              <th> Pending Device </th>
			  <th> LastRequestedUnits </th>
			  <th> LastRequestedDate </th>
              <th> New/FFC/Cracked </th>
              <th> Remarks </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($deviceDetails);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
			  <td><?php echo $deviceDetails[$x]['branch_name']; ?></td>
			  <td><?php echo $deviceDetails[$x]['DeviceType']; ?></td>
              <td><?php echo $c=$deviceDetails[$x]['DeviceModel'];?></td>
			  <td><?php echo $deviceDetails[$x]['total_requested_device']; ?></td>
			  <td><?php echo $deviceDetails[$x]['pending_devices']; ?></td>
			  <td><?php echo $deviceDetails[$x]['last_requested_units']; ?></td>
			  <td><?php echo $deviceDetails[$x]['last_requested_date']; ?></td>
			  <td><?php echo $deviceDetails[$x]['device_condition']; ?></td>
			  <td><?php echo $deviceDetails[$x]['remark']; ?></td> 
            </tr>
            <?php } ?>
          </tbody>
  
        </table>
      </div>
  
	
		<div class="portlet-body" id="ss" style="display:none">
	
			</div>
		
  </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
</article>
</body>

<script type="text/javascript">
var $device_status = jQuery.noConflict();
 $device_status(document).ready(function () {
	     $device_status( document ).ajaxStart(function() {
     // $device_status( "#loadingmessage" ).show();
    });
	    $device_status( document ).ajaxStop(function() {
      $device_status( "#loadingmessage" ).hide();
    });

    $device_status('.btnaddsim').click(function (){
		var no_of_device = $device_status("#no_of_device").val();	
		//var no_of_device = document.getElementById("no_of_device").value;
		//var parent_id = document.getElementById("device_type").value;
		//alert(no_of_device);
		//alert(parent_id);
			
			});  
		 $device_status("#device_type").change(function () {
        var branch_id  = $device_status('#branch_name').val();
        var device_type  = this.value;
		//alert(first);
		//alert(second );
		document.getElementById('default').style.display = "none";
		document.getElementById('ss').style.display = "block";
		$device_status.ajax({
				type:"POST",
				url:"req_dev_status.php",
				dataType: "html",
				data:'branch_id='+ branch_id + '&device_type='+device_type,
				success:function(msg)
				{
					//alert(msg);
					   $device_status("#ss").html(msg);
					// document.getElementById("show_branch").innerHTML = msg; 
					
				},
				error:function(msg){
            
				}
		});
    });
});
			
	

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
                    'string', 'string','string','number','number', 'number','number','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</html>