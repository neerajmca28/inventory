<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$masterObj = new master();
$branch_id=$_SESSION['branch_id'];
if($branch_id==1)
{
	$branch_name="Delhi";
}
$login_name= $_SESSION['user_name_inv'];	
//echo "SELECT * FROM internalsoftware.services where branch_id='".$branch_id."' and service_reinstall='crack' and service_status=201";die;
// $SelectBranchRepairDevice1=db__select_staging("SELECT * FROM internalsoftware.services_crack where branch_id='".$branch_id."' and service_reinstall='crack' and service_status='5' ");
$SelectBranchRepairDevice1=db__select_staging("SELECT * FROM internalsoftware.services where branch_id='".$branch_id."' and service_reinstall='crack' and service_status='5' ");

$rowcount=count($SelectBranchRepairDevice1);
if(isset($_POST['submit']))
{
	$errorMsg="";
	$count=0;
	$service_status=202;

	//echo '<pre>'; print_r($_POST); '</pre>'; die;
	for($i=0;$i<count($_POST['rowVal']);$i++)
	{

		 if(isset($_POST['rowVal'][$i]))
		 {
				
				$listing=$_POST['rowVal'][$i];
				$lst=explode('##',$listing);
		 		$serv_req_id=$lst[0];
		 		//$crack_req_id=$data[1];
		 		$cond=array('id' => $serv_req_id);
		 		$data=array('service_status' => $service_status);
		 		$query1=update_query('internalsoftware.services',$data,$cond);
		 		//$delete=db__delete_staging('internalsoftware.services',$cond);
		 }

		 // 		$query=db__select_staging("select * from services_crack where id= '".$crack_req_id."' ");
		 // 		$data1 = array('service_status' => $service_status);
			// 	$condition=array('id' => $service_id);
			// 	$condition2=array('id' => $crack_req_id);
				
			// 	$query1=update_query('internalsoftware.services_crack',$data1,$condition2);
		 		
		 // 		$crack_req_id=$query[0]['id'];
			//     $req_date=$query[0]['req_date'];
			//     $request_by=$query[0]['request_by'];
			//     $service_reinstall=$query[0]['service_reinstall'];
			//     $zone_area=$query[0]['Zone_area'];
			//     $branch_id=$query[0]['branch_id'];
			//     $no_of_vehicals=$query[0]['no_of_vehicals'];
			//     $device_imei_crack=$query[0]['device_imei'];
			//     $company_name_crack=$query[0]['company_name'];
			//     $veh_reg_crack=$query[0]['veh_reg'];
			//     $location_crack=$query[0]['location'];

			//     $pname_crack =$query[0]['pname'];
			//     $cnumber_crack=$query[0]['cnumber'];  
			//     $atime_status_crack=$query[0]['atime_status']; 
			//     $designation_crack =$query[0]['designation'];
			//     $alter_contact_no_crack=$query[0]['alter_contact_no'];  
			//     $alt_designation_crack=$query[0]['alt_designation']; 
			//     $alt_cont_person_crack=$query[0]['alt_cont_person']; 
			//     $atime_crack=$query[0]['atime']; 
			//     $atimeto_crack=$query[0]['atimeto']; 
			//     $payment_crack=$query[0]['payment']; 
			//     $billing_crack=$query[0]['billing'];
			//     $imei=explode(',',$device_imei_crack);
			//     $vh=explode(',',$veh_reg_crack);
			//      for($m=0;$m<count($vh);$m++)
   //                {
   //                	     $insert_service = array('request_by'=>$request_by,'req_date'=> $req_date,'branch_id'=>$branch_id,'crack_req_id'=> $crack_req_id,'name' => $name, 'Notwoking' => $Notwoking, 'inst_name' =>  $inst_name, 'inst_id' =>  $inst_id, 'inst_cur_location' => $inst_cur_location,'inst_date' => date("Y-m-d"), 'newpending' => '0', 'status' => '0', 'billing' => $billing_crack, 'payment' => $payment_crack, 'service_status' => '202','Zone_area' => $zone_area,'branch_id'=>$branch_id,'no_of_vehicals'=> $no_of_vehicals,'device_imei'=>$imei[$m],'company_name'=>$company_name_crack,'veh_reg'=>$vh[$m],'location'=>$location_crack,'pname'=>$pname_crack,'cnumber'=>$cnumber_crack,'atime_status'=>$atime_status_crack,'designation'=>$designation_crack,'alter_contact_no'=>$alter_contact_no_crack,'alt_designation'=>$alt_designation_crack,'alt_cont_person'=>$alt_cont_person_crack,'atime'=>$atime_crack,'atimeto'=>$atimeto_crack, 'service_reinstall' => $service_reinstall);
			// 			     $insertCrackDevice=db__insert_staging('internalsoftware.services',$insert_service);

   //                }
		 // }					
								
	}
		//update query for services_request table
		
		// $data = array('req_date' => $req_date)
		// $insertCrackDevice=db__insert_staging('internalsoftware.services_request',$data);
		?><script><?php echo("location.href = '".__SITE_URL."/recd_remove_crack.php';");?></script><?	


}
?>
<head>
</head>
<body>
 <form name="recd_rmd_device" id="recd_rmd_device" method="post" action="" >		
<article>
  <div class="col-12"> 
			
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Recd Remove Crack Device </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
             
              <th>Request Date </th>
              <th> Client Name </th>
              <th> Vehicle No. </th>
			  <th> Location</th>
		
		<!-- 	  <th> No. of Vehicle </th> -->
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<$rowcount;$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $SelectBranchRepairDevice1[$x]['id'];?>" onClick="setRow('<?php echo $y; ?>');" class="checkbox1"></td>
			  <td><?php echo $SelectBranchRepairDevice1[$x]['req_date']; ?></td>
			  <td><?php echo $SelectBranchRepairDevice1[$x]['name']; ?></td>
	
			  <td><?php echo $SelectBranchRepairDevice1[$x]['veh_reg']; ?></td>
			   <td><?php echo $SelectBranchRepairDevice1[$x]['inst_cur_location']; ?></td>
			
			<!--     <td><?php echo $SelectBranchRepairDevice1[$x]['no_of_vehicals']; ?></td> -->
			  
              
            </tr>
            <?php } ?>
       
          </tbody>
       
        </table>
			<input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Receive">
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  	   </form> 
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
		// alert(<?php echo $rowcount; ?>);
		 // var tt=document.getElementById("remark"+i);
		    //alert('tt');
        document.getElementById("remark"+i).disabled = false;

		document.getElementById("receive_from_installer"+i).disabled = false;
		document.getElementById("other_installer"+i).disabled = false;

		document.getElementById("receive_from"+i).disabled = false;
        }
      else
      {

		document.getElementById("receive_from_installer"+i).disabled = true;
		//document.getElementById("other_installer"+i).disabled = true;
	
		document.getElementById("receive_from"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;


	  document.getElementById("receive_from_installer"+rowId).disabled = false;
	  //document.getElementById("other_installer"+rowId).disabled = false;

	  document.getElementById("receive_from"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
 
  
	  document.getElementById("receive_from_installer"+rowId).disabled = true;
	  document.getElementById("other_installer"+rowId).disabled = true;

	  document.getElementById("receive_from"+rowId).disabled = true;
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
          types: [
                    'number', 'number', 'string','string','string','string','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>
