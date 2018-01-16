<?php
include('config.php');
include('device_status.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if (isset($_SESSION['branch_id']) &&  !empty($_SESSION['userId_inv'])) {
  $data=select_Procedure("CALL SelectRecdDeadDevice('".$_SESSION['branch_id']."')");
  $data=$data[0];
  $rowcount=count($data);
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";die();
  if (isset($_POST['submit']) && isset($_POST['rowVal'])) {

    $deviceremark = $_POST['remark'];
   
    for ($i = 0; $i < count($_POST['rowVal']); $i++) {
      
      $checkBox=explode('##',$_POST['rowVal'][$i]);
	//  echo $checkBox[0]; die;
      $dispatchdate = date("Y-m-d h:i:s");
      // echo $deviceremark[$checkBox[1]]."<br>"; //Correct
      //print_r($checkBox[0]); //Correct
    //  echo $deviceremark[$i]; die;
	   $remarkss=$deviceremark[$i];
       $data1=select_Procedure("CALL UpdateDispathRecdDevice_dead('".$remarkss."','".$dispatchdate."','".$AssignDeadDevice."','".$checkBox[0]."','".$_SESSION['branch_id']."')");
       if($data1) 
	   {
			?><script><?php echo("location.href = '".__SITE_URL."/assigndeaddevices.php';");?></script><?php
	   }
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
        <div class="caption"> <i class="fa fa"></i> Recieved SIM </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover" id="filtertable">
          <form method="post">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> ITGC ID </th>
              <th> IMEI </th>
              <th> Dispatched Date </th>
              <th> Dispatched Remarks </th>
              <th> Remarks </th>
              <th> Send Branch Name </th>
            </tr>
          </thead>
          <tbody>
            <?php 
                for($i=0;$i<count($data);$i++){
					$y=$i+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['device_id']; ?>##<?php echo $i; ?>" onclick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
              <td><?php echo $data[$i]['itgc_id']; ?></td>
              <td><?php echo $data[$i]['device_imei']; ?></td>
              <td><?php echo $data[$i]['dispatch_date']; ?></td>
              <td><?php echo $data[$i]['device_remarks']; ?></td>
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $i; ?>" name="remark[]" disabled></textarea> 
              </td>
              <td>
                <?php 
                    $state=$data[$i]['dispatch_branch'];
                    if($state == 1){
                      echo "Delhi";
                    }
                    if($state == 2){
                      echo "Mumbai";
                    }
                    if($state == 3){
                      echo "Jaipur";
                    }
                    if($state == 4){
                      echo "Sonepat";
                    }
                    if($state == 5){
                      echo "Kanpur";
                    }
                    if($state == 6){
                      echo "Ahmedabad";
                    }
                    if($state == 7){
                      echo "Kolkata";
                    }
                ?>
              </td>
              <input type="hidden" name="sim_id" value="<?php echo $data[$i]['sim_id']; ?>">
            </tr>
            <?php } ?>
         <input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Received">
          </tbody>
          </form> 
        </table>
        <td colspan="11"></td>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
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
    for(i=0;i<=<?php echo $rowcount; ?>;i++){
      
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