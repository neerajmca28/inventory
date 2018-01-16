<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

if(isset($_SESSION['branch_id'])) {
  $data=select_Procedure("CALL SelectAssignDeviceToBranch('".$_SESSION['branch_id']."')");
  $data=$data[0];
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";
}  
?>

<head>

</head>
<body>
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Assign Device To Branch</div>
         </div>
         <div class="portlet-body fix-table">
          <div class="col-12">
           <table class="table table-bordered" id="filtertable">
             <thead>
               <tr>
                 <th> ITGC ID </th>
                 <th> IMEI </th>
                 <th> DeviceID </th>
                 <th> IsRepaired </th>
                 <th> Anntenna </th>
                 <th> Connectors </th>
                 <th> Immobilizer </th>
                 <th> IsFFC </th>
                 <th> Client Name </th>
                 <th> Veh No. </th>
                 <th> Device Remd Remarks </th>
                 <th> Remarks </th>
                 <th> IsCracked </th>
                 <th> Device Send Date </th>
                 <th> Send Branch Name </th>
               </tr>
             </thead>
             <tbody>
                <?php 
                for($i=0;$i<count($data);$i++){
                  $col=$data[$i]['Internal_Manufacuture'];

                  if($col==1){
                    $color="#BDB76B";
                  }
                  else{
                    $color="#ffffff";
                  }
                ?>
                <tr bgcolor="<?php echo $color; ?>">
	                <td><?php echo $data[$i]['itgc_id'];; ?></td>
	                <td><?php echo $data[$i]['device_imei']; ?></td>
	                <td><?php echo $data[$i]['device_id']; ?></td>
                  <td><?php echo $data[$i]['device_imei']; ?></td>
	                <td>
                  <?php 
                      $is_repair = $data[$i]['is_repaired'];
                      if($is_repair == 1) {
                          echo "True";
                      }
                      else { 
                          echo "False";
                      } 
                  ?>
                  </td>
                  <td>
                  <?php 
                      $is_antenna_rcd = $data[$i]['is_antenna_recd'];
                      if($is_antenna_rcd == 1){
                          echo "True";
                      }
                      else{
                          echo "False";
                      } 
                  ?>
                  </td>
                  <td>
                  <?php 
                      $is_connector_rcd = $data[$i]['is_connector_recd'];
                      if($is_connector_rcd == 1){
                          echo "True";
                      }
                      else{
                          echo "False";
                      } 
                  ?>
                  </td>
                  <td>
                  <?php 
                      $is_immobilizer_rcd = $data[$i]['is_immobilizer_recd'];
                      if($is_immobilizer_rcd == 1){
                          echo "True";
                      }
                      else{
                          echo "False";
                      } 
                  ?>
                  </td>
                  <td><?php echo $data[$i]['client_name']; ?></td>
                  <td><?php echo $data[$i]['veh_no']; ?></td>
                	<td>&#160;</td>
                  <td>&#160;</td>
                  <td>
                  <?php 
                      $is_crack = $data[$i]['is_cracked'];
                      if($is_crack == 1){
                          echo "True";
                      }
                      else{
                          echo "False";
                      } 
                  ?>
                  </td>
                  <td><?php echo $data[$i]['Branch_Send_Date']; ?></td>
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
                  
                </tr>
                <?php              	
             		} 
           	    ?>
             </tbody>
           </table></div>
   		   </div>
       </div>
       <!-- END BORDERED TABLE PORTLET--> 
     </div>
   </article>
   <script type="text/javascript">
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
            types: ['number','number','number','number','string','string','string','string','string','string','string','string','number','string']
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>
</body>
</html>