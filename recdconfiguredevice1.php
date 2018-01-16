<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

$masterObj = new master();

if($_SESSION['user_name_inv']!='aditya')
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}

  $tt=select_Procedure("CALL SelectItgcId()");
  $tt=$tt[0];
  //echo count($tt);
  //echo "<pre>"; print_r($tt);echo "</pre>";die();
  
  if (isset($_POST['rowVal']))
  {    
    for ($i = 0; $i < count($_POST['rowVal']); $i++) 
    {
        $checkBox=explode('##',$_POST['rowVal'][$i]);
        //echo $checkBox[0];
	 $dev_id=$checkBox[0];
        $data=select_Procedure("CALL SelectItgcId3('".dev_id."')");      
        
        //mysql_query("UPDATE device SET device_status=21 WHERE device_id='".$checkBox[0]."'");
    }
    
    ?><script><?php echo("location.href = '".__SITE_URL."/configuredevice.php';");?></script><?php
      
  
  }

?>  
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Recd Configure Device</div>
         </div>
         <div class="portlet-body">
           <table class="table table-bordered table-hover" id="filtertable">
             <form method="post" id="myFormID">
             <thead>
               <tr>
                 <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
                 <th> Received Date </th>
                 <th> Device Type </th>
                 <th> ITGC ID </th>
                 <th> Device SNo </th>
                 <th> Pending Days </th>
               </tr>
             </thead>
             <tbody>
              <?php 
                for($i=0;$i<count($tt);$i++){
              ?>
               <tr>
                 <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $tt[$i]['device_id']; ?>##<?php echo $i; ?>" onClick="setRow('<?php echo $i; ?>');" class="cb-element"></td>
                 <td><?php echo date('d-m-Y H:i:s',strtotime($tt[$i]['recd_date'])); ?></td>
                 <td><?php echo $tt[$i]['item_name']; ?></td>
                 <td><?php echo $tt[$i]['itgc_id']; ?></td>
                 <td><?php echo $tt[$i]['device_sno']; ?><input type="hidden" name="device[]" value="<?php echo $tt[$i]['device_id'];?>"></td>
                 <td><?php echo $tt[$i]['PendingDays']; ?></td>
               </tr>
               <?php
                }
               ?> 
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
           <!-- <input type="submit" name="submit" id="submit" value="RECEIVED"> -->
           </form> 
         </div>
       </div>
       <!-- END BORDERED TABLE PORTLET--> 
     </div>
   </article>
</body>
<script type="text/javascript">
  $('.checkbox1').on('change', function() {
    var bool = $('.checkbox1:checked').length === $('.checkbox1').length;
    $('#checkAll').prop('checked', bool);
  });

  $('#checkAll').on('change', function() {
    $('.checkbox1').prop('checked', this.checked);
  });

  $('#sub').click(function(e){
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
            types: ['number', 'number','string','number','number','number']
        }]
    };
    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</html>
