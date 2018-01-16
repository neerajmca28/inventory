<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//$branch_id=$_SESSION['branch_id']; 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();	
$sim_id=0;	
$SelectSim=select_Procedure("CALL SelectSim('".$sim_id."')");
$SelectSim=$SelectSim[0];
//$dbselect=$dbselect[0];
  /* echo "<pre>";
print_r($SelectSim); 
"</pre>";die;  
 */
?>
<head>

</head>

<body>

<article>
  <div class="col-12"> 
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Sim Details</div>
      </div>
    </div>

	<div class="portlet box yellow" id="ss">
      <div class="portlet-title">
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th>Sim No. </th>
              <th> Operator </th>
              <th>Recieved Date </th>
              <th> Status </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($SelectSim);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
             
			  <td><?php echo $SelectSim[$x]['sim_no']; ?></td>
			  <td><?php echo $SelectSim[$x]['operator']; ?></td>
              <td><?php echo $SelectSim[$x]['rec_date'];?></td>
			  <td><?php echo 'Active'; ?></td>

            </tr>
            <?php } ?>
          </tbody>
          </form> 
        </table>
      </div>
    </div>

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
          types: [
                    'number', 'number','number','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</html>