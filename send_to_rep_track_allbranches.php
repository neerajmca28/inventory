<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
$send_repair_allBranch=$_POST['send_repair_allBranch'];
if($send_repair_allBranch=='rd')
{
		$SendToRepairDevice_Track=select_Procedure("CALL SendToRepairDevice_Track()");
		$SendToRepairDevice_Track=$SendToRepairDevice_Track[0];
		//print_R($SendToRepairDevice_Track); die;
		echo '<div class="portlet-title">
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover" id="filteration">
         
           <thead>
            <tr>
			  <th>ITGC ID </th>
              <th> IMEI </th>
              <th> Client Name </th>
              <th> Remove Date </th>
              <th> Recevie Date</th>
              <th>Send To Repair Center Date </th>
			  <th>Antenna </th>
              <th> Connectors </th>
              <th> Recevied Installer Name </th>
              <th> Removed Installer Name </th>
              <th> Remarks</th>
			  <th> Send Branch Name</th>
            </tr>
          </thead>
          <tbody>';
  }
  ?>

     
            <?php 

			for($x=0;$x<count($SendToRepairDevice_Track);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
			  <td><?php echo $SendToRepairDevice_Track[$x]['itgc_id']; ?></td>
              <td><?php echo $SendToRepairDevice_Track[$x]['device_imei'];?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['client_name']; ?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['device_removed_date']; ?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['recd_date']; ?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['sendtorepaircenter']; ?></td>
              <td><?php echo $SendToRepairDevice_Track[$x]['is_antenna_recd'];?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['is_connectors_recd']; ?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['Received_installer_name']; ?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['Remove_installer_name']; ?></td>
			  <td><?php echo $SendToRepairDevice_Track[$x]['branch_repaired_remarks']; ?></td>
			  <?php $branch_id=$SendToRepairDevice_Track[$x]['Is_Branch_Recevied'];
			  if($branch_id==1)
			  {
				  $branch_id='Delhi';
			  }
			   if($branch_id==2)
			  {
				  $branch_id='Mumbai';
			  }
			   if($branch_id==3)
			  {
				  $branch_id='Jaipur';
			  }
			   if($branch_id==4)
			  {
				  $branch_id='Sonepat';
			  }
			   if($branch_id==5)
			  {
				  $branch_id='Kanpur';
			  }
			    if($branch_id==6)
			  {
				  $branch_id='Ahmedabad';
			  }
			    if($branch_id==7)
			  {
				  $branch_id='kolkata';
			  }
			  ?>
			   <td><?php echo $branch_id; ?></td>
            </tr>
            <?php } ?>
          </tbody>
       
        </table>
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
                    'number', 'number','number','number','string','string','number','string','number', 'string','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filteration', filtersConfig);
    tf.init();

</script>	
 
  