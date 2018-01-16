<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
  $data=select_Procedure("CALL SendToManufactureDevice()");
  $data=$data[0];
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";die;
?>
<head>

   <style type="text/css">
   th {
    text-align: center;
    white-space: nowrap;
    }
   </style>
</head>
<body>
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="color-sign">
      <div class="cl-item"><span class="green"></span><span>CASE IS ALREADY OPENED</span></div>
      
  </div>
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Manufacture Report</div>
         </div>
         <div class="portlet-body fix-table">
           <table class="table table-bordered" id="filtertable">
             <thead>
               <tr>
                 <th> S No. </th>
                 <th> DeviceSno </th>
                 <th> DeviceID </th>
                 <th> Device IMEI </th>
                 <th> Vehilce No </th>
                 <th> ClientName </th>
                 <th> Manufacture Send<br>Date By Repair </th>
                 <th> Manufacture Send<br>Date By Stock </th>
                 <th> Branch Name </th>
                 <th> Manufacture<br>Name </th>
                 <th> Manufacture Remarks<br>By Repair </th>
                 <th> Manufacture<br>Contact Name </th>
                 <th> Manufacture<br>Contact No. </th>
                 <th> Spare<br>Cost </th>
                 <th> Pending<br>Days </th>
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
	                <td><?php echo $i+1; ?></td>
	                <td><?php echo $data[$i]['device_sno']; ?></td>
	                <td><?php echo $data[$i]['device_id']; ?></td>
                  <td><?php echo $data[$i]['device_imei']; ?></td>
	                <td><?php echo $data[$i]['veh_no']; ?></td>
                  <td><?php echo $data[$i]['client_name']; ?></td>
                  <td>
                    <?php 
                    if($data[$i]['ManufactureDate'] == '0000-00-00 00:00:00'){
                      echo '';
                    }
                    else{  
                      echo date('d-m-Y H:i:s',strtotime($data[$i]['ManufactureDate'])); 
                    }  
                    ?>
                  </td>
                  <td>
                    <?php
                    //echo $data[$i]['opencase_date']; 
                    if($data[$i]['opencase_date'] == '0000-00-00 00:00:00'){
                      echo '';
                    }
                    else{ 

                      if(date('d-m-Y H:i:s',strtotime($data[$i]['opencase_date'])) == '01-01-1970 05:30:00'){
                        echo '';
                      }
                      else{  
                        echo date('d-m-Y H:i:s',strtotime($data[$i]['opencase_date']));
                      } 
                    }  
                    ?>
                  </td>
                  <td>
                    <?php 
                        $state=$data[$i]['Is_Branch_Recevied'];
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
                  <td><?php echo $data[$i]['ManufactureName']; ?></td>
                  <td><?php echo $data[$i]['ManufactureRemarks']; ?></td>
                  <td><?php echo $data[$i]['contact_name']; ?></td>
                   <td><?php echo $data[$i]['contact_no']; ?></td>
                  <td><?php echo $data[$i]['spare_cost']; ?></td>
                  <td><?php echo $data[$i]['PendingDays']; ?></td>
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
            types: ['number','number','number','number','string','string','number','number','number','string','string','string','string','number','number']
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>
</body>
</html>