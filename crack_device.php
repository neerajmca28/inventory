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
  // $data=select_Procedure("CALL SelectCrackedDevice()");
  // $data=$data[0];
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";die();
 $branch_id= $_SESSION['branch_id'];
  // $data=db__select_staging("SELECT * FROM internalsoftware.services where branch_id='".$branch_id."' and service_reinstall='crack' and service_status=202 and parent_service_id!='' ");
  $data=db__select_staging("SELECT * FROM internalsoftware.services where branch_id='".$branch_id."' and service_reinstall='crack' and service_status=202");

  //$device_imei=$data[0]['device_imei'];

  //$data =db__select_staging("select * from internalsoftware.installation where installation_status='2' ");
   //echo '<pre>'; print_r($data); die;
    $request_type='crack';
}

if (isset($_POST['submit']) && isset($_POST['rowVal']))
	{

		for ($i = 0; $i < count($_POST['rowVal']); $i++) 
		{
			  $checkBox=explode('##',$_POST['rowVal'][$i]);

        // $service_id=$checkBox[0];
        // $device_imei=$checkBox[1];
        // $crack_req_id= $checkBox[2];
        // $form_data = array('service_reinstall' => 5 );
        // $tt= update_query('internalsoftware.services',$form_data,$service_id); 
        // $tt1= update_query('internalsoftware.services_crack',$form_data,$crack_req_id);
			   //$data1=db__select_staging("UPDATE internalsoftware.installation set installation_status='2  ' where  inst_req_id='".$inst_req_id."' ");
        // echo "Location:addDevice_crack.php?device_imei=$device_imei&service_id=$service_id&crack_req_id=$crack_req_id";die;
        // header("Location:addDevice_crack.php?device_imei=$device_imei&service_id=$service_id&crack_req_id=$crack_req_id");
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
          <form method="post" action="addDevice_crack.php">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Request Date </th>
              <th> Client Name </th>
              <th> Vehicle No. </th>
              <th> Location </th>
            
            </tr>
          </thead>
          <tbody>
            <?php 
                for($i=0;$i<count($data);$i++){
            ?>
            <tr>

              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['id']; ?>##<?php echo $data[$i]['device_imei']; ?>##<?php echo $data[$i]['crack_req_id']; ?>" onClick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
              
                <td><?php echo $data[$i]['req_date']; ?></td>
        <td><?php echo $data[$i]['name']; ?></td>
  
        <td><?php echo $data[$i]['veh_reg']; ?></td>
         <td><?php echo $data[$i]['inst_cur_location']; ?></td>

    
             
            </tr>
            <?php } ?>
         <!--         <input type="hidden" name="device_imei" value="<?php echo $data[$i]['device_imei']; ?>" > -->
          </tbody>
        </table>
        <input type="submit" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Add Device">
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
            types: ['number','number','string','string','string']
        }]
    };
    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>