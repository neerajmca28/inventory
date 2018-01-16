<?php
include('config.php');
include('device_status.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
else
{

  $data=select_Procedure("CALL SelectSimDispatch('".$_SESSION['branch_id']."')");
  $data=$data[0];
  $rowcount=count($data);
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";die();
  if (isset($_POST['submit']) && isset($_POST['rowVal'])) 
  {
    $deviceremark = $_POST['remark'];
     //print_r($_POST); die;
    for ($i = 0; $i < count($_POST['rowVal']); $i++) 
    {
        $checkBox=explode('##',$_POST['rowVal'][$i]);
        $remark=$deviceremark[$checkBox[1]]; //Correct
        //$checkBox[0]."<br>"; //Correct
         //echo $deviceremark = $_POST['remark'][$i];
         $status=$Sim_Reassign;
       // $data1=select_Procedure("CALL UpdateSimRecd('".$checkBox[0]."','".$deviceremark[$checkBox[1]]."','".$status."')");
        $data1=select_Procedure("CALL UpdateSimRecd('".$checkBox[0]."','".$remark."','".$status."')");
       // if($data1) { header("Location:assignsiminstaller.php"); }
       ?><script><?php echo("location.href = '".__SITE_URL."/assignsiminstaller.php';");?></script><?php
    }
  }  
}
?>  
<head>
</head>
<body>
<article>
  <div class="col-12"> 
      <form method="post">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Recieved SIM </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover" id="filtertable">
      
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Sim ID </th>
              <th> Sim NO </th>
              <th> Phone No </th>
              <th> Dispatch Date </th>
              <th> Operator </th>
              <th> Dispatch Remarks </th>
              <th> Recd Remark </th>
            </tr>
          </thead>
          <tbody>
            <?php 
                for($i=0;$i<count($data);$i++){
          //$y=$i+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['sim_id']; ?>##<?php echo $i; ?>" onclick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
              <td><?php echo $data[$i]['sim_id']; ?></td>
              <td><?php echo $data[$i]['sim_no']; ?></td>
              <td><?php echo $data[$i]['phone_no']; ?></td>
              <td><?php echo $data[$i]['rec_date']; ?></td>
              <td><?php echo $data[$i]['operator']; ?></td>
              <td><?php echo $data[$i]['Dispatch_Remarks']; ?></td>
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $i; ?>" name="remark[]" disabled></textarea> 
              </td>
              <input type="hidden" name="sim_id" value="<?php echo $data[$i]['sim_id']; ?>">
            </tr>
            <?php } ?>
          <!--  <tr>
              <td colspan="11"><input type="submit" name="submit" value="Received"></td>
            </tr>-->
          </tbody>
  
        </table>
    <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Received"></td>
      </div>
    </div>
     </form>
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