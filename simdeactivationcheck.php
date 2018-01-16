<?php
include("device_status.php");
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branch_id=$_SESSION['branch_id'];
$SimDeactivation=select_Procedure("CALL SimDeactivation('".$branch_id."')");
$SimDeactivation=$SimDeactivation[0]; 
$rowcount1=count($SimDeactivation);
$SimDeactivation_new=select_Procedure("CALL SimDeactivation_new('".$branch_id."')");
$SimDeactivation_new=$SimDeactivation_new[0];
$rowcount2=count($SimDeactivation_new);
$branchList=$branchList[0];
				
?>
<head>
</head>
<body>
  <form name="sim_deactivation_check" id="sim_deactivation_check" method="post" action="" >
 <div class="color-sign" style="margin: 10px 0 0 0;">
      <div class="cl-item"><span class="lightblue"></span><span> Old SIM</span></div>
      <div class="cl-item"><span class="white"></span><span> New SIM</span></div> 
  </div>
				
<article>

  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Sim Deactivation Pre-Checking </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
              <th>Serial No.</th>
              <th> SIM ID </th>
              <th> Sim NO </th>
              <th> Phone No</th>
              <th> Sim Remove Date </th>
			  <th> Operator </th>
			  <th> Installer Name </th>
              <th> SIM Removed Problem </th>
              <th> Activate </th>
			  <th> Deactivate</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount1;$x++)
			{
				$y=$x+1;
	
            ?>
            <tr bgcolor="<?php echo $color; ?>">
			
			  <td><?php echo $y;?></td>
			  <td><?php echo $SimDeactivation[$x]['sim_id']; ?></td>
			  <input type="hidden" name="sim_id[]" id="sim_id" value="<?php echo $SimDeactivation_new[$x]['sim_id']; ?>">
			  <td><?php echo $SimDeactivation[$x]['sim_no']; ?></td>
              <td><?php echo $c=$SimDeactivation[$x]['phone_no'];?></td>
			  <input type="hidden" name="phone_no[]" id="phone_no" value="<?php echo $SimDeactivation_new[$x]['phone_no']; ?>">
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SimDeactivation[$x]['SimRemoveDate'])); ?></td>
			  <td><?php echo $SimDeactivation[$x]['operator']; ?></td>
			  <td><?php echo $SimDeactivation[$x]['Remove_installer_name']; ?></td>
			  <td><?php echo $SimDeactivation[$x]['device_removed_problem']; ?></td>
			  <td><a href="#" onClick="return activateComment(<?php echo $SimDeactivation[$x]["sim_id"];?>);">Activate</a></td>
			  <td><a href="#" onClick="return deactivateComment(<?php echo $SimDeactivation[$x]["sim_id"];?>);">Deactivate</a></td>

            </tr>
            <?php } ?>
           
          </tbody>
          </form> 
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Sim Change </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered" id="filteration">
         
          <thead>
            <tr>
              <th>Serial No.</th>
              <th> SIM ID </th>
              <th> Sim NO </th>
              <th> Phone No</th>
              <th> Sim Remove Date </th>
			  <th> Operator </th>
			  <th> Installer Name </th>
              <th> SIM Removed Problem </th>
              <th> Activate </th>
			  <th> Deactivate</th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount2;$x++)
			{
				$y=$x+1;
             
            ?>
            <tr>
			
			  <td><?php echo $y;?></td>
			  <td><?php echo $SimDeactivation_new[$x]['sim_id']; ?></td>
			   <input type="hidden" name="sim_id[]" id="sim_id" value="<?php echo $SimDeactivation_new[$x]['sim_id']; ?>">
			  <td><?php echo $SimDeactivation_new[$x]['sim_no']; ?></td>
              <td><?php echo $c=$SimDeactivation_new[$x]['phone_no'];?></td>
			   <input type="hidden" name="phone_no[]" id="phone_no" value="<?php echo $SimDeactivation_new[$x]['phone_no']; ?>">
			  <td><?php echo date('d-m-Y H:i:s',strtotime($SimDeactivation[$x]['SimRemoveDate'])); ?></td>
			  <td><?php echo $SimDeactivation_new[$x]['operator']; ?></td>
			  <td><?php echo $SimDeactivation_new[$x]['SimChangeInstallerName']; ?></td>
			  <td><?php echo $SimDeactivation_new[$x]['SimChangeRemarks']; ?></td>
			  <td><a href="#" onClick="return activateComment(<?php echo $SimDeactivation_new[$x]["sim_id"];?>);">Activate</a></td>
			  <td><a href="#" onClick="return deactivateComment(<?php echo $SimDeactivation_new[$x]["sim_id"];?>); ">Deactivate</a></td>

            </tr>
            <?php } ?>
           
          </tbody>
          </form> 
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
</body>
<script>
 var $dispatch = jQuery.noConflict()
  $dispatch('.checkbox1').on('change', function() {
    var bool = $dispatch('.checkbox1:checked').length === $dispatch('.checkbox1').length;
    $dispatch('#checkAll').prop('checked', bool);
  });

  $dispatch('#checkAll').on('change', function() {
    $dispatch('.checkbox1').prop('checked', this.checked);
  });
</script>
<script type="text/javascript">
  function checkAllId(){
    var i;
    var row = document.getElementById("checkAll")
    for(i=1;i<=<?php echo $rowcount; ?>;i++){
      if(row.checked){
		// alert(<?php echo $rowcount; ?>);
		 // var tt=document.getElementById("remark"+i);
		    //alert('tt');
        document.getElementById("remark"+i).disabled = false;
        document.getElementById("antenna"+i).disabled = false;
        document.getElementById("immob"+i).disabled = false;
		document.getElementById("immob_type"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
        document.getElementById("antenna"+i).disabled = true;
        document.getElementById("immob"+i).disabled = true;
		document.getElementById("immob_type"+i).disabled = true;
		document.getElementById("connectors"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("immob_type"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("immob_type"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
    }
  }
</script>
<script>
var $acti_deact = jQuery.noConflict();
function activateComment(sim_id)
{
	
	var result = confirm("Are you sure for Activation");
      if (result == true) {
	$acti_deact.ajax({
		type:"GET",
		url:"userInfo.php?action=active",
		data:"sim_id="+ sim_id,
		success:function(msg){
			// alert(msg);
			 //alert(sim_no + " sim is activated");
			//location.reload(true);
			window.location.href = "simdeactivationcheck.php";		
		}
	});
	}
}
function deactivateComment(sim_id)
{
	var result = confirm("Are you sure for DeActivation");
     if (result == true) {
	$acti_deact.ajax({
		type:"GET",
		url:"userInfo.php?action=deactive",
		data:"sim_id="+ sim_id,
		success:function(msg){
			// alert(msg);
			//location.reload(true);
			window.location.href = "simdeactivationcheck.php";		
		}
	});
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
          types: [
                    'number', 'number','number','string','number','number', 'string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

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
          types: [
                    'number', 'number','number','number','number','string', 'string','string'
                ]
        }]
    };

    var tf = new TableFilter('filteration', filtersConfig);
    tf.init();

</script>
</html>