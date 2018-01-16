<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

if(isset($_SESSION['user_name_inv']) && isset($_SESSION['branch_id']) && isset($_SESSION['userId_inv']) && !empty($_SESSION['user_name_inv']) &&  !empty($_SESSION['userId_inv']))
{
  $branchid = $_SESSION['branch_id'];
  $data=select_Procedure("CALL SelectRemovedRecdDevice('".$branchid."')");
  $data=$data[0];
}

if(!empty($_POST['imei']) && !empty($_POST['device'])){
  if(isset($_POST['submit'])){
    $imei_array = $_POST['imei'];
    $device_array = $_POST['device'];
    for ($i = 0; $i < count($imei_array); $i++) {
      $data=select_Procedure("CALL InsertImei('".$device_array[$i]."','".$imei_array[$i]."')");

    } 
  }
}  

?>

<head>

   <style type="text/css">
   th{
    text-align: center;
   }
   .case{
    text-align: center;
    text-decoration: none;
   }   
   .lnkdisabled{
    pointer-events: none;
   }
   .lnkenabled{
    pointer-events: default;
    text-decoration: underline;
   }
</style>

</head>
<body>
  <div class="color-sign">
      <div class="cl-item"><span class="lightgreen"></span><span>CASE IS ALREADY OPENED</span></div>
      <div class="cl-item"><span class="brown"></span><span>Device Has Gone to Manufacture</span></div>
      <div class="cl-item"><span class="silver"></span><span>Device Imei has been Changed pending at Stock</span></div>
      <div class="cl-item"><span class="pink"></span><span>Device Has Gone to Internal Manufacture</span></div>
     <div class="cl-item"><span class="yellow"></span><span>New Device Not Open Yet</span></div>
  </div>
   <article>
     <div class="col-25"> 
	  
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Repair Device</div>
         </div>

         <div class="portlet-body fix-table">
           <table class="table table-bordered" id="filtertable">
             <thead>
               <tr>
                 <th> S No. </th>
                 <th> Device<br>Sno </th>
                 <th> ITGC Id </th>
                 <th> IMEI </th>
                 <th> DeviceSend<br>ToRepair </th>
                 <th> Device Remove Remarks </th>
                 <th> Stock Remarks </th>
                 <th> Manufacture<br>RecdDate </th>
                 <th> Internal<br>Manufacuture </th>
                 <th> Pending<br>Days </th>
                 <th> Client<br>Name </th>
                 <th> Device<br>Model </th>
                 <th> Open<br>Case </th>
                 <th> Close<br>Case </th>
               </tr>
             </thead>
             <tbody>
                <?php 
                for($i=0;$i<count($data);$i++){
                  $col=$data[$i]['device_status'];

                  if($col==84){
                    $color="#ffb380";
                  }
                  if($col==68){
                    $color="#90EE90";
                  }
                  if($col==86){
                    $color="#c2c2a3";
                  }
                  if($col==109){
                    $color="#fff";
                  }
                  if($col==79){
                    $color="#ffff00";
                  }
                ?>
                <tr bgcolor="<?php echo $color; ?>">
	                <td><?php echo $i+1; ?></td>
	                <td><?php echo $data[$i]['device_sno']; ?></td>
                    <td><?php echo $data[$i]['itgc_id']; ?></td>
                    <td><?php echo $data[$i]['device_imei']; ?></td>
                    <td>
						<?php 
						  $dt = date('d-m-Y H:i:s',strtotime($data[$i]['SendToRepairCenter']));

						  if($dt == '01-01-1970 05:30:00'){
							$dt = '';
						  } 
						  else {
							echo $dt;
						  }						
						?>
                    </td>
                    <td><?php echo $data[$i]['device_removed_problem']; ?></td>
                    <td><?php echo $data[$i]['RecdManufactureRemarkToRepair']; ?></td>
                  
                    <td>
						<?php 
						  $dt = date('d-m-Y h:i:s',strtotime($data[$i]['ManufactureRecdDate']));

						  if($dt == '01-01-1970 05:30:00'){
							$dt = '';
						  } 
						  else {
							echo $dt;
						  }
						
						?>
                    </td>
                    <td><?php echo $data[$i]['Internal_Manufacuture']; ?></td>
                    <td><?php echo $data[$i]['PendingDays']; ?></td>
                    <td><?php echo $data[$i]['client_name']; ?></td>
                    <td><?php echo $data[$i]['item_name']; ?></td>
                    <td>
                    <a href="OpenRepairedCase.php?deviceid=<?php echo $data[$i]['device_id']; ?>" id="openid" 
                    <?php if($col==84){ ?> class="lnkdisabled" <?php } if($col==86) {?> class="lnkdisabled" <?php } if($col==109) {?> class="lnkdisabled" <?php } if($col==79) {?> class="lnkenabled" <?php } if($col==68) {?> class="lnkdisabled" <?php }?>  onclick="openlink(o<?php echo $data[$i]['device_id']; ?>_<?php echo $data[$i]['device_status']; ?>,c<?php echo $data[$i]['device_id']; ?>_<?php echo $data[$i]['device_status']; ?>)" value="<?php echo $data[$i]['device_id']; ?>_<?php echo $data[$i]['device_status']; ?>" ><font color="#000">Open case</font></a>
                  </td>
                  <td>
                    <a href="CloseRepairedCase.php?deviceid=<?php echo $data[$i]['device_id']; ?>" id="closeid" 
                    <?php if($col==84){ ?> class="lnkdisabled" <?php } if($col==86) {?> class="lnkdisabled" <?php } if($col==109) {?> class="lnkenabled"  <?php } if($col==79) {?> class="lnkdisabled" <?php } if($col==68) {?> class="lnkenabled" title="This case is already opened"<?php }?>   onclick="closelink(o<?php echo $data[$i]['device_id']; ?>_<?php echo $data[$i]['device_status']; ?>,c<?php echo $data[$i]['device_id']; ?>_<?php echo $data[$i]['device_status']; ?>)" value="<?php echo $data[$i]['device_id']; ?>_<?php echo $data[$i]['device_status']; ?>" ><font color="#000">Close case</font></a></td>
                </tr>
                <?php              	
             		} 
           	    ?>
             </tbody>
           </table>
   		  </div>
       </div>
       <!-- END BORDERED TABLE PORTLET--> 
     </div>
   </article>
   <script type="text/javascript">

    $(document).ready(function() {
      $("a.openid").click(function(){
         var status_id = $("a").val();
         alert(status_id); 
         return false;
      });
    });

      function enable(rowId){
          var sim=document.getElementById("attbtn"+rowId).onclick;
          if(sim){
            document.getElementById("simno").disabled = false;
          }
          else{
            document.getElementById("simno").disabled = true;
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
            types: ['number','number','number','number','number','number','string','string','number','number','number','string','string',]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>
</body>
</html>