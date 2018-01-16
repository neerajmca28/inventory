<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if($_SESSION['user_name_inv']!='aditya')
{
?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
 $errMsg="";

   $dataReceivedConfig=select_Procedure("CALL SelectItgcId2()");
   $dataReceivedConfig=$dataReceivedConfig[0];
   $rowcount=count($dataReceivedConfig);

?>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<form name="dispatch_device" id="dispatch_device" method="post" action="" onSubmit="return dispatchDevice();">
  <article>
    <div class="col-12">
      <!-- BEGIN BORDERED TABLE PORTLET-->
      <div class="portlet box yellow">
        <div class="portlet-title">
          <div class="caption"> <i class="fa fa"></i>Configure Device</div>
        </div>
        <div class="portlet-body">
          <table class="table table-bordered table-hover" id="filtertable">

            <thead>
              <tr>
               <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
                <th> Serial No.</th>
                <th> RecdDate </th>
                <th> Device Type </th>
                <th> ITGC ID </th>
                <th> IMEI</th>
                <th> PendingDays </th>
              </tr>
            </thead>
            <tbody>
             <?php
               for($i=0;$i<$rowcount;$i++){
         $y=$i+1;
             ?>
              <tr>

               <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $dataReceivedConfig[$i]['device_id'];?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>

               <!-- <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectRecdDispatchedDevices[$x]['device_id'];?>##<?php echo $SelectRecdDispatchedDevices[$x]['itgc_id'];?>##<?php echo $SelectRecdDispatchedDevices[$x]['device_imei']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchAntennaCount']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchImmobilizerType'];?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchImmobilizerCount']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['DispatchConnectorCount']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['device_type']; ?>##<?php echo $SelectRecdDispatchedDevices[$x]['device_status']; ?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>  -->
                <td><?php echo $y; ?></td>
                <td><?php echo date('d-m-Y H:i:s',strtotime($dataReceivedConfig[$i]['RecdConfigureToConfigure'])); ?></td>
                <td><?php echo $dataReceivedConfig[$i]['item_name']; ?></td>
                <td><?php echo $dataReceivedConfig[$i]['itgc_id']; ?></td>
                <td>
				          <?php
                   if($dataReceivedConfig[$i]['parent_id'] === 79){
                     $pointer = explode("X", $dataReceivedConfig[$i]['itgc_id']);
                   }
                 ?>
                 <input class="form-control input-normal" type="text" name="imei[]"  title="Input only Number" value="<?php echo $pointer['1']; ?>" maxlength="18" id="imei<?php echo $y;?>" disabled>
                 <input type="hidden" name="device[]" value="<?php echo $dataReceivedConfig[$i]['device_id'];?>">
                </td>
                <td><?php echo $dataReceivedConfig[$i]['PendingDays']; ?></td>
              </tr>
              <?php
               }
              ?>
              <tr>
                <td>&#160;</td>
                <td>&#160;</td>
                <td>&#160;</td>
                <td>&#160;</td>
                <td>
                <td>&#160;</td>
              </tr>
            </tbody>

          </table>
          <input type="submit" name="submit" class="btn btn-default table-btn-submit" id="submit" value="ADD">
          </form>
        </div>
      </div>
      <!-- END BORDERED TABLE PORTLET-->
    </div>
  </article>
</body>
<form>
<script type="text/javascript">
 var $form = jQuery.noConflict();
 $form(document).ready(function () {
   $form('#submit').click(function (){

   var checked = []

   $form("input[name='rowVal[]']:checked").each(function (){
       checked.push(parseInt($form(this).val()));
   });

   if(checked.length == 0)
   {
     alert("Please Select CheckBox IMEI Configured")}
   else{
       $form.ajax({
       type:"GET",
       url:"userInfo.php?action=configure_device",
       data: $form('#dispatch_device').serialize(),
       //data:'no_of_device='+ no_of_device + '&parents_id=' + parent_id + '&model_type=' + model_type,
       success:function(msg)
       {
         alert(msg);
         var data = $form.trim(msg);
         if(data == "IMEI Mapping Successfully")
         {
            document.location.href = 'attachsimtemp.php';
         }

       }


     });
   }
   return false;

   });
 });

 var $assign = jQuery.noConflict()
 $assign('.checkbox1').on('change', function() {
   var bool = $assign('.checkbox1:checked').length === $assign('.checkbox1').length;
   $assign('#checkAll').prop('checked', bool);
 });

 $assign('#checkAll').on('change', function() {
   $assign('.checkbox1').prop('checked', this.checked);
 });

 function checkAllId(){
   var i;
   var row = document.getElementById("checkAll")
   for(i=1;i<=<?php echo $rowcount; ?>;i++){

     if(row.checked){
       document.getElementById("imei"+i).disabled = false;

       }
     else
     {
       document.getElementById("imei"+i).disabled = true;

     }
   }
 }
 function setRow(rowId){
   var row = document.getElementById("check"+rowId)
   if(row.checked){
     document.getElementById("imei"+rowId).disabled = false;

   }else{
     document.getElementById("imei"+rowId).disabled = true;

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
           types: ['number', 'number','string','number','number','number']
       }]
   };
   var tf = new TableFilter('filtertable', filtersConfig);
   tf.init();
</script>
</html>