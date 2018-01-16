<?php
include('config.php');
include('include/header.php');
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if (isset($_SESSION['userId_inv']) &&  !empty($_SESSION['userId_inv'])) {
  $data=select_Procedure("CALL SelectCrackedDevice()");
  $data=$data[0];
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";die();
    
}

if (isset($_POST['submit']) && isset($_POST['rowVal']))
	{

		$deviceremark = $_POST['remark'];
		$deviceStatus = $UnCrackedDevice;
		
		for ($i = 0; $i < count($_POST['rowVal']); $i++) 
		{
		  
			  $checkBox=explode('##',$_POST['rowVal'][$i]);
			  
			   //echo $checkBox[$i]."<br>";
			   //echo $deviceremark[$checkBox[$i+1]]."<br>";
			   // echo $deviceStatus."<br>";
			  
				$data1=select_Procedure("CALL UpdateUnCrackedDevices('".$checkBox[0]."','".$deviceStatus."','".$deviceremark[$checkBox[$i+1]]."')");
			
		}
			// header("Location:crackeddevice.php");
			{
			?><script><?php echo("location.href = '".__SITE_URL."/crackeddevice.php';");?></script><?php
}
  }
?>  

  
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Cracked Devices </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
          <form method="post">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Serial No. </th>
              <th> ITGC ID </th>
              <th> IMEI </th>
              <th> Remarks </th>
              <th> Cleint Name </th>
              <th> Veh No. </th>
              <th> RecdDate </th>
              <th> DeviceModelName </th>
              <th> PendingDays </th>
            </tr>
          </thead>
          <tbody>
            <?php 
                for($i=0;$i<count($data);$i++){
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['device_id']; ?>##<?php echo $i; ?>" onClick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
              <td><?php echo $i+1; ?></td>
              <td><?php echo $data[$i]['itgc_id']; ?></td>
              <td><?php echo $data[$i]['device_imei']; ?></td>
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $i; ?>" name="remark[]"></textarea> 
              </td>
              <td><?php echo $data[$i]['client_name']; ?></td>
              <td><?php echo $data[$i]['device_id']; ?></td>
              <td><?php echo date("d-m-Y H:i:s",strtotime($data[$i]['recd_date'])); ?></td>
              <td><?php echo $data[$i]['item_name']; ?></td>
              <td><?php echo $data[$i]['PendingDays']; ?></td>
            </tr>
            <?php } ?>
            
          </tbody>
        </table>
        <input type="submit" name="submit" class="btn btn-default table-btn-submit" id="submit" value="NOT ABLE TO CRACK">
      </form>
      </div>
    </div>
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
  function checkAllId(){
    var i;
    var row = document.getElementById("checkAll")
    for(i=1;i<=<?php echo $rowcount; ?>;i++){
      
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
  }    
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