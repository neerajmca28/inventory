<?php
include("config.php");
include("include/header.php");
include("device_status.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');

if (isset($_SESSION['branch_id']) &&  !empty($_SESSION['branch_id'])) { 

	if (isset($_GET['deviceid']) &&  !empty($_GET['deviceid'])) {

    $openCaseQuery=mysql_query("select device_removed_problem,device_sno,device_repair.device_imei,device_repair.device_removed_recddate,item_master.item_name,device_repair.client_name,veh_no,device_phone_no,device_repair.device_removed_date from device left join item_master on device.device_type = item_master.item_id left join device_repair ON device.device_imei=device_repair.device_imei where device.device_status=79 and device_repair.current_record=1 and device.device_id='".$_GET['deviceid']."'");
    $rowOpenCase =mysql_fetch_assoc($openCaseQuery);

    //Manufacturer Case

    if (isset($_POST['submit'])) {

      $deviceid = $_GET['deviceid']; // Device ID
      $devicestatus = $Device_Manufacture; // Device Status
      $deviceproblem = $_POST['problems']; // Device Problems
      $devicesentto = "Manufacture";
      $personname = $_POST['pname']; // Person Name
      if(isset($_POST['contact']))
      {
        $contactno = $_POST['contact']; // Contact Number
      }
      else
      {
        $contactno = 0;
      }
      $opencasedate = date("Y-m-d H:i:s"); // Open case date
      $manufacturedate = date("Y-m-d H:i:s"); // Device Manufacture Date
      $manufacturename = $_POST['manufactname']; // Device Manufacture Name
      $manufactureremark = $_POST['manfactremark']; // Device Manufacture Remarks
      
      // if ($_POST['optradio1'] == 1) { $internalrepair = 1; } else { $internalrepair = 0; };
      // echo "CALL SaveRepairOpenCase('".$deviceid."','".$devicestatus."','".$deviceproblem."','".$devicesentto."','".$personname."','".$opencasedate."','".$contactno."','".$manufacturename."','".$manufactureremark."','".$manufacturedate."','".$internalrepair."')";
      // die;
      $repairclosecase=select_Procedure("CALL SaveRepairOpenCase('".$deviceid."','".$devicestatus."','".$deviceproblem."','".$devicesentto."','".$personname."','".$opencasedate."','".$contactno."','".$manufacturename."','".$manufactureremark."','".$manufacturedate."','".$internalrepair."')");
      //print_r($repairclosecase);die();
      header("Location:manufacturereport.php");
    }

    // End Manufacturer Case

    //Internal Case

    if (isset($_POST['submit1'])) {

      $deviceid = $_GET['deviceid']; // Device ID
      $devicestatus = $OpenCaseForRepairedDevice; // Device Status
      $deviceproblem = $_POST['problems']; // Device Problems
      $devicesentto = "Internal"; // Device Sent To
      $personname = $_POST['pname']; // Person Name
      $contactno = $_POST['contact']; // Contact Number
      $opencasedate = date("Y-m-d H:i:s"); // Open Case Date
      $manufactureremark = " "; // Device Manufacture Remarks
      
      $repairclosecase=select_Procedure("CALL SaveRepairOpenCase_Repair('".$deviceid."','".$devicestatus."','".$deviceproblem."','".$devicesentto."','".$personname."','".$opencasedate."','".$contactno."')");
      //print_r($repairclosecase);die();
      header("Location:repairdevice.php");
    }

    // End Internal Case

   }
} 
?>
<!DOCTYPE html>
<html xml:lang="en-IN" lang="en-IN">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Welcome to Inventory223</title>
<link href="file/g.png" rel="shortcut icon" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="<?php echo __SITE_URL;?>/file/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo __SITE_URL;?>/file/bootstrap-dropdownhover.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo __SITE_URL;?>/file/in.css">
<script src="<?php echo __SITE_URL;?>/file/bootstrap-dropdownhover.min.js"></script>
<style type="text/css">
.s{
  text-decoration: bold;
  color:green;
}
#sel1
{
    width: 20%;
}
#scostid
{
	width: 20%;
}
#contactnoid
{
	width: 20%;
}
#personnameid{
	width: 20%;
}
#scostid
{
	width: 20%;
}
#dcaseid{
	width: 50%;
}
</style>
</head>
<body>
  <article>
    <div class="col-md-12 col-12"> 
      <form name="simfilter" method="post" >
      <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet box yellow">
          <div class="portlet-title">
            <div class="caption"><i class="fa fa"></i>Open Repair Case</div>
          </div>
          <div class="portlet-body control-box">
            <div class="content-box" id="simFilter" style="">
              <table class='table borderless' id="someclass">
                <tr>
                  <td width="16%">Cleint Name</td>
                  <td><?php echo $rowOpenCase['client_name']; ?></td>
                </tr>
                <tr>
                  <td>Veh No.</td>
                  <td><?php echo $rowOpenCase['veh_no']; ?></td>
                </tr>
                <tr>
                  <td>Model </td>
                  <td><?php echo $rowOpenCase['item_name']; ?></td>
                </tr>
                <tr>
                  <td>Device SNo.</td>
                  <td><?php echo $rowOpenCase['device_sno']; ?></td>
                </tr>
                <tr>
                  <td>IMEI</td>
                  <td><?php echo $rowOpenCase['device_imei']; ?></td>
                </tr>
                <tr>
                  <td>Device Problem</td>
                  <td><?php echo $rowOpenCase['device_removed_problem']; ?></td>
                </tr>
                <tr>
                  <td>Recd Date</td>
                  <td><?php echo date('d-m-Y H:i:s',strtotime($rowOpenCase['device_removed_recddate'])); ?></td>
                </tr>
                <tr id="selected1">
                  <td>Problems</td>
                  <td>
                    <div class="form-group">
                     <select class="form-control" id="sel1" name="problems">
                      <option value="Software issue">Software issue</option>
                      <option value="No power">No power</option>
                      <option value="Diode short,track Open">Diode short,track Open</option>
                      <option value="Transistors and coil gets faulty ,burnt.">Transistors and coil gets faulty ,burnt.</option>
                      <option value="Antenna faulty">Antenna faulty</option>
                      <option value="LED gets faulty">LED gets faulty</option>
                      <option value="7">Resistance Open</option>
                      <option value="8">Print Open</option>
                      <option value="9">Capacitor Short</option>
                      <option value="10">LED Open</option>
                      <option value="-1">Main Lead Open</option>
                      <option value="-2">No issue</option>
                      <option value="11">Sim Issue(Registration Failed)</option>
                      <option value="12">Sim Issue(GPRS Issue)</option>
                      <option value="13">Sim Issue(GPS Issue)</option>
                      <option value="14">Sim Issue(Sim Deactivated)</option>
                      <option value="15">WaterLogged And Working</option>
                      <option value="16">WaterLogged And Not Working</option>
                      <option value="17">Track Open</option>
                      <option value="18">Diode Short</option>
                      <option value="19">Diode Short And Track Open</option>
                      <option value="20">No Power</option>
                      <option value="21">Module Faulty</option>
                      <option value="22">GPS Problem</option>
                      <option value="23">GSM Problem</option>
                      <option value="24">Physical Damage</option>
                      <option value="25">CPU Faulty</option>
                      <option value="26">SIM Slot Damaged</option>
                      <option value="27">Firmware Up Gradation</option>
                      <option value="28">IC Short</option>
                      <option value="29">Other Problem</option>
                      <option value="30">Immmobilizer Not Working</option>
                      <option value="31">Device Not Responding</option>
                      <option value="32">Device Without Sim</option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Device Sent To</td>
                  <td>
                  	<div class="radio" id="dstatusid">
        					  <label><input type="radio" name="optradio" id="manufactureid" value="1" checked="checked">Manufacturer</label>
        					  <label><input type="radio" name="optradio" id="internalid" value="2">Internal Repair</label>
        					</div>
                  </td>
                </tr>
                <tr id="selected6">
                  <td>Manufacuture Name</td>
                  <td>
                  	<div class="form-group">
                      <select class="form-control" id="sel1" name="manufactname">
                        <option value="VisionTek">VisionTek</option>
                        <option value="AEM">AEM</option>
                        <option value="FastTrack">FastTrack</option>
                        <option value="EIT">EIT</option>
                        <option value="Cansys">Cansys</option>
                        <option value="AVL">AVL</option>
                        <option value="Sensel">Sensel</option>
                        <option value="Poniter">Poniter</option>
                        <option value="Argus">Argus</option>
                        <option value="Teltonika">Teltonika</option>
                        <option value="BSTPL">BSTPL</option>
                        <option value="Fleet eye">Fleet eye</option>
                        <option value="ATLANTA">ATLANTA</option>
                        <option value="GeoTracker">GeoTracker</option>
                        <option value="Amwell">Amwell</option>
                        <option value="Aryaonmitalk">Aryaonmitalk</option>
                        <option value="Real Track">Real Track</option>
                        <option value="JM01">JM01</option>
                        <option value="X-7">X-7</option>
                        <option value="TataFlipment">TataFlipment</option>
                        <option value="Traqmatix">Traqmatix</option>
                        <option value="ERM">ERM</option>
                        <option value="Cert">Cert</option>
                        <option value="JT">JT</option>
                        <option value="Smart Track">Smart Track</option>
                        <option value="Bellin">Bellin</option>
                        <option value="GT02">GT02</option>
                        <option value="ATrack">ATrack</option>
                        <option value="Eagleeye">Eagleeye</option>
                        <option value="Leong 100">Leong 100</option>
                      </select>
            					</div>
                  </td>
                </tr>
                <tr id="selected1">
                  <td>Manufacuture Remarks</td>
                  <td>
                  	<div class="form-group">
          					 <select class="form-control" id="sel1" name="manfactremark">
          						<option value="No Power">No Power</option>
          						<option value="Query Problem">Query Problem</option>
          						<option value="Wrong Authentication Code"> Wrong Authentication Code</option>
          						<option value="Data Problem">Data Problem</option>
          						<option value="Data Problem">Data Problem</option>
          						<option value="Faulty Chipset">Faulty Chipset</option>
          						<option value="CPU Faulty">CPU Faulty</option>
          						<option value="Module Faulty">Module Faulty</option>
          						<option value="Water Logged">Water Logged</option>
          						<option value="Immobilizer Problem">Immobilizer Problem</option>
          						<option value="TCP not dialing">TCP not dialing</option>
          						<option value="Wrong authentication code">Wrong authentication code</option>
          					 </select>
          					</div>
                  </td>
                </tr>
                <tr id="selected8" style="display: none">
                  <td>Person Name</td>
                  <td><input type="text" name="pname" class="form-control" id="personnameid"></td>
                </tr>
                <tr id="selected9" style="display: none">
                  <td>Contact No.</td>
                  <td><input type="text" name="contact" class="form-control" id="contactnoid"></td>
                </tr>
                <tr id="selected7">
                  <td>Internal Repair</td>
                  <td>
                    <div class="form-group">
                      <input type="radio" name="optradio1" checked="checked" value="1">&#160;Yes&#160;&#160;
                      <input type="radio" name="optradio1" value="2">&#160;No
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>&#160;&#160;&#160;</td>
                  <td><input type="submit" name="submit" id="submitid" class="btn btn-primary" value="OPEN CASE">&#160;&#160;&#160;<input type="reset" onclick="<?php $backLnk="repairdevice.php";echo("location.href = '".__SITE_URL."/".$backLnk."';");?>" class="btn btn-primary" value="BACK"></td>
                </tr>
              </table>
            </div>
          </div>
      </form>
    <!-- END BORDERED TABLE PORTLET--> 
    </div>
  </article>
  <script>
  	$(document).ready(function(){
  		$("#selected1").show();
  		$("#selected2").show();
  		$("#selected3").show();
  		$("#selected4").show();
  		$("#selected5").hide();
  		$("#selected6").show();
  		$("#selected7").show();
  		$("#selected8").show();
  		$("#selected9").show();
  		$("input[name$='optradio']").change(function(){
  			var test=$(this).val();
  			if(test == 1){
  				$("#selected1").show();
  				$("#selected2").show();
  				$("#selected3").show();
  				$("#selected4").show();
  				$("#selected5").hide();
  				$("#selected6").show();
  				$("#selected7").hide();
  				$("#selected8").hide();
  				$("#selected9").hide();
  			}
  			if (test == 2) {
  				$("#selected5").show();
  				$("#selected1").hide();
  				$("#selected2").hide();
  				$("#selected3").hide();
  				$("#selected4").hide();
  				$("#selected6").hide();
  				$("#selected7").hide();
  				$("#selected8").show();
  				$("#selected9").hide();
			  }
      });
      $("#internalid").click(function(){
          $("#submitid").attr('name','submit1');
      });
      $("#manufactureid").click(function(){
          $("#submitid").attr('name','submit');
      });
  	});
  </script>
</body>
</html>