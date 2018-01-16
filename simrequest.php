<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}


  $service_provider=select_Procedure("CALL SelectServiceProvider()"); // Is procedure se value select box me aa rhi hai......
   $service_provider=$service_provider[0]; 

  //print_r($_POST);
$errMsg='';
if(isset($_POST['submit'])) 
{

    $nosim = $_POST['no_of_sim'];
    $providername = $_POST['provider_name'];
    if(!(preg_match ("/^([0-9]+)$/", $nosim)))
    {
      $errMsg = "Please insert numeric value";
    }
    else 
    {
      $TotalRequest=$nosim;
    }
    if($_POST['provider_name']=='')
    {
        $errMsg = "Please Select Provider Name";
    }
    else
    {
         $ServiceProviderID=$_POST['provider_name'];
    }
     $RequestedDate=date('Y-m-d H:i:s');
     $Remark=$_POST['remarks'];
     $BranchID=$_SESSION["branch_id"];
     $IsActive=1;
     if($errMsg=='')
     {
       //echo "CALL SaveSimRequest('".$ServiceProviderID."','".$TotalRequest."','".$RequestedDate."','".$Remark."','".$BranchID."','".$IsActive."')"; die;
       $req_sim=select_Procedure("CALL SaveSimRequest('".$ServiceProviderID."','".$TotalRequest."','".$RequestedDate."','".$Remark."','".$BranchID."','".$IsActive."')");
         //echo '<pre>'; print_r($req_sim);echo'</pre>'; die;
        if(count($req_sim)>0)
        {
          $succ_msg='Sim Request Successufully submit';
          echo "<script type='text/javascript'>alert('$succ_msg');</script>";
          ?><script><?php echo("location.href = '".__SITE_URL."/simrequest.php';");?></script><?php
        }
        else
        {
            echo "<script type='text/javascript'>alert('There is some problem in Sim Request');</script>";
        }
    }
    else
    {
      echo "<script type='text/javascript'>alert('$errMsg');</script>";
    }


}  
?>

<body>
<article> 
  <div class="col-12"> 
      <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Request New Sim </div>
      </div>
      <form method="post" onSubmit="">
      <div class="portlet-body control-box">
        <div class="content-box">
          <div class="left-item"> <span>No. of Sim :</span> </div>
          <div class="right-item">
            <input type="text" name="no_of_sim" id="no_of_sim" value="" required class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
            <span style="color:red"><?php if(isset($errMsg)){ echo $errMsg; }?></span>
          </div>
        </div>
        <div class="content-box">
        <div class="left-item"> <span>Provider :</span> </div>
          <div class="right-item" > 
            <select id="provider_name" name="provider_name" class="form-control"  required style="width:45%;display:inline-block;margin-right:5px;" />
              <option value="">Select</option>
              <?php for($i=0;$i<count($service_provider);$i++): ?>
              <option value="<?php echo $service_provider[$i]['id']?>"><?php echo $service_provider[$i]['provider_name'];?></option>
              <?php endfor ?>
            </select> <span style="color:red"><?php if(isset($errMsg)){ echo $errMsg1; }?></span>
          </div>
          <div class="content-box">
            <div class="left-item"> <span> Remarks :</span> </div>
            <div class="right-item"> <input type="text" name="remarks" id="remarks" value="" required class="form-control"></div>
          </div>
          <div class="content-box">
          <div class="left-item"></div>
            <div class="right-item">
              <input class="btn btn-success btnaddsim" name="submit" type="submit" id="submitid" value="Submit">
            <input class="btn btn-primary" name="cancel" type="reset" id="reset" value="Reset">
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</article>
</body>
</html>