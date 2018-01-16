<?php
include('config.php');
include("device_status.php");
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if (isset($_SESSION['branch_id']) && isset($_SESSION['user_name_inv']) && isset($_SESSION['userId_inv'])) {

  $data=select_Procedure("CALL RemovedeviceforRDrecieve()");
  $data=$data[0];

  if (isset($_POST['deviceid']) && isset($_POST['dremovedate']) && isset($_POST['rowVal'])) {

    $rowCount=$_POST['rowVal'];
    $deviceId = $_POST['deviceid'];
    $deviceRemoveDate = $_POST['dremovedate'];
    $deviceStatus = $SendToRepairCentre;
    $branchId = $_SESSION['branch_id'];

    for ($i = 0; $i < count($rowCount); $i++) {

      $checkeddata=explode('##',$_POST['rowVal'][$i]);
     // echo $checkeddata[1];  die();
     // echo "CALL M_UpdateDispathRepairDevice('".$checkeddata[0]."','".$checkeddata[1]."','".$deviceStatus."','".$branchId."')"; die;
      $data1=select_Procedure("CALL M_UpdateDispathRepairDevice('".$checkeddata[0]."','".$checkeddata[1]."','".$deviceStatus."','".$branchId."')");
      //$data1=$data1[0];

      //echo "<pre>";
      //print_r($data1);
      //echo "</pre>";die();
      header("Location:repairdevice.php");
      
    }
  }   
} 
?>

</head>
<body>
  
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Removed device for RD recive </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
          <form method="post" >
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> ITGC ID </th>
              <th> IMEI </th>
              <th> Veh No. </th>
              <th> Cleint Name </th>
              <th> RecdDate </th>
              <th> Device Removed Problem </th>
              <th> Send To R&D Date </th>
              <th> Stock Received Date </th>
              <th> Stock Received Days </th>
              <th> Remove Date </th>
              <th> Remove Days </th>
            </tr>
          </thead>
          <tbody>
            <?php 
                for($i=0;$i<count($data);$i++){
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['device_id'];?>##<?php echo $data[$i]['device_removed_date'];?>" onClick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
              <td><?php echo $data[$i]['itgc_id']; ?></td>
              <td><?php echo $data[$i]['device_imei']; ?></td>
              <td><?php echo $data[$i]['veh_no']; ?></td>
              <td><?php echo $data[$i]['client_name']; ?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($data[$i]['recd_date'])); ?></td>
              <td><?php echo $data[$i]['device_removed_problem']; ?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($data[$i]['SendToRepairCenter'])); ?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($data[$i]['SendToRepairCenter'])); ?></td>
              <td><?php echo $data[$i]['StockRcDays']; ?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($data[$i]['device_removed_date'])); ?></td>
              <td><?php echo $data[$i]['ReceivedDays']; ?></td>
              <input type="hidden" name="deviceid[]" value="<?php echo $data[$i]['device_id']; ?>">
              <input type="hidden" name="dremovedate[]" value="<?php echo $data[$i]['device_removed_date']; ?>">
            </tr>
            <?php } ?>
            <tr>
              <td colspan="13"><input type="submit" name="submit" class="btn btn-default table-btn-submit" value="Received"></td>
            </tr>
          </tbody>
          </form> 
        </table>
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
            types: ['number','number','number','string','string','number','string','number','number','number','number','number']
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>