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
$data=array();
$SelectManufactureDevice=select_Procedure("CALL SelectManufactureDevice()");
$SelectManufactureDevice=$SelectManufactureDevice[0];
$rowcount=count($SelectManufactureDevice);
//echo '<pre>';print_r($SelectManufactureDevice); echo '</pre>'; die;
//print_r($_POST);
if(isset($_POST) && count($_POST)>0)
{
	 
		
		for($i=0;$i<$rowcount;$i++)
		{
			if(isset($_POST['rowVal'][$i]))
			{ 
				$device_id=$_POST['rowVal'][$i];
				$ManufactureSendDate=date('Y-m-d H:i:s');
				$devicestatus=$Device_Manufacture_send;
				$UpdateManufactureRecdDevice_new=select_Procedure("CALL UpdateManufactureRecdDevice_new('".$ManufactureSendDate."','".$devicestatus."','".$device_id."')");
				
		//print_r($data); die;
		//$redirect = "recdmanufacturedevice.php?".http_build_query($data);
		// header( "Location: $redirect" );
		
			}	
		}
		?><script><?php echo("location.href = '".__SITE_URL."/recdmanufacturedevice.php';");?></script>
		<?php
}

?>
<head>
</head>
<body>
  <div class="col-12"> 
 <form name="manufacture_device" id="manufacture_device" method="post" action="" >
  <div class="color-sign">
      <div class="cl-item"><span class="lightgreen"></span><span>Light Green :</span><span>Internal Manufacture</span></div>
  </div>
<article>


 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Manufacture Device</div>
      </div>
      <div class="portlet-body fix-table ">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Serial No. </th>
              <th> DeviceID </th>
              <th> Device IMEI </th>
              <th> Vehicle No </th>
              <th> Client Name </th>
			  <th> Manufacture Send Date By Repair </th>
			  <th> Branch Name </th>
              <th> Manufacture Name </th>
              <th> Manufacture Remarks By Repair </th>
			  <th> Manufacture Contact Name</th>
              <th> Manufacture Contact No</th>
              <th> ITGC ID</th>
              <th> PendingDays </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			
			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				 $internal_manufacture=$SelectManufactureDevice[$x]['Internal_Manufacuture'];
				 if($internal_manufacture==1)
				 {
					 $color="LightGreen";
           $tool_tip="internal_manufacture";
				 }
				 else
				 {
					 
				 }
            ?>
            <tr bgcolor="<?php echo $color; ?>"  title="<?php echo $tool_tip ?>">
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectManufactureDevice[$x]['device_id'];?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $y;?></td>
			  <input type="hidden" name="internal_manu[]" id="internal_manu" value="<?php echo $SelectManufactureDevice[$x]['Internal_Manufacuture']; ?>">
			  <td><?php echo $SelectManufactureDevice[$x]['device_id']; ?></td>
			  <td><?php echo $SelectManufactureDevice[$x]['device_imei']; ?></td>
              <td><?php echo $SelectManufactureDevice[$x]['veh_no'];?></td>
			  <td><?php echo $SelectManufactureDevice[$x]['client_name']; ?></td>
			  <input type="hidden" name="client_name[]" id="client_name" value="<?php echo $SelectManufactureDevice[$x]['client_name']; ?>">
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SelectManufactureDevice[$x]['ManufactureDate'])); ?></td>
			   <?php $branch_id=$SelectManufactureDevice[$x]['Is_Branch_Recevied'];
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
			   <input type="hidden" name="branch_name[]" id="branch_name" value="<?php echo $SelectManufactureDevice[$x]['Is_Branch_Recevied']; ?>">
			  <td><?php echo $SelectManufactureDevice[$x]['ManufactureName']; ?></td>
			  <input type="hidden" name="ManufactureName[]" id="ManufactureName" value="<?php echo $SelectManufactureDevice[$x]['ManufactureName']; ?>">
			   <td><?php echo $SelectManufactureDevice[$x]['ManufactureRemarks']; ?></td>
			   <input type="hidden" name="ManufactureRemarks[]" id="ManufactureRemarks" value="<?php echo $SelectManufactureDevice[$x]['ManufactureRemarks']; ?>">
			   <td><?php echo $SelectManufactureDevice[$x]['contact_name']; ?></td>
			   <input type="hidden" name="contact_name[]" id="contact_name" value="<?php echo $SelectManufactureDevice[$x]['contact_name']; ?>">
			  <td><?php echo $SelectManufactureDevice[$x]['contact_no']; ?></td>
			    <td><?php echo $SelectManufactureDevice[$x]['itgc_id']; ?></td>
				 <input type="hidden" name="itgc_id[]" id="itgc_id" value="<?php echo $SelectManufactureDevice[$x]['itgc_id']; ?>">
			  <td><?php echo $SelectManufactureDevice[$x]['PendingDays']; ?></td> 
            </tr>
            <?php } ?>
          
          </tbody>
     
        </table>

              <td colspan="11"><input type="submit"  name="submit" id="submit" class="btn btn-default table-btn-submit"  value="Recieved"></td>
  
      </div>
    </div>
    <!--onClick="bulk()" END BORDERED TABLE PORTLET--> 

</article>
      </form>
  </div>
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
		document.getElementById("immob_type"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
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
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("immob_type"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("immob_type"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
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
                    'number', 'number','number','number','number','string', 'number','string','string','string','string','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>

</html>
