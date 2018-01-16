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
$branch_id=$_SESSION['branch_id'];
$SelectBranchRepairDevice2=select_Procedure("CALL SelectBranchRepairDevice2('".$branch_id."')");
$SelectBranchRepairDevice2=$SelectBranchRepairDevice2[0]; 
//echo '<pre>';print_r($SelectBranchRepairDevice2); echo '</pre>'; die;
$rowcount=count($SelectBranchRepairDevice2);	
?>

</head>
<body>
  <form name="sim_deactivation_check" id="sim_deactivation_check" method="post" action="" >

				
<article>

  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Branch Repair Device </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th>Device ID</th>
              <th>ITGC ID</th>
              <th> IMEI  </th>
              <th>Vehilce No</th>
              <th> Client Name </th>
			  <th> Remove Date </th>
			  <th>Receive Date </th>
              <th>Received_Installer_Name </th>
              <th> Remove_installer_name </th>
			  <th> Antenna</th>
			  <th>Immobilizer </th>
              <th> Immobilizer Type </th>
			  <th> Connectors</th>
			  <th>Remarks </th>
              <th> Repaired At Branch</th>
			  <th> Send To Repair Center</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
	
            ?>
            <tr>
			  <td><?php echo $SelectBranchRepairDevice2[$x]['device_id']; ?></td>
			  <td><?php echo $SelectBranchRepairDevice2[$x]['itgc_id']; ?></td>
			  <td><?php echo $SelectBranchRepairDevice2[$x]['device_imei']; ?></td>
              <td><?php echo $c=$SelectBranchRepairDevice2[$x]['veh_no'];?></td>
			  <td><?php echo $c=$SelectBranchRepairDevice2[$x]['client_name'];?></td>
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SelectBranchRepairDevice2[$x]['device_removed_date'])); ?></td>
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SelectBranchRepairDevice2[$x]['recd_date'])); ?></td>
			  <?php $installer=db__select_staging("select inst_name from installer where inst_id='".$SelectBranchRepairDevice2[$x]['Received_installer_name']."' AND is_delete=1");
			  ?>
			 <td><?php echo $installer[0]['inst_name']; ?></td>
			  
			  <td><?php echo $SelectBranchRepairDevice2[$x]['Remove_installer_name']; ?></td>
			    
				<?php $is_antena=$SelectBranchRepairDevice2[$x]['is_antenna_recd']; 
				if($is_antena==1)
				{
						$antena="True";
				}
				else
				{
						$antena="False";
				}
				?>
				<td><?php echo $antena; ?></td>
				<?php $is_immobilizer=$SelectBranchRepairDevice2[$x]['is_immobilizer_recd']; 
				if($is_immobilizer==1)
				{
						$is_immobilizer="True";
				}
				else
				{
						$is_immobilizer="False";
				}
				?>
				<td><?php echo $is_immobilizer; ?></td>
		
			  <td><?php echo $SelectBranchRepairDevice2[$x]['DispatchImmobilizerType']; ?></td>
			  	<?php $is_connectors=$SelectBranchRepairDevice2[$x]['is_connectors_recd']; 
				if($is_connectors==1)
				{
						$is_connectors="True";
				}
				else
				{
						$is_connectors="False";
				}
				?>
				<td><?php echo $is_immobilizer; ?></td>
			    <td><?php echo $SelectBranchRepairDevice2[$x]['branch_repaired_remarks']; ?></td>
			  <td><a href="#" onClick="return repairedFunction('<?php echo $SelectBranchRepairDevice2[$x]["device_id"];?>','<?php echo $SelectBranchRepairDevice2[$x]['branch_repaired_remarks'];?>');">Repaired</a></td>
			  <td><a href="#" onClick="return sendToRepairFunction('<?php echo $SelectBranchRepairDevice2[$x]["device_id"];?>','<?php echo $SelectBranchRepairDevice2[$x]['branch_repaired_remarks'];?>','<?php echo $SelectBranchRepairDevice2[$x]["device_imei"];?>','<?php echo $SelectBranchRepairDevice2[$x]["is_antenna_recd"];?>','<?php echo $SelectBranchRepairDevice2[$x]["is_immobilizer_recd"];?>','<?php echo $SelectBranchRepairDevice2[$x]["DispatchImmobilizerType"];?>','<?php echo $SelectBranchRepairDevice2[$x]["is_connectors_recd"];?>');">Send To Repair Centre</a></td>

            </tr>
            <?php } ?>
           
          </tbody>
          </form> 
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  

</article>

</body>
<script>
var $rep = jQuery.noConflict();
function repairedFunction(device_id,remarks)
{
	//alert(device_id);
	//alert(remarks);
	alert("Are you sure for Repair");
	$rep.ajax({
		type:"GET",
		url:"userInfo2.php?action=repaired",
		data:"device_id="+ device_id+"&remarks="+remarks,
		success:function(msg){
			 alert(msg);
			 //alert(sim_no + " sim is activated");
			//location.reload(true);
			window.location.href = "assigndevicesinstaller.php";		
		}
	});
}
function sendToRepairFunction(device_id,remarks,imei,antena,immob,immob_type,connector)
{
	alert("Are you sure to Send Repair Centre");
	//alert(device_id);
	//alert(device_id);
	$rep.ajax({
		type:"GET",
		url:"userInfo2.php?action=send_to_rep_centre",
		data:"device_id="+ device_id + "&remarks="+ remarks +"&imei="+ imei +"&antena="+ antena +"&immob="+ immob +"&immob_type="+ immob_type +"&connector="+ connector,
		success:function(msg){
			//alert(msg);
			//location.reload(true);
		//	window.location.href = "branchrepairdevice.php";		
		//window.location.href = "challan_dispatch_repair.php?challanNo="+msg;

       window.open('challan_dispatch_repair.php?challanNo='+msg);
     window.location.href = "branchrepairdevice.php";	
 
		}
	});
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
                    'number', 'number','number','string','number','number', 'string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</html>