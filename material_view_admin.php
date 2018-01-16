<?php 
include("config.php");
include("include/header.php");
include("device_status.php");
include(__DOCUMENT_ROOT.'/fpdf/fpdf.php');
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
} 
$branch_id=$_SESSION['branch_id'];
$viewAllMaterial_admin=select_Procedure("CALL viewAllMaterial_admin()");
$viewAllMaterial_admin=$viewAllMaterial_admin[0];
$rowcount=count($viewAllMaterial_admin);
//echo '<pre>';print_r($viewAllMaterial_admin); echo '</pre>'; die;
$errorMsg="";
$data=array();
if (isset($_POST['submit']))
{
		for($i=0;$i<count($_POST['rowVal']);$i++)
		{
			if(isset($_POST['rowVal'][$i]))
			{
				 $Remarks=$_POST['remark'][$i];
				 $DispatchDate=date('Y-m-d H:i:s');
				 $data=explode('##',$_POST['rowVal'][$i]);
				 //print_r($data); die;
			     //$id=$data[0];
			     $status=$account_status;
			     $material=$data[1];
				 $viewAllMaterial=select_Procedure("CALL backfromAdmin_toAccountForApproval('".$material."','".$Remarks."','".$status."')");
			}		
		}
	?><script><?php echo("location.href = '".__SITE_URL."/material_view_admin.php';");?></script><?php
}

?>
<head>
</head>
<body>
 <form name="view_material" id="view_material" method="post" action="" >
	<div class="color-sign" style="margin: 15px 0 2px 0;">
      <div class="cl-item"><span class="lightred"></span><span>Not Available</span></div>
      <div class="cl-item"><span class="orange"></span><span>Endanger</span></div>
	     <div class="cl-item"><span class="lightgreen"></span><span>Adequate</span></div>
   
   
  </div>	
<article>

  <div class="col-12"> 
 
					
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>All Material View</div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th>Stock Requirement</th>
               <!--     <th>Material Quantity</th>
            <th>Material Subcategory</th>
               <th>Subcategory Quantity</th> -->
              <th> Account Remarks </th>
               <th> Remarks </th>
			 
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				$quant=$viewAllMaterial_Stock[$x]['quantity'];

				if($quant < 1)
				{
					$color="#FFA07A";
					$tool_tip="finished";
					
                }
				if(($quant > 0 && $quant <= 50))
				 {
                   $color="#FFA500";
					$tool_tip="endanger material";
                 }

                if($quant>50)
				{
					$color="#7CFC00";
					$tool_tip="adequate quantity";
					
                }

				 
            ?>
            <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $viewAllMaterial_admin[$x]['id'];?>##<?php echo $viewAllMaterial_admin[$x]['name'];?>##<?php echo $viewAllMaterial_admin[$x]['quantity'];?>##<?php echo $viewAllMaterial_admin[$x]['parent_id'];?>" onclick="setRow('<?php echo $y; ?>');" onclick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
				 <td><?php echo $viewAllMaterial_admin[$x]['stock_remarks'];?></td>
				  <td><?php echo $viewAllMaterial_admin[$x]['account_remarks'];?></td>
			<!-- 	    <td><?php echo $viewAllMaterial_admin[$x]['quant1'];?></td>
				 <td><?php echo $viewAllMaterial_admin[$x]['subcategory'];?></td> -->
              <td>
                <textarea rows="1" cols="30" id="remark<?php echo $y;?>" name="remark[]" disabled></textarea> 
              </td>
             
            </tr>
            <?php } ?>
            
          </tbody>

          </table>

        <tr>
              <td colspan="11"><input type="submit" class="btn btn-default table-btn-submit" name="submit" id="submit" value="Approved"></td>
            
         </tr>
    
          </form> 
     
      </div>
    </div>

    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
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
        document.getElementById("remark"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;

    }else{
      document.getElementById("remark"+rowId).disabled = true;
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
                    'number','number','number','number','string','string','string'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>