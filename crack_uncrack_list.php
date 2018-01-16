<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
//print_r($_POST);  die;
  $crack_uncrack=$_POST['crack_uncrack'];
  if($crack_uncrack=='n')
  {
		$crack_uncrack=select_Procedure("CALL SelectUnCrackedDevices()");
		$crack_uncrack=$crack_uncrack[0];
		//print_R($crack_uncrack); die;
  }
  if($crack_uncrack=='c')
  {
		$crack_uncrack=select_Procedure("CALL SelectCrackedDevices()");
		$crack_uncrack=$crack_uncrack[0];
		//print_R($crack_uncrack); die;
  }
 

?>

	
	<div class="portlet box yellow " id='tt'>
      <div class="portlet-title">
    <div class="caption"> <i class="fa fa"></i> List of Cracked/Not Cracked Devices

</div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
           <thead>
            <tr>
              <th>ITGC ID </th>
              <th> IMEI </th>
              <th> Client Name </th>
              <th> Veh No. </th>
              <th> Remarks</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($crack_uncrack);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
			  <td><?php echo $crack_uncrack[$x]['itgc_id']; ?></td>
			  <td><?php echo $crack_uncrack[$x]['device_imei']; ?></td>
              <td><?php echo $crack_uncrack[$x]['client_name'];?></td>
			  <td><?php echo $crack_uncrack[$x]['veh_no']; ?></td>
			  <td><?php echo $crack_uncrack[$x]['uncracked_device_remarks']; ?></td>
			  
            </tr>
            <?php } ?>
          </tbody>
       
        </table>
      </div>
    </div>
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
          types: [
                    'number','number','number','string', 'number','number', 'number','string','string','string','string','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
	
    <!-- END BORDERED TABLE PORTLET--> 

  