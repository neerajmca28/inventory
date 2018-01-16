<?php
//echo "1";die();
error_reporting(0);
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php");

if (isset($_SESSION['branch_id']) &&  !empty($_SESSION['branch_id'])) { 
  
  if (isset($_GET['deviceid']) &&  !empty($_GET['deviceid'])) {

    $closeCaseQuery=mysql_query("select device.device_sno,device_repair.device_imei,device_repair.device_removed_recddate,item_master.item_name,sim.phone_no,device_repair.client_name,device_repair.veh_no,device_repair.device_phone_no,device_repair.device_removed_date,device_repair.opencase_date,device_repair.problem from device left join item_master on device.device_type = item_master.item_id left join device_repair ON device.device_id=device_repair.device_id left join sim ON device.sim_id=sim.sim_id where device.device_status in ('68','109') and device_repair.current_record=1 and device.device_id='".$_GET['deviceid']."'");

    $rowCloseCase = mysql_fetch_assoc($closeCaseQuery);

    //echo "<pre>", print_r($rowCloseCase);die();
    
    // Select New Sim No

    $dev_searchid=select_Procedure("CALL SelectSimNo()");
    $dev_searchid=$dev_searchid[0];

    // End Select New Sim No

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
      $newDeviceProblem = explode("##", $deviceproblem); // Split Value
      //print_r($newDeviceProblem);die();
      //echo $newDeviceProblem[0];
      

      if($newDeviceProblem[0] == 11 || $newDeviceProblem[0] == 12 || $newDeviceProblem[0] == 13 || $newDeviceProblem[0] == 14 || $newDeviceProblem[0] == 32)
      {
          $devicestatus = $FinalAttachSim;       
          $newphoneno = $_POST['phno']; // SIM Id
          $phone_no = explode('##',$newphoneno); // Phone No 
          $deviceimei = $rowCloseCase['device_imei'];
		  //echo "CALL AttachPhoneNoAndDeactivate('".$deviceid."','".$newphoneno."','".$devicestatus."')";die();
          //$simattached=select_Procedure("CALL AttachPhoneNoAndDeactivate('".$deviceid."','".$newphoneno."','".$devicestatus."')");

		  $simattached=select_Procedure("CALL AttachPhoneNoAndDeactivate('".$deviceid."','".$phone_no[0]."','".$devicestatus."')");
          //$id = $installer_view[$i]['InstallerID'];
          //echo "select installer.inst_name from internalsoftware.installer where inst_id='".$id."'";die();
          //
          //echo "update mobile_simcards set mobile_no='".$phone_no[1]."' where id in (select sys_simcard from devices where devices.imei='".$deviceimei."')";
          $strSqlQuery =db__select_matrix("update mobile_simcards set mobile_no='".$phone_no[0]."' where id in (select sys_simcard from devices where devices.imei='".$deviceimei."')");
          header("Location:repairdevice.php");
      }
      else{
        //echo "CALL SaveRepairCloseCase('".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$deviceproblem."','".$closecasedate."','".$sparecost."')";die();
        $repairclosecase=select_Procedure("CALL SaveRepairCloseCase('".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$newDeviceProblem[1]."','".$closecasedate."','".$sparecost."')");
        if($repairclosecase){
          header("Location:repairdevice.php");
        }
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
      $newDeviceProblem = explode("##", $deviceproblem); // Split Value
      $closecasedate = date("Y-m-d H:i:s"); // Close Case Date

      if ($_POST['scost'] == 0) {

        $sparecost = 0;

      }
      else {

        $sparecost = $_POST['scost']; // Spare Cost
      
      }

      //echo  "'".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$deviceproblem."','".$closecasedate."','".$sparecost."'";die();
      $repairclosecase=select_Procedure("CALL SaveRepairCloseCase('".$deviceid."','".$mode."','".$imei."','".$devicestatus."','".$newDeviceProblem[1]."','".$closecasedate."','".$sparecost."')");
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
      $newDeviceProblem = explode("##", $deviceproblem); // Split Value
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
    //echo "CALL SaveRepaircloseCase1('".$deviceid."','".$devicestatus."','".$deviceproblem."','".$devicesentto."','".$personname."','".$closecasedate."','".$contactno."','".$manufacturename."','".$manufactureremark."','".$manufacturedate."','".$internalrepair."','".$sparecost."')";die();
      $repairclosecase=select_Procedure("CALL SaveRepaircloseCase1('".$deviceid."','".$devicestatus."','".$newDeviceProblem[1]."','".$devicesentto."','".$personname."','".$closecasedate."','".$contactno."','".$manufacturename."','".$manufactureremark."','".$manufacturedate."','".$internalrepair."','".$sparecost."')");
      
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
#problemsid{
  width: 20%;
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
                  <td>
                    <?php
                    
                      echo date('d-m-Y h:i:s',strtotime($rowCloseCase['opencase_date']));
                     
                    ?>
                  </td>
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
                <tr id="selected1">
                  <td>Dead Case</td>
                  <td>
                    <div class="form-group" id="dcaseid">
                    <textarea class="form-control" rows="2" cols="20" id="comment" style="height: 46px; width: 419px; display: inline;"></textarea><span style="color: Red; display: inline;">Cannot be blank</span>
                  </div>
                  </td>
                </tr>
                <tr id="selected2">
                  <td>Internal Repair</td>
                  <td>
                    <div class="form-group">
                      <input type="radio" name="optradio1" checked="checked" value="1">&#160;Yes&#160;&#160;
                      <input type="radio" name="optradio1" value="2">&#160;No
                    </div>
                  </td>
                </tr>
                <tr id="selected3">
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
                <tr id="selected4">
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
                <tr id="selected5">
                  <td>Problems</td>
                  <td>
                    <!-- <div class="form-group">
                     <select  name="problems" class="form-control" id="problemsid">
                      <option value="0">Please Select</option>
                      <option value="1">Software issue</option>
                      <option value="2">No power</option>
                      <option value="3">Diode short,track Open</option>
                      <option value="4">Transistors and coil gets faulty ,burnt.</option>
                      <option value="5">Antenna faulty</option>
                      <option value="6">LED gets faulty</option>
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
                    </div> -->
                    <div class="form-group">
                     <select  name="problems" class="form-control" id="problemsid">
                      <option value="0">Please Select</option>
                      <option value="1##Software issue">Software issue</option>
                      <option value="2##No power">No power</option>
                      <option value="3##Diode short,track Open">Diode short,track Open</option>
                      <option value="4##Transistors and coil gets faulty ,burnt">Transistors and coil gets faulty ,burnt</option>
                      <option value="5##Antenna faulty">Antenna faulty</option>
                      <option value="6##LED gets faulty">LED gets faulty</option>
                      <option value="7##Resistance Open">Resistance Open</option>
                      <option value="8##Print Open">Print Open</option>
                      <option value="9##Capacitor Short">Capacitor Short</option>
                      <option value="10##LED Open">LED Open</option>
                      <option value="-1##Main Lead Open">Main Lead Open</option>
                      <option value="-2##No issue">No issue</option>
                      <option value="11##Sim Issue(Registration Failed)">Sim Issue(Registration Failed)</option>
                      <option value="12##Sim Issue(GPRS Issue)">Sim Issue(GPRS Issue)</option>
                      <option value="13##Sim Issue(GPS Issue)">Sim Issue(GPS Issue)</option>
                      <option value="14##Sim Issue(Sim Deactivated)">Sim Issue(Sim Deactivated)</option>
                      <option value="15##WaterLogged And Working">WaterLogged And Working</option>
                      <option value="16##WaterLogged And Not Working">WaterLogged And Not Working</option>
                      <option value="17##Track Open">Track Open</option>
                      <option value="18##Diode Short">Diode Short</option>
                      <option value="19##Diode Short And Track Open">Diode Short And Track Open</option>
                      <option value="20##No Power">No Power</option>
                      <option value="21##Module Faulty">Module Faulty</option>
                      <option value="22##GPS Problem">GPS Problem</option>
                      <option value="23##GSM Problem">GSM Problem</option>
                      <option value="24##Physical Damage">Physical Damage</option>
                      <option value="25##CPU Faulty">CPU Faulty</option>
                      <option value="26##SIM Slot Damaged">SIM Slot Damaged</option>
                      <option value="27##Firmware Up Gradation">Firmware Up Gradation</option>
                      <option value="28##IC Short">IC Short</option>
                      <option value="29##Other Problem">Other Problem</option>
                      <option value="30##Immmobilizer Not Working">Immmobilizer Not Working</option>
                      <option value="31##Device Not Responding">Device Not Responding</option>
                      <option value="32##Device Without Sim">Device Without Sim</option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr id="selected6">
                  <td>Change IMEI</td>
                  <td><input type="checkbox" name="changeimei" id="changeimeiid"></td>
                </tr>
                <tr id="selected7" style="display:none">
                  <td>New IMEI</td>
                  <td><input type="text" class="form-control" name="newchangeimei" id="newchangeimeiid"></td>
                </tr>
                <tr id="selected8">
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
                <tr id="selected9" style="display:none">
                  <td>Spare Cost</td>
                  <td><input type="text" class="form-control" name="scost" id="scostid"></td>
                </tr>
                
                <tr id="selected10" style="display: none">
                  <td>Person Name</td>
                  <td><input type="text" class="form-control" id="personnameid" name="pname"></td>
                </tr>
                
                <tr id="selected11" style="display: none">
                  <td>Contact No.</td>
                  <td><input type="text" class="form-control" id="contactnoid" name="contact"></td>
                </tr>

                <tr id="selected12" style="display: none">
                  <td>Old Phone No</td>
                  <td><input type="text" class="form-control" id="contactnoid" value="<?php echo $rowCloseCase['phone_no']; ?>"></td>
                </tr>

                <tr id="selected13" style="display: none">
                  <?php 
                    for($j=0;$j<count($dev_searchid);$j++){
                      $select .= '<option value="'.$dev_searchid[$j]['sim_id']."##".$dev_searchid[$j]['phone_no'].'">'.$dev_searchid[$j]['phone_no'].'</option>';
                    }
                  ?>    
                  <td>New Phone No</td> 
                  <td>  
                    <select name="phno" id="simno">
                      <option value="0">--SELECT--</option>
                      <?php echo $select; ?>
                    </select>
                  </td>  
                </tr>
                <tr>
                  <td>&#160;&#160;&#160;</td>
                  <td><input type="submit" class="btn btn-primary" name="submit" id="submitid" onclick="javascript:return confirm('Are you sure close this case?')" value="CLOSE">&#160;&#160;&#160;<input type="reset" onclick="<?php $backLnk="repairdevice.php";echo("location.href = '".__SITE_URL."/".$backLnk."';");?>" class="btn btn-primary" value="BACK"></td>
                </tr>
              </table>
            </div>
          </div>
      </form>
    <!-- END BORDERED TABLE PORTLET--> 
    </div>
  </article>
  <script>

  var $closeReapairCase = jQuery.noConflict();

    $closeReapairCase(document).ready(function(){

      $closeReapairCase("#selected1").hide();
      $closeReapairCase("#selected2").hide();
      $closeReapairCase("#selected3").hide();
      $closeReapairCase("#selected4").hide();
      $closeReapairCase("#selected5").show();
      $closeReapairCase("#selected6").show();
      $closeReapairCase("#selected7").hide();
      $closeReapairCase("#selected8").show();
      $closeReapairCase("#selected9").show();
      $closeReapairCase("#selected10").hide();
      $closeReapairCase("#selected11").hide();
      $closeReapairCase("#selected12").hide();
      $closeReapairCase("#selected13").hide();


      $closeReapairCase('#problemsid').change(function(){
          var id = $closeReapairCase('#problemsid :selected').val();
          var res = id.split("##");
          //alert(res[0])
          if(res[0] == '11' || res[0] == '12'|| res[0] == '13' || res[0] == '14' || res[0] =='32'){
            $closeReapairCase("#selected12").show();
            $closeReapairCase("#selected13").show();
          }
          else{
            $closeReapairCase("#selected12").hide();
            $closeReapairCase("#selected13").hide();
          }

       });   
   
      
      var changeImei = document.getElementById('changeimeiid');
      changeImei.onchange = function() {
          console.log(changeImei);
          if (changeImei.checked) {
              $closeReapairCase("#selected7").show();
          } else {
              $closeReapairCase("#selected7").hide();
        }
      }
      
      $closeReapairCase("input[name$='optradio']").change(function(){

        var test=$closeReapairCase(this).val();

        if(test == 1){ 
         
          $closeReapairCase("#selected1").hide();
          $closeReapairCase("#selected2").hide();
          $closeReapairCase("#selected3").hide();
          $closeReapairCase("#selected4").hide();
          $closeReapairCase("#selected5").show();
          $closeReapairCase("#selected6").show();
          $closeReapairCase("#selected7").hide();
          $closeReapairCase("#selected8").show();
          $closeReapairCase("#selected9").show();
          $closeReapairCase("#selected10").hide();
          $closeReapairCase("#selected11").hide();
          $closeReapairCase("#selected12").hide();
          $closeReapairCase("#selected13").hide();


          //if($closeReapairCase('input[type="checkbox"]').is(':checked'){ alert("1")});
        }
        if(test == 2){
          $closeReapairCase("#selected1").show();
          $closeReapairCase("#selected2").hide();
          $closeReapairCase("#selected3").hide();
          $closeReapairCase("#selected4").hide();
          $closeReapairCase("#selected5").hide();
          $closeReapairCase("#selected6").hide();
          $closeReapairCase("#selected7").hide();
          $closeReapairCase("#selected8").hide();
          $closeReapairCase("#selected9").hide();
          $closeReapairCase("#selected10").hide();
          $closeReapairCase("#selected11").hide();
          $closeReapairCase("#selected12").hide();
          $closeReapairCase("#selected13").hide();

        }
        if(test == 3){
          $closeReapairCase("#selected1").hide();
          $closeReapairCase("#selected2").show();
          $closeReapairCase("#selected3").show();
          $closeReapairCase("#selected4").show();
          $closeReapairCase("#selected5").hide();
          $closeReapairCase("#selected6").hide();
          $closeReapairCase("#selected7").hide();
          $closeReapairCase("#selected8").show();
          $closeReapairCase("#selected9").show();
          $closeReapairCase("#selected10").show();
          $closeReapairCase("#selected11").show();
          $closeReapairCase("#selected12").hide();
          $closeReapairCase("#selected13").hide();
        }
      });
      $closeReapairCase('#repairableid').click(function() {
        $closeReapairCase("#submitid").attr('name','submit'); //Change 28-01-2017 
        // $closeReapairCase("#submitid").attr('name','submit');
      });
      $closeReapairCase('#deadid').click(function() {
        $closeReapairCase("#submitid").attr('name','submit1');
      });
      $closeReapairCase('#manufactureid').click(function() {
        $closeReapairCase("#submitid").attr('name','submit2');
      });
    });
  </script>
</body>
</html>