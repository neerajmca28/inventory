<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
$branchId=$_SESSION['branch_id'];
$login_name= $_SESSION['user_name_inv'];	
$masterObj = new master();
//$branchId=2;
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
//echo "CALL SelectRecdDispatchedDevicesPending('".$branchId."')"; die;
$notif_count=0;
$SelectRecdDispatchedDevices=select_Procedure("CALL SelectRecdDispatchedDevicesPending('".$branchId."')");
$SelectRecdDispatchedDevices=$SelectRecdDispatchedDevices[0];
/*  echo "<pre>";
print_r($SelectRecdDispatchedDevices); 
"</pre>";die; */  
$rowcount=count($SelectRecdDispatchedDevices); 

?>
<head>

</head>
<body>
<form name="assg_device" id="assg_device" method="post" action=""  onsubmit="return validateForm();">
 <article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Assign Devices To Installer Pendings </div>
      </div>
      
	<div class="portlet-body" id="tt"  style="">
        <table class="table table-bordered"  id="filtertable">
         
          <thead>
            <tr>
           
              <th> ITGC ID</th>
			  <th> IMEI </th>
              <th> Antenna </th>
			  <th> Immobilizer </th>
			  <th> Connectors </th>
			  <?php if($branchId!=1){?>
			  
			  <?php }?>
			  
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
				
				
            ?>
            <tr bgcolor="<?php echo $color; ?>" title="<?php echo $tool_tip ?>">
            
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['itgc_id']; ?></td>
			   
			   
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['device_imei']; ?></td>
			   
			   <input type="hidden" id="hidden" name="hidden" value=<?php echo $branchId;?> >
              
			  	<?php if($branchId==1){?>
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['DispatchAntennaCount']; ?></td>
			  <?php $imm_type=$SelectRecdDispatchedDevices[$x]['DispatchImmobilizerType'];
			  if($imm_type==1)
			  {
				  $immob_type="24VT";
			  }
			  elseif($imm_type==2)
			  {
				  $immob_type="12VT";
			  }
			  else
			  {
				  $immob_type="";
			  }
		
			  ?>
			  
			  <td><?php echo 'immob type :'.$immob_type; echo '</br>'?>
			  <?php echo 'immob count :'.$SelectRecdDispatchedDevices[$x]['DispatchImmobilizerCount']; ?></td>
			  
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['DispatchConnectorCount']; ?></td>
			  <?php }else{?>
			     <td>
                <select id="antenna<?php echo $y;?>" name="antenna[]" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($i=1;$i<=10;$i++){ ?>
                  <option role="presentation" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php } ?>
                </select>  
              </td>
              <td>
			  <select id="immob_type<?php echo $y;?>" name="immob_type[]" disabled />
                  <option role="presentation" value="0">Select</option>
				  <option role="presentation" value="1">24VT</option>
				  <option role="presentation" value="2">12VT</option>
			  </select>  
				
                <select id="immob<?php echo $y;?>" name="immob[]" disabled />
                  <option role="presentation"  value="0">Select</option>
                  <?php for($j=1;$j<=10;$j++){ ?>
                  <option role="presentation" value="<?php echo $j; ?>"><?php echo $j; ?></option>
                  <?php } ?>
                </select>  
              </td>
			  
			     <td>
                <select id="connectors<?php echo $y;?>" name="connectors[]" disabled />
                  <option role="presentation" value="0">Select</option>
                  <?php for($j=1;$j<=10;$j++){ ?>
                  <option role="presentation" value="<?php echo $j; ?>"><?php echo $j; ?></option>
                  <?php } ?>
                </select>  
              </td>
			  <td><?php echo $SelectRecdDispatchedDevices[$x]['device_dispatchrecd_remarks']; ?></td>
			  <?php }?>
			  
			 
            </tr>
            <?php } ?>
           
          </tbody>
		     </table>
			 <!-- <tr>
              <td colspan="11"><input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Assign"></td>
            </tr> -->
			  </div>
			     </div>
					 </div>
          </form> 

    <!-- END BORDERED TABLE PORTLET--> 
  
</article>

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
                    'number', 'number','number',
                    'string','number', 'string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
  </form>
</body>
</html>