<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
  $errMsg="";

  $data=select_Procedure("CALL SelectItgcId()");
  $data=$data[0];

	if(isset($_POST['submit']))
    {
      $imei_array = $_POST['imei']; 
     //print_r($imei_array); die;
      $device_array = $_POST['device'];
	  for ($i = 0; $i < count($imei_array); $i++)
    {
		  if(!empty($imei_array[$i]))
		  {
			  if(!preg_match ("/^([0-9]+)$/", $imei_array[$i]))
				 {
					 $flag=1;
					 break;
				 }
		  }
	  }
	  if($flag==1)
	  {
		  $errMsg="<b>* Please Enter Only Numbers</b>";
	  }
    for ($i = 0; $i < count($imei_array); $i++)
    {
  	  if($errMsg=="" && !empty($imei_array[$i]))
  	  {
  		    for ($i = 0; $i < count($imei_array); $i++)
  			{
  				if(!empty($imei_array[$i]))
  				// echo "CALL InsertImei('".$device_array[$i]."','".$imei_array[$i]."')"; die;
  				$data=select_Procedure("CALL InsertImei('".$device_array[$i]."','".$imei_array[$i]."')");
  				if ($data) 
  				{
  					 ?><script><?php echo("location.href = '".__SITE_URL."/attachsimtemp.php';");?></script><?php
  				}
  			} 	 
  	  }
    }  
  }
?>
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Configure Device</div>
         </div>
         <div class="portlet-body">
          <div style="color:red"><?php if(isset($errMsg)) { echo $errMsg; }?></div>
           <table class="table table-bordered table-hover" id="filtertable">
             <form method="post">
             <thead>
               <tr>
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
                for($i=0;$i<count($data);$i++){
              ?>
               <tr>
                 <td><?php echo $i+1; ?></td>
                 <td><?php echo date('d-m-Y H:i:s',strtotime($data[$i]['recd_date'])); ?></td>
                 <td><?php echo $data[$i]['item_name']; ?></td>
                 <td><?php echo $data[$i]['itgc_id']; ?></td>
                 <td>
                  <input pattern=".{6,18}" class="form-control input-normal" type="text" name="imei[]" title="Input 6 to 18 Digits Only" id="imei">
                  <input type="hidden" name="itgc[]" value="<?php echo $data[$i]['itgc_id'];?>">
                  <input type="hidden" name="device[]" value="<?php echo $data[$i]['device_id'];?>">
                 </td>
                 <td><?php echo $data[$i]['PendingDays']; ?></td>
               </tr>
               <?php
                }
               ?> 
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