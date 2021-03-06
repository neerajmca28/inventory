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
                   
                  <option role="presentation" <?php if ($_POST['devtype']=="JM01") echo "selected";?> value="JM01">JM01</option> 
                </select>
              </td>
              <td> </td>
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
