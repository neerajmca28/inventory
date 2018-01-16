<?php
include('config.php');
include('include/header.php');
include('device_status.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');


if (isset($_SESSION['branch_id']) &&  isset($_SESSION['userId_inv'])) 
{
  
  $data=select_Procedure("CALL SelectDispatchedDevice('".$_SESSION['branch_id']."')");
  $data=$data[0];
  /*  echo "<pre>";
   print_r($data);die(); */

  
  if (isset($_POST['submit']) && isset($_POST['rowVal']))
  {

		for ($i = 0; $i < count($_POST['rowVal']); $i++) 
		{

				$checkBox=explode('##',$_POST['rowVal'][$i]);
				$date=date('Y-m-d H:i:s');
			  // echo $deviceremark[$checkeddata[1]]."<br>";
			  // echo $deviceStatus."<br>";
			  
				$data1=select_Procedure("CALL CancelDeviceOrderByBranch('".$checkBox[1]."','".$date."','1','".$FinalAttachSim."')");
			   //echo $data1; die;
				if($data1) 
				{ 
					?><script><?php echo("location.href = '".__SITE_URL."/cancelorder.php';");?></script><?php
				}
				 
			}
   }
}
?>  
<article>
  <div class="col-12">
     <div class="color-sign">
      <div class="cl-item"><span class="lightblue"></span><span>Light Blue :</span><span>Repaired Device</span></div>
      <div class="cl-item"><span class="white"></span><span>White  :</span><span>New Device</span></div>
  </div>
         <form method="post">
  <!-- BEGIN BORDERED TABLE PORTLET-->
  <div class="portlet box yellow">
    <div class="portlet-title">
      <div class="caption"> <i class="fa fa"></i> Cancel Device Order </div>
    </div>
    <div class="portlet-body">

      <table class="table table-bordered table-hover" id="filtertable1">
 
        <thead>
          <tr>
            <th ><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
            <th> ITGC ID </th>
            <th> IMEI </th>
          </tr>
        </thead>
        <tbody>
          <?php 
              for($i=0;$i<count($data);$i++){
				$repaired=$deviceData[$x]['is_repaired'];
				 if($repaired==1)
				 {
					$color="#7acde9";
					$tool_tip="repaired";
                 }
				 else
				 {
					 $color="#FFFFFF";
					$tool_tip="new device";
				 }
          ?>
          <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
            <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $i; ?>##<?php echo $data[$i]['device_id']; ?>" onclick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
            <td><?php echo $data[$i]['itgc_id']; ?></td>
            <td><?php echo $data[$i]['device_imei']; ?></td>
          </tr>
          <?php } ?>
          <tr>
           <!-- <td colspan="11"><input type="submit" name="submit" value="Cancel Order"></td>-->
          </tr>
        </tbody>
    
      </table>
	  <input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Cancel">
    </div>
  </div>
      </form> 
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
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
  /* function checkAllId(){
    var i;
    var row = document.getElementById("checkAll");
    for(i=1;i<=<?php echo count($data); ?>;i++){
      
      if(row.checked){
        document.getElementById("remark"+i).disabled = false;
        document.getElementById("con"+i).disabled = false;
        document.getElementById("imm"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
        document.getElementById("con"+i).disabled = true;
        document.getElementById("imm"+i).disabled = true;
      }
    }  
  } */    
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
            types: ['number','number','number']
        }]
    };

    var tf = new TableFilter('filtertable1', filtersConfig);
    tf.init();
</script>
</body>
</html>