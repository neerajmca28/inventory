<?php
error_reporting(0);
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php");

if (isset($_SESSION['branch_id']) &&  !empty($_SESSION['branch_id'])) { 
  
  if (isset($_GET['deviceid']) &&  !empty($_GET['deviceid'])) {

    $closeCaseQuery=mysql_query("select device.device_sno,device_repair.device_imei,device_repair.device_removed_recddate,item_master.item_name,sim.phone_no,device_repair.client_name,device_repair.veh_no,device_repair.device_phone_no,device_repair.device_removed_date,device_repair.opencase_date,device_repair.problem from device left join item_master on device.device_type = item_master.item_id left join device_repair ON device.device_id=device_repair.device_id left join sim ON device.sim_id=sim.sim_id where device.device_status in ('68','109') and device_repair.current_record=1 and device.device_id='".$_GET['deviceid']."'");

    $rowCloseCase = mysql_fetch_assoc($closeCaseQuery);

    //print_r($rowCloseCase);die();

    // Repairable Case

    if (isset($_POST['submit'])) {

      if ($rowCloseCase['device_imei'] < 0) { echo "You can't close this case as device is not giving data"; }
      
      if (isset($_POST['changeimei']) == 1) { $flag=1; $mode=4; $imei=$_POST['newchangeimei']; }
        else { $mode=1; $imei=$rowCloseCase['device_imei']; }
        
      if ($_POST['scost'] == 0) { $sparecost = 0; } else { $sparecost = $_POST['scost']; }
      
      $deviceid = $_GET['deviceid']; // Device ID
      $closecasedate=date("Y-m-d H:i:s"); // Close Case Date
      $devicestatus = $CloseCaseForRepairedDevice; // Device Status    
      $deviceproblem = $_POST['problems']; // Device Problems
          
      $repairclosecase=select_Procedure("CALL SaveRepairCloseCase('".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$deviceproblem."','".$closecasedate."','".$sparecost."')");
      if($repairclosecase){
        header("Location:repairdevice.php");
      }
    }

    // End Repairable Case

    // Dead Case

    if (isset($_POST['submit1'])) {

      $closecasedate=date("Y-m-d H:i:s"); // Device Close Date
      if(isset($_POST['newchangeimei'])){
        $imei = $_POST['newchangeimei']; // Device IMEI
      }
      else{
        $imei = 0;
      }
      
      $mode=2; // Mode
      $deviceid = $_GET['deviceid']; // Device ID
      $devicestatus = $DeadDevice; // Device Status
      $deviceproblem = $_POST['problems']; // Device Problems
      $closecasedate = date("Y-m-d H:i:s"); // Close Case Date

      if ($_POST['scost'] == 0) {

        $sparecost = 0;

      }
      else {

        $sparecost = $_POST['scost']; // Spare Cost
      
      }

      //echo  "'".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$deviceproblem."','".$closecasedate."','".$sparecost."'";die();
      $repairclosecase=select_Procedure("CALL SaveRepairCloseCase('".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$deviceproblem."','".$closecasedate."','".$sparecost."')");
      //print_r($repairclosecase);die();
      if($repairclosecase){
        header("Location:repairdevice.php");
      }  
    }

    // End Dead Case

    // Manufacture Case

    if (isset($_POST['submit2'])) {

      $imei = $_POST['newchangeimei']; // Device IMEI
      $deviceid = $_GET['deviceid']; // Device ID
      $devicestatus = $Device_Manufacture; // Device Status
      $deviceproblem = $_POST['problems']; // Device Problems
      $devicesentto = "Manufacture"; // Device Sent To
      $personname = $_POST['pname']; // Person Name
      $closecasedate = date("Y-m-d H:i:s"); // Close Case Date
     
      if(isset($_POST['contact']))
      {
        $contactno = $_POST['contact']; // Contact Number
      }
      else
      {
        $contactno=0;
      }
      $manufacturename = $_POST['manufactname']; // Device Manufacture Name
      $manufactureremark = $_POST['manfactremark']; // Device Manufacture Remarks
      $manufacturedate = date("Y-m-d H:i:s"); // Device Manufacture Date
     
      if ($_POST['scost'] == 0) {

        $sparecost = 0;

      }
      else {

        $sparecost = $_POST['scost']; // Spare Cost

      }
      if ($_POST['optradio1'] == 1) {

        $internalrepair = 1;
      
      }
      else {

        $internalrepair = 0;

      }
    
      $repairclosecase=select_Procedure("CALL SaveRepaircloseCase1('".$deviceid."','".$devicestatus."','".$deviceproblem."','".$devicesentto."','".$personname."','".$closecasedate."','".$contactno."','".$manufacturename."','".$manufactureremark."','".$manufacturedate."','".$internalrepair."','".$sparecost."')");
      
      header("Location:manufacture_report.php");
   
    }     

    // End Manufacture Case 
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
#newchangeimeiid{
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
      <form name="simfilter" method="post" action="">
      <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet box yellow">
          <div class="portlet-title">
            <div class="caption"><i class="fa fa"></i>Close Repair Case</div>
          </div>
          <div class="portlet-body control-box">
            <div class="content-box" id="simFilter" style="">
              <table class='table borderless' id="someclass">
                <tr>
                  <td width="16%">Cleint Name</td>
                  <td><?php echo $rowCloseCase['client_name']; ?></td>
                </tr>
                <tr>
                  <td>Veh No.</td>
                  <td><?php echo $rowCloseCase['veh_no']; ?></td>
                </tr>
                <tr>
                  <td>Model </td>
                  <td><?php echo $rowCloseCase['item_name']; ?></td>
                </tr>
                <tr>
                  <td>Device SNo.</td>
                  <td><?php echo $rowCloseCase['device_sno']; ?></td>
                </tr>
                <tr>
                  <td>IMEI</td>
                  <td><?php echo $rowCloseCase['device_imei']; ?></td>
                </tr>
                <tr>
                  <td>Open Case Date</td>
                  <td><?php echo date('d-m-Y h:i:s',strtotime($rowCloseCase['opencase_date'])); ?></td>
                  
                </tr>
                <tr>
                  <td>Problem</td>
                  <td><?php echo $rowCloseCase['problem']; ?></td>
                </tr>
                <tr>
                  <td>Device Status</td>
                  <td>
                    <div class="radio" id="dstatusid">
                      <label><input type="radio" name="optradio" id="repairableid" value="1" checked="checked">Repairable</label>
                      <label><input type="radio" name="optradio" id="deadid" value="2">Dead</label>
                      <label><input type="radio" name="optradio" id="manufactureid" value="3">Manufacture</label>
                    </div>
                  </td>
                </tr>
                <tr id="selected5">
                  <td>Dead Case</td>
                  <td>
                    <div class="form-group" id="dcaseid">
                    <textarea class="form-control" rows="5" id="comment"></textarea>
                  </div>
                  </td>
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
                <tr id="selected11">
                  <td>Manufacuture Remarks</td>
                  <td>
                    <div class="form-group">
                     <select class="form-control" id="sel1" name="manfactremark">
                      <option value="No Power">No Power</option>
                      <option value="Query Problem">Query Problem</option>
                      <option value="Wrong Authentication Code"> Wrong Authentication Code</option>
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
                <tr id="selected1">
                  <td>Problems</td>
                  <td>
                    <div class="form-group">
                     <select class="form-control" name="problems" id="sel1">
                      <option value="Software issue">Software issue</option>
                      <option value="No power">No power</option>
                      <option value="Diode short,track Open">Diode short,track Open</option>
                      <option value="Transistors and coil gets faulty ,burnt.">Transistors and coil gets faulty ,burnt.</option>
                      <option value="Antenna faulty">Antenna faulty</option>
                      <option value="LED gets faulty">LED gets faulty</option>
                      <option value="Resistance Open">Resistance Open</option>
                      <option value="Print Open">Print Open</option>
                      <option value="Capacitor Short">Capacitor Short</option>
                      <option value="LED Open">LED Open</option>
                      <option value="Main Lead Open">Main Lead Open</option>
                      <option value="No issue">No issue</option>
                      <option value="Sim Issue(Registration Failed)">Sim Issue(Registration Failed)</option>
                      <option value="Sim Issue(GPRS Issue)">Sim Issue(GPRS Issue)</option>
                      <option value="Sim Issue(GPS Issue)">Sim Issue(GPS Issue)</option>
                      <option value="Sim Issue(Sim Deactivated)">Sim Issue(Sim Deactivated)</option>
                      <option value="WaterLogged And Working">WaterLogged And Working</option>
                      <option value="WaterLogged And Not Working">WaterLogged And Not Working</option>
                      <option value="Track Open">Track Open</option>
                      <option value="Diode Short">Diode Short</option>
                      <option value="Diode Short And Track Open">Diode Short And Track Open</option>
                      <option value="No Power">No Power</option>
                      <option value="Module Faulty">Module Faulty</option>
                      <option value="GPS Problem">GPS Problem</option>
                      <option value="GSM Problem">GSM Problem</option>
                      <option value="Physical Damage">Physical Damage</option>
                      <option value="CPU Faulty">CPU Faulty</option>
                      <option value="SIM Slot Damaged">SIM Slot Damaged</option>
                      <option value="Firmware Up Gradation">Firmware Up Gradation</option>
                      <option value="IC Short">IC Short</option>
                      <option value="Other Problem">Other Problem</option>
                      <option value="Immmobilizer Not Working">Immmobilizer Not Working</option>
                      <option value="Device Not Responding">Device Not Responding</option>
                      <option value="Device Without Sim">Device Without Sim</option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr id="selected2">
                  <td>Change IMEI</td>
                  <td><input type="checkbox" name="changeimei" id="changeimeiid"></td>
                </tr>
                <tr id="selected10" style="display:none">
                  <td>New IMEI</td>
                  <td><input type="text" class="form-control" name="newchangeimei" id="newchangeimeiid"></td>
                </tr>
                <tr id="selected3">
                  <td>Spare Part</td>
                  <td>
                    <div class="form-group">
                     <select class="form-control" id="sel1">
                      <option value="0">Select the Spare Part</option>
                      <option value="1">CPU</option>
                      <option value="2">MODULE</option>
                      <option value="3">ANTENNA</option>
                      <option value="4">CPU+MODULE</option>
                      <option value="5">CPU+ANTENNA</option>
                      <option value="6">MODULE+ANTENNA</option>
                      <option value="7">CPU+MODULE+ANTENNA</option>
                    </select>
                    </div>
                  </td>
                </tr>
                <tr id="selected4" style="display:none">
                  <td>Spare Cost</td>
                  <td><input type="text" class="form-control" name="scost" id="scostid"></td>
                </tr>
                
                <tr id="selected8" style="display: none">
                  <td>Person Name</td>
                  <td><input type="text" class="form-control" id="personnameid" name="pname"></td>
                </tr>
                
                <tr id="selected9" style="display: none">
                  <td>Contact No.</td>
                  <td><input type="text" class="form-control" id="contactnoid" name="contact"></td>
                </tr>
                <tr>
                  <td>&#160;&#160;&#160;</td>
                  <td><input type="submit" class="btn btn-primary" name="submit" id="submitid" value="CLOSE">&#160;&#160;&#160;<input type="reset" onclick="<?php $backLnk="repairdevice.php";echo("location.href = '".__SITE_URL."/".$backLnk."';");?>" class="btn btn-primary" value="BACK"></td>
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
      $("#selected6").hide();
      $("#selected7").hide();
      $("#selected8").hide();
      $("#selected9").hide();
      $("#selected10").hide();
      $("input[name$='optradio']").change(function(){
        var test=$(this).val();
        if(test == 1){
          alert("2");
          $("#selected1").show();
          $("#selected2").show();
          $("#selected3").show();
          $("#selected4").show();
          $("#selected5").hide();
          $("#selected6").hide();
          $("#selected7").hide();
          $("#selected8").hide();
          $("#selected9").hide();

            if ($("#changeimeiid").is(':checked')){
                alert("1")
                $("#selected10").show();  // checked
            }
            else {
                alert("3")
                $("#selected10").hide();  // checked
            }

          
          
        }
        if(test == 2){
          $("#selected5").show();
          $("#selected1").hide();
          $("#selected2").hide();
          $("#selected3").hide();
          $("#selected4").hide();
          $("#selected6").hide();
          $("#selected7").hide();
          $("#selected8").hide();
          $("#selected9").hide();
          $("#selected10").hide();
        }
        if(test == 3){
          $("#selected11").show();
          $("#selected6").show();
          $("#selected7").show();
          $("#selected8").show();
          $("#selected9").show();
          $("#selected1").hide();
          $("#selected2").hide();
          $("#selected3").show();
          $("#selected4").show();
          $("#selected5").hide();
          $("#selected10").hide();
        }
      });
      $('#repairableid').click(function() {
        $("#submitid").attr('name','submit'); //Change 28-01-2017 
        // $("#submitid").attr('name','submit');
      });
      $('#deadid').click(function() {
        $("#submitid").attr('name','submit1');
      });
      $('#manufactureid').click(function() {
        $("#submitid").attr('name','submit2');
      });
    });
  </script>
</body>
</html>