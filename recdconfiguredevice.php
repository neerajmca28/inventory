<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

$masterObj = new master();

if($_SESSION['user_name_inv']!='aditya')
{
?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}

 $recdConfigure=select_Procedure("CALL SelectItgcId()");
 $recdConfigure=$recdConfigure[0];

 if (count($_POST['rowVal']) > 0)
 {
   for ($i = 0; $i < count($_POST['rowVal']); $i++)
   {
     $checkBox=explode('##',$_POST['rowVal'][$i]);
     $dev_id=$checkBox[0];

     $data=select_Procedure("CALL SelectItgcId3('".$dev_id."')");
   }
   {
   ?><script><?php echo("location.href = '".__SITE_URL."/configuredevice.php';");?></script><?php
   }
 }

?>
 <article>
   <div class="col-12">
     <div class="portlet box yellow">
       <div class="portlet-title">
         <div class="caption"> <i class="fa fa"></i>Received Configure Device</div>
       </div>
       <div class="portlet-body">
         <form method="post" id="myFormID">
           <table class="table table-bordered table-hover" id="filtertable">
             <thead>
               <tr>
               <th><input type="checkbox" name="checkAll" id="checkAll" class="checkAll"></th>
               <th> SNo. </th>
               <th> Received Date </th>
               <th> Device Type </th>
               <th> ITGC ID </th>
               <th> Device SNo </th>
               <th> Pending Days </th>
               </tr>
             </thead>
             <tbody>
               <?php for($i=0;$i<count($recdConfigure);$i++){ ?>
               <tr>
                 <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $recdConfigure[$i]['device_id']; ?>##<?php echo $i; ?>"  class="checkbox1"></td>
                 <td><?php echo $i+1; ?></td>
                 <td><?php echo date('d-m-Y H:i:s',strtotime($recdConfigure[$i]['recd_date'])); ?></td>
                 <td><?php echo $recdConfigure[$i]['item_name']; ?></td>
                 <td><?php echo $recdConfigure[$i]['itgc_id']; ?></td>
                 <td><?php echo $recdConfigure[$i]['device_sno']; ?><input type="hidden" name="device[]" value="<?php echo $recdConfigure[$i]['device_id'];?>"></td>
                 <td><?php echo $recdConfigure[$i]['PendingDays']; ?></td>
                 </tr>
                 <?php } ?>
                 <tr>
                 <td>&#160;</td>
                 <td>&#160;</td>
                 <td>&#160;</td>
                 <td>&#160;</td>
                 <td>&#160;</td>
               </tr>
             </tbody>
           </table>
           <a href="javascript:void(0);" id="sub" class="btn btn-default table-btn-submit">RECEIVED</a>
         </form>
       </div>
       </div>
   </div>
 </article>
</body>
<script type="text/javascript">

 var $assign = jQuery.noConflict()

 $assign('.checkbox1').on('change', function() {
   var bool = $assign('.checkbox1:checked').length === $assign('.checkbox1').length;
   $assign('#checkAll').prop('checked', bool);
 });

 $assign('#checkAll').on('change', function() {
   $assign('.checkbox1').prop('checked', this.checked);
 });


 $assign('#sub').click(function(e){

   var value = $assign('input:checkbox[class=checkbox1]');

   if(value.is(':checked')){
     $assign("#myFormID").submit();
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
           types: ['number', 'number','string','number','number','number']
       }]
   };
   var tf = new TableFilter('filtertable', filtersConfig);
   tf.init();
</script>
</html>