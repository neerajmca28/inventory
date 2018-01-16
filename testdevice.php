<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php");
  
$masterobj=new master();
if($_SESSION['user_name_inv']!='aditya')
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if (isset($_SESSION['userId_inv']) &&  !empty($_SESSION['userId_inv'])) 
{
  $data=select_Procedure("CALL SelectTempraryAttachedDevice()");
  $data=$data[0];
 
  for($i=0;$i<count($data);$i++){
  $veh_reg="UP16CT3558";
	$testDevice=db__select_matrix("SELECT GREATEST(temp.radius,temp.distance) as radius FROM ( SELECT 500 AS radius ,gps_time,gps_longitude,gps_latitude,(3959 * ACOS( COS( RADIANS(28.635339737) ) * COS( RADIANS( gps_latitude ) ) * COS( RADIANS( gps_longitude ) - RADIANS(77.139625549) ) + SIN( RADIANS(28.635339737) ) * SIN( RADIANS( gps_latitude ) ) ) )*1000 AS distance FROM matrix.latest_telemetry WHERE ADDDATE(latest_telemetry.gps_time,INTERVAL 19800 SECOND)>=ADDDATE(NOW(),INTERVAL -60 minute) and  sys_service_id IN (SELECT id FROM matrix.services WHERE veh_reg='".$veh_reg."'))temp");
	
	$radius[]=$testDevice[0]['radius'];
	
  }	

	if (isset($_POST['rowVal']))
    {
		for ($i = 0; $i < count($_POST['rowVal']); $i++) 
		{	
			$checkBox=explode('##',$_POST['rowVal'][$i]);
			$devicestatus = $Tested;
			$attachSim=select_Procedure("CALL SetTested('".$checkBox[0]."','".$devicestatus."')");
		}
		{
			?><script><?php echo("location.href = '".__SITE_URL."/attachsim.php';");?></script><?php
		}
   }
}
?>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Test Device </div>
      </div>
      <div class="portlet-body fix-table">
        <?php 

        if(count($radius) > 0) { 

        ?>
        <table class="table table-bordered table-hover" id="filtertable">
          <form action="" method="post" id="myFormID"> 
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> ITGC ID </th>
              <th> Device Serial No </th>
              <th> IMEI </th>
            </tr>
          </thead>
          <tbody>
            <?php 
              for($i=0;$i<count($data);$i++){
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['device_sno']; ?>##<?php echo $i; ?>" onClick="setRow('<?php echo $i; ?>');" class="cb-element"></td>
              <!-- <td><input type="checkbox" id="rowValid" name="myFieldName[]" value="<?php //echo $data[$i]['device_id']; ?>##<?php //echo $i; ?>" onClick="setRow('<?php //echo $i; ?>');" class="cb-element"></td> -->
              <td><?php echo $data[$i]['itgc_id']; ?></td>
              <td><?php echo $data[$i]['device_sno']; ?></td>
              <td><?php echo $data[$i]['device_imei']; ?></td>
            </tr>
            <input type="hidden" value="<?php echo $data[$i]['device_sno']; ?>" id="hideDeviceSno">
            <input type="hidden" value="<?php echo $data[$i]['device_imei']; ?>" id="hidestrIMEI">
            <?php } ?>
          </tbody>         
        </table>
         <a href="javascript:void(0);" class="btn btn-default table-btn-submit" onclick="testedSubmit()" id="finalSubmit" value="">TESTED</a>
        <?php } else { echo '<p style="color:blue;margin-left:9px;margin-top:10px;"><b>There is no Configured Device available for Testing</b></p>'; }?>
      </div>
     </form>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  <?php
  
	for($i=0;$i<count($radius);$i++){	
	
	   if (ceil($radius[$i])<=500)
	   {
		
			echo '
			  <script type="text/javascript">
				
					document.getElementById("check"+"'.$i.'").disabled = true;
				
			  </script>
			';
				 
	   }
	   else
		{
		   echo '
			  <script type="text/javascript">
			  
				document.getElementById("check"+"'.$i.'").disabled = false;
			  
			  </script>
			';
		}
	}	
  ?>
</article>
<script>
  $('.checkbox1').on('change', function() {
    var bool = $('.checkbox1:checked').length === $('.checkbox1').length;
    $('#checkAll').prop('checked', bool);
  });

  $('#checkAll').on('change', function() {
    $('.checkbox1').prop('checked', this.checked);
  });
</script>
<script type="text/javascript">
   
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
   
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("con"+rowId).disabled = false;
      document.getElementById("imm"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("con"+rowId).disabled = true;
      document.getElementById("imm"+rowId).disabled = true;
    }
  }

  function testedSubmit(){

    // var deviceSno=document.getElementById("hideDeviceSno").value;
    // var deviceIMEI=document.getElementById("hidestrIMEI").value;

    // var value = $('input:checkbox[class=cb-element]');
    // //alert(value)
    //   if(value.is(':checked')){
    //     //var dataString = $("#filters_form").serialize();
    //     var datastring = 'device_sno='+deviceSno+'&device_imei='+deviceIMEI;
    //   alert(datastring)

     //  $.ajax({
     //    url:"process_testdevice.php", //the page containing php script
     //    type: "POST", //request type
     //    data: datastring,
     //    success:function(result){
     //     //alert(result);
     //     //document.getElementById("simno").disabled = true;
     //     //location.reload();
     //     document.location.href = 'attachsim.php';
     //   }
     // });
      // }
      // else {
      //   alert("Please Select CheckBox")
      // }

    //if($('#rowValid').prop('checked')) {

   
  }

  $('#finalSubmit').click(function(e){
      var value = $('input:checkbox[class=cb-element]');
      if(value.is(':checked')){
        $("#myFormID").submit();
      }
      else {
        alert("Please Select CheckBox")
      }
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
            types: ['number','number','number','string','string','number','string','number','number']
        }]
    };
    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>