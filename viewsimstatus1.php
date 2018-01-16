<?php
//error_reporting(0);
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');

if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if(isset($_POST['simStatusBtn']))
{
    if (empty($_POST['simstatus'])) 
    {
      $errMsg1 = 'Please Input Mobile No/Sim No.';

    }
    elseif (!(preg_match ("/^([0-9]+)$/", $_POST['simstatus'])))
    {
      $errMsg2 = 'Mobile No/Sim No. must be filled with numbers only.';
    }
    elseif ((strlen($_POST['simstatus']) != 10) && (strlen($_POST['simstatus']) != 19)) 
    {
      //echo $a = strlen($_POST['simstatus']); 
      $errMsg3 = 'Enter Only Sim Number = 19 and Phone Number = 10.';
    } 
    else 
    {
      $sim_status=$_POST['simstatus'];
      $sim_statusid=select_Procedure("CALL GetSMIStatus('".$sim_status."')");
      $sim_statusid=$sim_statusid[0];
      if(count($sim_statusid) > 0)
      {
        $simcount = array_slice($sim_statusid, 0, 1);
      }
      else
      {
        $errMsg = "SIM is not available in Inventory.";
      }
    }
}  
?>
<!DOCTYPE html>

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
      <form name="simfilter" method="post" action="">
      <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet box yellow">
          <div class="portlet-title">
            <div class="caption"><i class="fa fa"></i>SIM Status</div>
          </div>
          <div class="portlet-body control-box">
            <div class="content-box" id="simFilter" style="">
              <div class="left-item"><span>Mobile No/Sim No.:</span></div>
              <div class="right-item two-filter-inp"><input type="text" name="simstatus" id="sim_phone" value="<?php echo $sim_status; ?>" pattern="[0-9]{10,}" title="Enter 10 & 19 Digit Number" maxlength="19" class="form-control" >
                <div class="right-item"><input onclick="return ValidateNumeric();" class="btn btn-primary" type="submit" name="simStatusBtn" value="search">
                  
                </div>
                <span style="color:red">
                  <?php 
                    if(isset($errMsg1)){ echo $errMsg1; } 

                    if(isset($errMsg2)){ echo $errMsg2; } 

                    if(isset($errMsg3)){ echo $errMsg3; }
                  ?>
                  </span>
              </div>
            </div>
            <div class="content-box" id="simFilter" style="">
              <table class='table borderless'>
                <tr>
                  <td width="15%">Sim Status</td>
                  <td class="s">
                    <?php 
                      for($i=0;$i<count($simcount);$i++){
                        if($simcount[$i]['sim_status'] == 87){
                          echo "DispatchSIM_InStock_Delhi";
                        }
                        if($simcount[$i]['sim_status'] == 88){
                          echo "SimRecevied";
                        }
                        if($simcount[$i]['sim_status'] == 89){
                          echo "SimReassignToInstaller";
                        }
                        if($simcount[$i]['sim_status'] == 90){
                          echo "Sim_AssignedToInstaller";
                        }
                        if($simcount[$i]['sim_status'] == 91){
                          echo "SimInstalled_Used/SimInstalled";
                        }
                        if($simcount[$i]['sim_status'] == 92){
                          echo "Sim_is_Pending_for_Deactivation_At_Sarvesh";
                        }
                        if($simcount[$i]['sim_status'] == 93){
                          echo "SimAssignToRepair_Delhi";
                        }
                        if($simcount[$i]['sim_status'] == 106){
                          echo "SimDeactivationAtStock";
                        }
                        if($simcount[$i]['sim_status'] == 102){
                          echo "VeryOldSim";
                        }
                      }
                      if(isset($errMsg))
                      {
                        echo $errMsg;
                      }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>Recd Date</td>
                  <td class="s">
                  <?php 
                    for($i=0;$i<count($simcount);$i++){
                      echo $simcount[$i]['rec_date'];
                    }
                  ?>
                  </td>
                </tr>
                <tr>
                  <td>Active Status</td>
                  <td class="s">
                  <?php 
                    for($i=0;$i<count($simcount);$i++){
                      if($simcount[$i]['active_status'] == 1){
                        echo "Active";
                      }
                      else{
                        echo "De-Active";
                      }
                    }
                  ?>
                  </td>
                </tr>
                <tr>
                  <td>Branch Name</td>
                  <td class="s">
                    <?php
                        for($i=0;$i<count($simcount);$i++){ 
                          $state=$simcount[$i]['branch_id'];
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
                          if($state == 0){
                            echo "-";
                          }
                        }  
                      ?>
                  </td>
                </tr>
                <tr>
                  <td>Installer Name</td>
                  <td class="s">
                  <?php 
                    for($i=0;$i<count($simcount);$i++){
                      if(($simcount[$i]['sim_status'] == 89) || ($simcount[$i]['sim_status'] == 90) || ($simcount[$i]['sim_status'] == 91) || ($simcount[$i]['sim_status'] == 93))
                      {  
                        if($simcount[$i]['installerID'] == 0){

                            //mysql_query("select installer_name from installer where inst_id='".$sim_statusid[$i]['installerID']."'");
                            echo $simcount[$i]['RepairName'];
                          }
                      }
                      else
                      {
                        echo "-";
                      }  
                    }
                  ?>
                  </td>
                </tr>
              </table>
            </div>
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
      alert("Please Input Mobile No/Sim No.");
      return false;
    } 

    else if (!val.match(/^[0-9]+$/)) {
        alert("Mobile No/Sim No. must be filled with numbers only.");
        return false;
    }

    else{    

        return true; 
    }

    }
  </script>
</body>
</html>