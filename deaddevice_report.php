<?php
include("device_status.php");
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$dispatch_branch=$_SESSION['branch_id'];
$SearchDeadDeviceDateALL=select_Procedure("CALL SearchDeadDeviceDateALL('".$dispatch_branch."')");
$SearchDeadDeviceDateALL=$SearchDeadDeviceDateALL[0];
$rowcount=count($SearchDeadDeviceDateALL);
//echo '<pre>';print_r($SelectManufactureDevice); echo '</pre>'; die;


?>
<head>


</head>
<body>
	<div class="processing-img" id="loadingmessage" style='display:none;'>
			<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
			</div>

 <form name="dead_device_report" id="dead_device_report" method="post" action="">
 
<article>

  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Search By Dead Devices </div>
      </div>
	  
	   <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> <table>
            <tr>
              <td><input type="radio" name="radio_select" id="all_dead_device1" value="" checked onchange="all_dead_device(this.value)"></td>
              <td>All </td>
              <td><input type="radio" name="radio_select" id="dead_by_date1" value="" onchange="dead_by_date(this.value)"></td>
              <td>Date Wise </td>
           </tr>
          </table></div>
          </div>
		  
              <div class="content-box"  id="dateFilter" style="display:none">
                <div class="left-item"> <span>Filtering By Date  :</span> </div>
                <div><div class="left-item"> <span>Start Date  :</span> </div><div class="right-item two-filter-inp"><input style="width:180px;" type="date" name="date_start" id="date_start" value="" class="form-control form_date"> </div></div>
                <div class="left-item"> <span>END Date  :</span> </div> <div class="right-item two-filter-inp"><input style="width:180px;" type="date" name="date_end" id="date_end" value="" class="form-control form_date"> </div>
                <div class="content-box">
                  <div class="left-item"></div>
                  <div class="right-item"><input  class="btn btn-primary" type="button" id="sim_search2" name="sim_search2" value="search"> </div>
                </div>
              </div>
      </div>
      <div class="portlet-body" id='tt'>
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th> Device Sno. </th>
              <th> Device IMEI </th>
              <th> Device Id</th>
              <th> Client Name </th>
			  <th> Veh No </th>
			  <th> Opencase Date </th>
              <th> Manufacture Name </th>
              <th> Manufacture Remarks </th>
			  <th> Send To Client</th>
              <th> Assign To Installer</th>
              <th> Delhi Kept at Delhi</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
		
			  <td><?php echo $SearchDeadDeviceDateALL[$x]['device_sno']; ?></td>
			  <td><?php echo $SearchDeadDeviceDateALL[$x]['device_imei']; ?></td>
              <td><?php echo $SearchDeadDeviceDateALL[$x]['device_id'];?></td>
			  <td><?php echo $SearchDeadDeviceDateALL[$x]['client_name']; ?></td>
			  <?php
				
			 
			  ?>
			  <td><?php echo $SearchDeadDeviceDateALL[$x]['veh_no'];?></td>
			  <?php $dt=date('d-m-Y',strtotime($SearchDeadDeviceDateALL[$x]['opencase_date'])); 
			   if($dt=='01-01-1970' )
				  {
					  $dt='';
				  }
			  else
				  {
					   $dt=date('d-m-Y H:i:s',strtotime($SearchDeadDeviceDateALL[$x]['opencase_date']));
					}
				  ?>
			  <td><?php echo $dt ?></td>
			  <td><?php echo $SearchDeadDeviceDateALL[$x]['ManufactureName']; ?></td>
			  <td><?php echo $SearchDeadDeviceDateALL[$x]['ManufactureRemarks']; ?></td>
			    <td><a href="#" onclick="return send_client(<?php echo $SearchDeadDeviceDateALL[$x]["device_id"];?>);"><strong>Device Dead Device Send To Client</strong></a></td>
			  <td><a href="#" onclick="return assign_installer(<?php echo $SearchDeadDeviceDateALL[$x]["device_id"];?>);"><strong>Device Assign To Installer</strong></a></td>
			   <td><a href="#" onclick="return delhi_kept_delhi(<?php echo $SearchDeadDeviceDateALL[$x]["device_id"];?>);"><strong>Delhi Kept At Client</strong></a></td> 
            </tr>
            <?php } ?>
     
          </tbody>
          </form> 
        </table>
      </div>
	  <div  class="portlet-body" id='hh'></div>
	
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
<script type="text/javascript">
var $dead_report = jQuery.noConflict();
 $dead_report(document).ready(function () {
	 
	$dead_report( document ).ajaxStart(function() {
   $dead_report( "#loadingmessage" ).show();
    });
	    $dead_report( document ).ajaxStop(function() {
      $dead_report( "#loadingmessage" ).hide();
    });


		$dead_report('#sim_search2').on("click",function() {
				var start_date = $dead_report('#date_start').val();
				var end_date = $dead_report('#date_end').val();
				//alert(start_date);
			   $dead_report.ajax({
				cache: false,
				type:"GET",
				 dataType: "html",
				url:"dead_dev_rep_ajax.php?action=dead_device_byDate",
				data:'start_date='+ start_date+'&end_date='+ end_date,
				//data:$deadList('#dispatchdevice').serialize(),
				success:function(msg)
				{
					// alert(msg);
					document.getElementById('tt').style.display = "none";
					 document.getElementById('hh').style.display = "block";
					 //document.getElementById('hh').innerHTML = msg; 
					  $dead_report("#hh").html(msg);
				}
		});  
});  	
});

function send_client(val)
{
	var result = confirm("Are you sure Dead Device Send To Client");
    if (result == true) {
	$dead_report.ajax({
			type:"GET",
			url:"userInfo.php?action=dead_dev_send_client",
			data:"device_id=" + val,
			success:function(msg){
				 // alert(msg);
				 if(msg='Dead Device Send To Client')
				 {
					 	window.location.href = "deaddevice_report.php";
				 }
				 else
				 {
					 alert('There is some problem');
				 }
		
				}
		
			});
	}
}	  
function assign_installer(dev_id)
{
	var result = confirm("Are you sure Dead Device Assign To Installer");
    if (result == true) {
	$dead_report.ajax({
			type:"GET",
			url:"userInfo.php?action=dead_assign_installer",
			data:"device_id=" + dev_id,
			success:function(msg){
				// alert(msg);
				 if(msg='Assign to Installer')
				 {
					 	window.location.href = "deaddevice_report.php";
				 }
				 else{
					 alert('There is some problem');
				 }
		
				}
			});
	}
}	

function delhi_kept_delhi(dev_id)
{
	var result = confirm("Are you sure Dead Device Kept At Client");
    if (result == true) {
	$dead_report.ajax({
			type:"GET",
			url:"userInfo.php?action=delhi_kept_client",
			data:"device_id=" + dev_id,
			success:function(msg){
				// alert(msg);
				 if(msg='Delhi Kept At Client')
				 {
					 	window.location.href = "deaddevice_report.php";
				 }
				 else{
					 alert('There is some problem');
				 }
				}
			});
	}
}	 
 
function all_dead_device(number)
{
	
  	document.getElementById('tt').style.display = "block";
	document.getElementById('dateFilter').style.display = "none";
	document.getElementById('hh').style.display = "none";
}		

function dead_by_date(number)
{
	document.getElementById('dateFilter').style.display = "block";
	document.getElementById('date_start').value = "";
	document.getElementById('date_end').value = "";
	 document.getElementById('tt').style.display = "none";
	
}
  
</script>
<script type="text/javascript">
var $da = jQuery.noConflict();


    $da('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $da('.form_date').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $da('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
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
                    'number', 'number','number','string','number','number', 'string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>