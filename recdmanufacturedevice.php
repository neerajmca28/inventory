<?php
include("config.php");
include("device_status.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$rowcount=count($grid);
$condition="";
$branch_id=$_SESSION['branch_id'];
$SelectRecdManufactureDevice=select_Procedure("CALL SelectRecdManufactureDevice()");
$SelectRecdManufactureDevice=$SelectRecdManufactureDevice[0]; 
//echo '<pre>';print_r($SelectRecdManufactureDevice); echo '</pre>'; die;
$rowcount=count($SelectRecdManufactureDevice);
?>
<head>

</head>
<body>
   <div class="color-sign">
      <div class="cl-item"><span class="lightgreen"></span><span>Light Green :</span><span>Internal Manufacture</span></div>
  </div>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Recieved Manufacture Device</div>
      </div>
      
	<div class="portlet-body fix-table" id="tt"  style="">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
              <th> ITGC ID</th>
			  <th> Device ID </th>
              <th> Device IMEI</th>
              <th> Vehilce No </th>
              <th> Client Name </th>
			  <th> Branch Name </th>
			  <th> Is Branch Name </th>
			  <th> Manufacture Name </th>
			  <th>Manufacture Remarks By Repair</th>
              <th> Manufacture Contact Name </th>
			  <th> Internal Manufacuture</th>
			  <th> Remarks</th>
			  <th> DEAD </th>
			  <th> Replace</th>
			  <th> Repair </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
					 $internal_manu=$SelectRecdManufactureDevice[$x]['Internal_Manufacuture'];
				 if($internal_manu==1)
				 {
					 $color="LightGreen";
				 }
				 else
				 {
					 $tool_tip="internal_manufacture";
				 }
            ?>
            <tr bgcolor="<?php echo $color; ?>"  title="<?php echo $tool_tip ?>">
			
			  <td><?php echo $SelectRecdManufactureDevice[$x]['itgc_id']; ?></td>
			  <td><?php echo $SelectRecdManufactureDevice[$x]['device_id']; ?></td>
			  <td><?php echo $SelectRecdManufactureDevice[$x]['device_imei']; ?></td>
			  <td><?php echo $SelectRecdManufactureDevice[$x]['veh_no']; ?></td>
			  <td><?php echo $SelectRecdManufactureDevice[$x]['client_name']; ?></td>
			  <td><?php echo $SelectRecdManufactureDevice[$x]['Is_Branch_Recevied']; ?></td>
			  <?php $branch_id=$SelectRecdManufactureDevice[$x]['Is_Branch_Recevied'];
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
			  <td><?php echo $SelectRecdManufactureDevice[$x]['ManufactureName']; ?></td>
			  <td><?php echo $SelectRecdManufactureDevice[$x]['ManufactureRemarks']; ?></td>
			   <td><?php echo $SelectRecdManufactureDevice[$x]['contact_name]']; ?></td>
			   <td><?php echo $SelectRecdManufactureDevice[$x]['Internal_Manufacuture]']; ?></td>
		
              <td>
                <textarea rows="1" cols="30" id="remark" name="remark[]" ></textarea> 
              </td>
				<td><a href="#"  onclick="return dead_Device(<?php echo $SelectRecdManufactureDevice[$x]["device_id"];?>);"><strong>Dead</strong></a></td>
			  <td><a href="#" onClick="return replace_Device(<?php echo $SelectRecdManufactureDevice[$x]["device_id"];?>);"><strong>Replace</strong></a></td>
			  <td><a href="#" onClick="return repair_Device(<?php echo $SelectRecdManufactureDevice[$x]["device_id"];?>);"><strong>Repair</strong></a></td> 
            </tr>
            <?php } ?>
         
          </tbody>
          </form> 
        </table>
      </div>
          </div>
         
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  
</article>
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

<script type="text/javascript">

var $recd_manuf = jQuery.noConflict();
function dead_Device(deviceId)
{
	var result = confirm("Are you sure to Dead");
    if (result == true) {
	var remark = $recd_manuf('#remark').val();
	//alert(user_id);
	//return false;
$recd_manuf.ajax({
		type:"GET",
		url:"userInfo.php?action=recd_dead_device",
		data:"deviceId=" + deviceId + "&remark=" + remark,
		success:function(msg){
			// alert(msg);
			 window.location.href = "recdmanufacturedevice.php";	
		 
		//location.reload(true);		
		}
	});
	}
}

function replace_Device(deviceId)
{
	var result = confirm("Are you sure to Replace");
    if (result == true) {
	var remark = $recd_manuf('#remark').val();
	$recd_manuf.ajax({
		type:"GET",
		url:"userInfo.php?action=recd_replace_device",
 		 
		 data:"deviceId=" + deviceId + "&remark=" + remark,
		success:function(msg){
			// alert(msg);
			 window.location.href = "replaceimei.php";		
		}
	});
	}
}

function repair_Device(deviceId)
{
	var result = confirm("Are you sure to Repair");
    if (result == true) {
	var remark = $recd_manuf('#remark').val();
		$recd_manuf.ajax({
		type:"GET",
		url:"userInfo.php?action=recd_repair_device",
 		 
		 data:"deviceId=" + deviceId + "&remark=" + remark,
		success:function(msg){
			// alert(msg);
			window.location.href = "recdmanufacturedevice.php";	
		}
	});
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
                    'number', 'number','number','number','string','string', 'string','string','string','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>