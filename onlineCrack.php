<?php
include('config.php');
include('include/header.php');
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if (isset($_SESSION['userId_inv']) &&  !empty($_SESSION['userId_inv'])) {
  // $data=select_Procedure("CALL SelectCrackedDevice()");
  // $data=$data[0];
  // echo "<pre>";
  // print_r($data);
  // echo "</pre>";die();
  $data =db__select_staging("select * from internalsoftware.installation where installation_status='2' and instal_reinstall='online_crack' and inv_online_crack_sts=0");
  //$data =db__select_staging("select * from internalsoftware.installation where installation_status='2' ");
   //echo '<pre>'; print_r($data); die;
  $request_type='crack';
    
}

if (isset($_POST['submit']) && isset($_POST['rowVal']))
	{

		//echo '<pre>';print_r($_POST); die;
		//$deviceStatus = $UnCrackedDevice;
		//echo '<pre>'; print_r($_POST['rowVal']); die;
		for ($i = 0; $i < count($_POST['rowVal']); $i++) 
		{
			  $checkBox=explode('##',$_POST['rowVal'][$i]);
        $inst_req_id=$checkBox[0];
       $installer_id= $checkBox[2]; 
			 //$data1=db__select_staging("UPDATE internalsoftware.installation set installation_status='2  ' where  inst_req_id='".$inst_req_id."' ");
		}
     header("Location:addDevices_online_crack.php?inst_id=$installer_id&inst_req_id=$inst_req_id&req_type=$request_type");
		
  }
?>  

  
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Cracked Devices </div>
      </div>
      <div class="portlet-body fix-table">
        <table class="table table-bordered table-hover" id="filtertable">
          <form method="post">
          <thead>
            <tr>
              <th><input type="checkbox" name="checkAll" id="checkAll" onClick="checkAllId();" class="checkAll"></th>
              <th> Serial No. </th>
              <th> Client Name </th>
              <th> Branch Location </th>
              <th> Landmark </th>
              <th> Device Type </th>
              <th> Installer Name </th>
              <th> Contact Details </th>
         
            </tr>
          </thead>
          <tbody>
            <?php 
                for($i=0;$i<count($data);$i++){
            ?>
            <tr>
              <td><input type="checkbox" id="check<?php echo $i; ?>" name="rowVal[]" value="<?php echo $data[$i]['id']; ?>##<?php echo $i; ?>##<?php echo $data[$i]['inst_id']; ?>" onClick="setRow('<?php echo $i; ?>');" class="checkbox1"></td>
              
              <td><?php echo $i+1; ?></td>
              <? $sql="SELECT Userid AS id,UserName AS sys_username FROM internalsoftware.addclient  WHERE Userid=".$data[$i]["user_id"];
              $rowuser=db__select_staging($sql);
              ?>
              <td><?php echo $rowuser[0]['sys_username']; ?></td>
              <td>
                <?php 
               
                $sql1 = db__select_staging("select Zone_area from installation WHERE id='".$data[$i]['id']."'");
                $sql2 = db__select_staging("SELECT name FROM re_city_spr_1 WHERE id='".$sql1[0]['Zone_area']."'");

                  echo $sql2[0]['name'];
                  
                 ?>
              </td>
              <td>  
                <?php 
                $sql_InstRqst2 = db__select_staging("select inst_req_id from installation WHERE id='".$data[$i]['id']."'");
                  $sql_Inst2 = db__select_staging("select landmark from installation_request WHERE id='".$sql_InstRqst2[0]['inst_req_id']."'");
                      
                echo $sql_Inst2[0]['landmark']."<br>";
            ?>    
            </td>
          
          <td align="center" nowrap>

          <?php 
       
             $sqlDevice=db__select_staging("SELECT device_type FROM device_type where id='".$data[$i]["device_type"]."' "); 
             $sqlModel=db__select_staging("SELECT device_model FROM device_model where id='".$data[$i]["model"]."' "); 
         
            echo $sqlModel[0]['device_model']."</br>";
            echo $sqlDevice[0]['device_type'];
        
          ?>

          
        </td>
        
        <td><?php echo $data[$i]['inst_name'];?></td>
           <td>
      <?php
    
        $sql_InstRqst = db__select_staging("select inst_req_id from installation WHERE id='".$data[$i]['id']."'");
                $sql_Inst = db__select_staging("select contact_person,contact_number,designation from installation_request WHERE id='".$sql_InstRqst[0]['inst_req_id']."'");
                
                echo $sql_Inst[0]['contact_person']."<br>";
                echo $sql_Inst[0]['contact_number']."<br>";
                echo $sql_Inst[0]['designation']."<br>";
            ?>
    </td>
             
            </tr>
            <?php } ?>
            
          </tbody>
        </table>
        <input type="submit" name="submit" class="btn btn-default table-btn-submit" id="submit" value="Add Device">
      </form>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
<script>
  $('.checkbox1').on('change', function() {
    var bool = $('.checkbox1:checked').length === $('.checkbox1').length;
    $('#checkAll').prop('checked', bool);
  });

  $('#checkAll').on('change', function() {
    $('.checkbox1').prop('checked', this.checked);
  });
</script>
<script type="text/javascript">
  function checkAllId(){
    var i;
    var row = document.getElementById("checkAll")
    for(i=1;i<=<?php echo $rowcount; ?>;i++){
      
      if(row.checked){
        document.getElementById("remark"+i).disabled = false;
        document.getElementById("con"+i).disabled = false;
        document.getElementById("imm"+i).disabled = false;
        }
      else
      {
        document.getElementById("remark"+i).disabled = true;
        document.getElementById("con"+i).disabled = true;
        document.getElementById("imm"+i).disabled = true;
      }
    }  
  }    
  function setRow(rowId){
    var row = document.getElementById("check"+rowId)
   
    if(row.checked){
      document.getElementById("remark"+rowId).disabled = false;
      document.getElementById("con"+rowId).disabled = false;
      document.getElementById("imm"+rowId).disabled = false;
    }else{
      document.getElementById("remark"+rowId).disabled = true;
      document.getElementById("con"+rowId).disabled = true;
      document.getElementById("imm"+rowId).disabled = true;
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
            types: ['number','number','number','string','string','number','string','number','number']
        }]
    };
    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>