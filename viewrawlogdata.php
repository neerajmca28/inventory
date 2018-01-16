<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
 
$masterObj = new master();
$str = "";
$str2 = "";
if(isset($_POST['submit']))
{
  $device_type = $_POST['devtype'];            
  $deviceimei = $_POST['deviceimei'];
  $date=date('jnY',strtotime($_POST['datepick']));
  $datatype=$_POST['datatype'];
  $RawdatafromURL = file_get_contents('http://trackingexperts.com/debug/debug/inventoryrawdata.php?device_type='.$device_type.'&date='.$date.'&dev_imei='.$deviceimei.'&datatype='.$datatype);
} 
?>
<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
  </head>
<style type="text/css">
  #devimei{
    width: 39%;
  }
  #devdate{
    width: 39%;
  }  
   
}
</style>
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> View Raw Log Data </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover">
          <form method="post" name="rawLogForm" onsubmit="return validateForm()" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td>
                Device Type
              </td>
              <td>
                <select name="devtype" id="myDevice" class="selectpicker" data-show-subtext="true" data-live-search="true"/>
                  <option role="presentation">Select</option>
                  <option role="presentation"<?php if ($_POST['devtype']=="Pointer") echo "selected";?> value="Pointer">Pointer</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="FleeteyeBSTPLITG") echo "selected";?> value="FleeteyeBSTPLITG">FleeteyeBSTPLITG</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="BSTPLBSTPLITG") echo "selected";?>  value="BSTPLBSTPLITG">BSTPLBSTPLITG</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="GeoTracker") echo "selected";?> value="GeoTracker">GeoTracker</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="AVL") echo "selected";?> value="AVL">AVL</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="AEM") echo "selected";?> value="AEM">AEM</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="K10") echo "selected";?> value="K10">K10</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Argus") echo "selected";?> value="Argus">Argus</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="BSTPL") echo "selected";?> value="BSTPL">BSTPL</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="fleeteye") echo "selected";?> value="fleeteye">fleeteye</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="fleeteyeNEW") echo "selected";?> value="fleeteyeNEW">fleeteyeNEW</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="atlanta_vts3mini") echo "selected";?> value="atlanta_vts3mini">atlanta_vts3mini</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="FastTrac") echo "selected";?> value="FastTrac">FastTrac</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Atlanta") echo "selected";?> value="Atlanta">Atlanta</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="EIT") echo "selected";?> value="EIT">EIT</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Securitarian") echo "selected";?> value="Securitarian">Securitarian</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="TelTonika") echo "selected";?> value="TelTonika">TelTonika</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="VTS3") echo "selected";?> value="VTS3">VTS3</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="VTS3_bhopal") echo "selected";?>  value="VTS3_bhopal">VTS3_bhopal</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Gtrac_visiontec_nrxen") echo "selected";?>  value="Gtrac_visiontec_nrxen">Gtrac_visiontec_nrxen</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="TrakM8") echo "selected";?> value="TrakM8">TrakM8</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Vector") echo "selected";?> value="Vector">Vector</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="astra") echo "selected";?> value="astra">astra</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="JM01") echo "selected";?> value="JM01">JM01</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Flipcart") echo "selected";?> value="Flipcart">Flipcart</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="ERM") echo "selected";?>  value="ERM">ERM</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="ITriangular") echo "selected";?>  value="ITriangular">ITriangular</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="FastTracAC") echo "selected";?>  value="FastTracAC">FastTracAC</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="TK110") echo "selected";?> value="TK110">TK110</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="T360101A") echo "selected";?>  value="T360101A">T360101A</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="ATrac") echo "selected";?>  value="ATrac">ATrac</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="Gtrac_GPS103B") echo "selected";?>  value="Gtrac_GPS103B">Gtrac_GPS103B</option>
                  <option role="presentation" <?php if ($_POST['devtype']=="JR10J") echo "selected";?>  value="JR10J">JR10J</option>
                </select>
              </td>
              <td><span id="dataid1"><input type="radio" id="format" name="datatype" style="margin-left:20px;" value="format"  <?php if (isset($_POST['datatype']) && $_POST['datatype']=="format") echo "checked";?>/>&#160;&#160;Format data</span></td>
              <td><span id="dataid2"><input type="radio" id="dataRaw" name="datatype" style="margin-left:10px;" value="raw" <?php if (isset($_POST['datatype']) && $_POST['datatype']=="raw") echo "checked";?>/>&#160;&#160;Raw data</span></td>
            </tr>
            <tr>
              <td>
                Device Imei
              </td>
              <td>
                <input type="text" name="deviceimei" value="<?php echo $deviceimei; ?>" class="form-control" id="devimei">
              </td>
              <td colspan="2">&#160;</td>
            </tr>
            <tr>
              <td>
                Date
              </td>
               <td>
                <input type="text" name="datepick" value="<?php echo date('d-m-Y');?>" class="form-control form_date" id="devdate">
              </td>
              <td colspan="2"><input type="submit" class="btn btn-primary pull-left" style="margin-left:20px"name="submit" id="submit" value="Submit"></td>
            </tr>
            <tr>
              <td>
                DATA
              </td>
              <td colspan="3">
                <textarea rows="10" cols="100" name="rawlog" class="form-control" value="">
                  <?=$RawdatafromURL;?>
                </textarea> 
              </td>
            </tr>
          </tbody>
          </form> 
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
  <script type="text/javascript">
  var $da = jQuery.noConflict();
      $da('.form_date').datetimepicker({      
        autoclose: 1,
        minView: 2,
        format: 'dd-mm-yyyy'
      });
  function validateForm() {
    var devicetype = document.forms["rawLogForm"]["devtype"].value;
	var dataType = document.forms["rawLogForm"]["datatype"].value;
	var deviceimei = document.forms["rawLogForm"]["deviceimei"].value;
	var datePick = document.forms["rawLogForm"]["datepick"].value;
    if (devicetype == "0") {
        alert("Device Type must be filled out");
        return false;
    }
	if (dataType == "") {
        alert("Data Type must be filled out");
        return false;
    }
	if (deviceimei== "") {
        alert("Device Imei must be filled out");
        return false;
    }
	if (datePick == "") {
        alert("Please Select Date");
        return false;
    }
}
  </script>
