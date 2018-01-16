<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$login_name= $_SESSION['user_name_inv'];

$masterObj = new master();
$branch_id=$_SESSION['branch_id'];
if($branch_id==1)
{
	$branch_name="Delhi";
	//$branch_id=0;
}
$installer_id=$_GET['installer_id'];

$deviceTypeList=db__select("select * from inventory.item_master");
//echo '<pre>'; print_r($deviceTypeList); die;
//$installer_id=77;
$installerName=db__select_staging("SELECT * FROM internalsoftware.installer where inst_id='".$installer_id."' ");

$data=array();

$assignList_serv=db__select_staging("SELECT * FROM internalsoftware.services where branch_id='".$branch_id."' and inst_id='".$installer_id."' and service_status='2' and popup_alertStock='1' and (service_reinstall='service' or service_reinstall='re_install') ");


if(count($assignList_serv)>0)
{ 
	for($s=0;$s<count($assignList_serv);$s++)
	{
    $modelList=db__select("select item_id,item_name,parent_id from inventory.item_master where item_id='".$assignList_serv[$s]["item_id"]."' ");

				$arr=array(

								  'quantity' => 1,
                  'inst_name' => $installerName[0]["inst_name"],
								   'model_type' => $modelList[0]["item_name"],
                   'req_type' => $assignList_serv[$s]["service_reinstall"],
                    'req_type' => $assignList_serv[$s]["service_reinstall"],
                    'req_id' => $assignList_serv[$s]["id"],
                   'table_name' => 'services'

											
								) ;
				array_push($data,$arr);	
	}
}


  $assignList_crack_serv=db__select_staging("SELECT * FROM internalsoftware.services_crack where branch_id='".$branch_id."' and inst_id='".$installer_id."' and service_status='2' and popup_alertStock='1'  and service_reinstall='crack' ");
  if(count($assignList_crack_serv)>0)
  { 
    for($s=0;$s<count($assignList_crack_serv);$s++)
    {
      $modelList=db__select("select item_id,item_name,parent_id from inventory.item_master where item_id='".$assignList_crack_serv[$s]["device_model"]."' ");
          $arr1=array(
                      'quantity' => $assignList_crack_serv[$s]["no_of_vehicals"],
                      'inst_name' => $installerName[0]["inst_name"],
                       'model_type' => $modelList[0]["item_name"],
                       'req_type' => $assignList_crack_serv[$s]["service_reinstall"],
                        'req_id' => $assignList_crack_serv[$s]["id"],
                        'table_name' => 'services_crack'
                        
                  ) ;
          array_push($data,$arr1); 
    }
  }
 // echo "SELECT * FROM internalsoftware.installation_request where branch_id='".$branch_id."' and inst_id='".$installer_id."' and popup_alertStock='1' and installation_status=2 and  (instal_reinstall='installation' or instal_reinstall='re_install' or instal_reinstall='online_crack' or instal_reinstall='crack') "; die;

$assignList_inst_req=db__select_staging("SELECT * FROM internalsoftware.installation_request where branch_id='".$branch_id."' and inst_id='".$installer_id."' and popup_alertStock='1' and installation_status=2 and  (instal_reinstall='installation' or instal_reinstall='re_install' or instal_reinstall='online_crack' or instal_reinstall='crack') ");
if(count($assignList_inst_req)>0)
{ 
  for($s=0;$s<count($assignList_inst_req);$s++)
  {
   $modelList=db__select("select item_id,item_name,parent_id from inventory.item_master where item_id='".$assignList_inst_req[$s]["model"]."' "); 
        $arr2=array(
                'quantity' => $assignList_inst_req[$s]["installation_approve"],
                'inst_name' => $installerName[0]["inst_name"],
                'model_type' => $modelList[0]["item_name"],
                'req_type' => $assignList_inst_req[$s]["instal_reinstall"],
                  'req_id' => $assignList_inst_req[$s]["id"],
                  'table_name' => 'installation_request'
                      
                ) ;
        array_push($data,$arr2); 
  }
}


//echo '<pre>'; print_r($data); die;
if(isset($_POST['submit']))
{
    //print_r($_POST); die;
	 $errorMsg="";
	//$count=0;
  //echo count($_POST['rowVal']);die;
	//echo '<pre>'; print_r($_POST); '</pre>'; die;
	for($i=0;$i<count($_POST['rowVal']);$i++)
	{
		if(isset($_POST['rowVal'][$i]))
		{
				
				$requestList=$_POST['rowVal'][$i];
				$req=explode('##',$requestList);
				$install_id=$req[0];
        $request_type=$req[1];
        $table_name=$req[2];
        if((($request_type=='installation') || ($request_type=='re_install') ||($request_type=='crack') || ($request_type=='online_crack')) && ($table_name=='installation_request'))
        {
            //echo 'tt';die;
            $dt = array('popup_alertStock' => 0);
            $condition = array('id' => $install_id );
            update_query('internalsoftware.installation_request',$dt,$condition);

        }
        else if((($request_type=='service')||( $request_type=='re_install')) && ($table_name=='services'))
        {
           $dt1 = array('popup_alertStock' => 0);
              $condition1 = array('id' => $install_id );
           update_query('internalsoftware.services',$dt1,$condition1);
        }
        else if(($request_type=='crack') && ($table_name=='services_crack'))
        {
          //echo 'tt'; die;
            $dt2 = array('popup_alertStock' => 0);
            $condition2 = array('id' => $install_id );
           // print_r($condition2); die;
           update_query('internalsoftware.services_crack',$dt2,$condition2);
        }
        else
        {

        }
											
		}
	}
  header('Location:assigndevicesinstaller.php');
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
        <div class="caption"> <i class="fa fa"></i>Assign Device</div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
         
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll[]" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th>Device Model </th>
              <th>Request Type </th>
			        <th> quantity </th>
              <th>Installer Name </th>
            </tr>
          </thead>
          <tbody>
            <?php 

			for($x=0;$x<count($data);$x++)
			{
				$y=$x+1;
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $y; ?>" name="rowVal[]" value="<?php echo $data[$x]['req_id'];?>##<?php echo $data[$x]['req_type'];?>##<?php echo $data[$x]['table_name'];?>" class="checkbox1"></td>
			         <td><?php echo $data[$x]['model_type']; ?></td>
               <td><?php echo $data[$x]['req_type']; ?></td>
               <td><?php echo $data[$x]['quantity']; ?></td>
	             <td><?php echo $data[$x]['inst_name']; ?></td>
          
            
			 
			   
            </tr>
      <?php } ?>
       
          </tbody>
       
        </table>
			<input type="submit" onClick="bulk()" name="submit" id="submit" class="btn btn-default table-btn-submit" value="Assign">
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
        document.getElementById("antenna"+i).disabled = false;
        document.getElementById("immob"+i).disabled = false;
		document.getElementById("receive_from_installer"+i).disabled = false;
		document.getElementById("other_installer"+i).disabled = false;
		document.getElementById("connectors"+i).disabled = false;
		document.getElementById("receive_from"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
        document.getElementById("antenna"+i).disabled = true;
        document.getElementById("immob"+i).disabled = true;
		document.getElementById("receive_from_installer"+i).disabled = true;
		//document.getElementById("other_installer"+i).disabled = true;
		document.getElementById("connectors"+i).disabled = true;
		document.getElementById("receive_from"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("antenna"+rowId).disabled = false;
      document.getElementById("immob"+rowId).disabled = false;
	  document.getElementById("receive_from_installer"+rowId).disabled = false;
	  //document.getElementById("other_installer"+rowId).disabled = false;
	  document.getElementById("connectors"+rowId).disabled = false;
	  document.getElementById("receive_from"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("antenna"+rowId).disabled = true;
      document.getElementById("immob"+rowId).disabled = true;
	  document.getElementById("receive_from_installer"+rowId).disabled = true;
	  document.getElementById("other_installer"+rowId).disabled = true;
	  document.getElementById("connectors"+rowId).disabled = true;
	  document.getElementById("receive_from"+rowId).disabled = true;
    }
  }
  function  rec_from_installer(value,rowId)
  {
	 // alert(value);
	 if(value==111)
	 {
		//alert(rowId);
	   document.getElementById("other_installer"+rowId).disabled = false;
	 }
	 else
	 {
		 document.getElementById("other_installer"+rowId).disabled = true;
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
                    'number', 'number','number','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script>
</body>
</html>
