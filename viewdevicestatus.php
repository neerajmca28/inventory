<?php
error_reporting(0);
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');

$masterObj = new master();
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if(isset($_POST['devSearch']))
{
    if (empty($_POST['devicephone']))
    {
        $errMsg1 = 'Please Input Device IMEI/Device Sno.';
    }   
    elseif (strlen($_POST['devicephone']) < 4)
    {
        $errMsg3 = 'Enter Only Sim Number of 19 Digits and Phone Number of 10 Digits.';
    } 
    else 
    {
        $dev_search=$_POST['devicephone'];
        $dev_searchid=select_Procedure("CALL GetDeviceStatus('".$dev_search."')");
      
        $dev_searchid=$dev_searchid[0];

        $installer_view=select_Procedure("CALL proc_viewInstaller('".$dev_search."')");
        $installer_view=$installer_view[0];
	    if(count($dev_searchid)<1)
  	    {
  		   $errorMsg="There is no Records.";
  		   echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
  	    }
	 
    }
}
 
?>

<head>

<style type="text/css">
.s{
  text-decoration: bold;
  color:green;
}
</style>
</head>
<body>
  <article>
    <div class="col-12"> 
      <form name="simfilter" action="viewdevicestatus.php" method="post" class="form-inline">
      <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet box yellow">
          <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Device Status</div>
         </div>
          <div class="portlet-body control-box">
            <div class="content-box" id="simFilter">
              <label style="margin-left:5px" class="mr-sm-2" for="inlineFormCustomSelect"> Device IMEI/Device Sno. Search: </label>
              <span style="margin-left:20px">
                <input type="text" name="devicephone" id="sim_phone" class="form-control" placeholder="Search" value="<?php echo $dev_search; ?>">
              </span>                
              <input onclick="return ValidateNumeric();" class="btn btn-primary" type="submit" name="devSearch" value="Search">
              <span style="color:red">
                <?php 
                  if(isset($errMsg1)){ echo $errMsg1; } 

                  if(isset($errMsg2)){ echo $errMsg2; } 

                  if(isset($errMsg3)){ echo $errMsg3; }
                ?>
              </span>
            </div>
          </div>
          <div class="content-box" id="simFilter">
            <table class='table borderless'>
              <tr>
                <td width="18%">Device Status</td>
                <td class="s">
                  <?php 
                    for($i=0;$i<count($dev_searchid);$i++){
                      echo $dev_searchid[$i]['DeviceStatus'];
                    }
                  ?>
                </td>
              </tr>
              <tr>
                <td>Installer Name</td>
                <td class="s">
                <?php 
                  for($i=0;$i<count($dev_searchid);$i++){
                    //echo $id = $installer_view[$i]['InstallerID'];die();
                    //echo  $id = $dev_searchid[$i]['device_status'];die();
                    if($dev_searchid[$i]['device_status'] == 64 || $dev_searchid[$i]['device_status'] == 65 || $dev_searchid[$i]['device_status'] == 66 || $dev_searchid[$i]['device_status'] == 75 || $dev_searchid[$i]['device_status'] == 68 ||$dev_searchid[$i]['device_status'] == 79 || $dev_searchid[$i]['device_status'] == 64 || $dev_searchid[$i]['device_status'] == 96)
                    {
                      $id = $installer_view[$i]['InstallerID'];
                      //echo "select installer.inst_name from internalsoftware.installer where inst_id='".$id."'";die();
                      $strSqlQuery =db__select_staging("select installer.inst_name from internalsoftware.installer where inst_id='".$id."'");
                      //print_r($strSqlQuery);die();
                      //$strSqlQuery =db__select_staging("select inst_name from installer where inst_id='".$id."'");
                      echo  $installerName = $strSqlQuery[0]['inst_name']; 

                    }
                    else{
                      echo "-";
                    }
                  }
                ?>
                </td>
              </tr>
              <tr>
                <td>Device Recd Date In Inventory </td>
                <td class="s">
                <?php 
                  for($i=0;$i<count($dev_searchid);$i++){
                    echo date('d-m-Y H:i:s',strtotime($dev_searchid[$i]['recd_date']));
                  }
                ?>
                </td>
              </tr>
              <tr>
                <td>Branch Name</td>
                <td class="s">
                  <?php
                      for($i=0;$i<count($dev_searchid);$i++){ 
                        $state=$dev_searchid[$i]['dispatch_branch'];
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
                      }  
                    ?>
                </td>
              </tr>
              <tr>
                <td>FFC Status</td>
                <td class="s">
                <?php 
                  for($i=0;$i<count($dev_searchid);$i++){
                    if($dev_searchid[$i]['is_ffc'] == 0)
                    {  
                      echo "No";
                    }
                    else
                    {
                      echo "Yes";
                    }  
                  }
                ?>
                </td>
              </tr>
              <tr>
                <td>Cracked Device Status</td>
                <td class="s">
                <?php 
                  for($i=0;$i<count($dev_searchid);$i++){
                    if($dev_searchid[$i]['is_cracked'] == 1)
                    {  
                      echo "Yes";
                    }
                    else
                    {
                      echo "No";
                    }  
                  }
                ?>
                </td>
              </tr>
              <tr>
                <td>Reason for Not Cracked Device</td>
                <td></td>
              </tr>
            </table>
          </div>
          <!-- <div class="content-box" id="simFilter" style="">
            <div class="left-item"><span>View Portwise Data </span></div>
            <div class="right-item two-filter-inp">
              <div class="right-item"><input  class="btn btn-primary" type="submit" name="Show" value="Show"></div>
            </div>
          </div> -->
        </div>
      </form>
    <!-- END BORDERED TABLE PORTLET--> 
    </div>
  </article>
  <script type="text/javascript">
  function ValidateNumeric() {
    var val = document.getElementById("sim_phone").value;

    if(val=='')
    {
      alert("Please Input Device IMEI/Device Sno.");
      return false;
    } 

    // else if (!val.match(/^[0-9]+$/)) {
    //     alert("Device IMEI/Device Sno. must be filled with numbers only");
    //     return false;
    // }

    else if (val.length < 4) {
        alert("Device IMEI/Device Sno. must not be greater than 4 character length");
        return false;
    }

    else{    

        return true; 
    }

    }
  </script>
</body>
</html>