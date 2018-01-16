<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
 
$masterObj = new master();
$data=select_Procedure("CALL SelectDevType()");
$data=$data[0];
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
<body onload="hideDevice()">
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> View Raw Log Data </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover">
          <form method="post" action="" name="" enctype="multipart/form-data">
          <tbody>
            <tr>
              <td>
                Device Type
              </td>
              <td>
                 


		<select name="devtype" id="myDevice" onchange="myDeviceid()" class="form-control"/>
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
                <td><span id="dataid1"><input type="radio" id="format" name="datatype" style="margin-left:20px;" value="format" />&#160;&#160;Format data</span></td>
                <td><span id="dataid2"><input type="radio" id="dataRaw" name="datatype" style="margin-left:10px;" value="raw" checked />&#160;&#160;Raw data</span></td>
              </td>
            </tr>
            <tr>
              <td>
                Device Imei
              </td>
              <td colspan="3">
                <input type="text" name="deviceimei" class="form-control" value=<?php echo $deviceimei ?> >
              </td>
            </tr>
            <tr>
              <td>
                Date
              </td>
               <td colspan="3">
				<input type="text" name="datepick" value="<?php echo $_POST['datepick']; ?>" class="form-control form_date" />
              </td>
            </tr>
			<tr>
                <td colspan="2"><input type="submit" class="btn btn-primary pull-right btn-sm RbtnMargin" name="submit" id="submit" value="Submit"></td>
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

</body>
</html>
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
    for(i=1;i<=<?php echo count($data); ?>;i++){
      
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

  function myDeviceid() {
    var x = document.getElementById("myDevice").value;
    if(x=="Pointer" || x=="TK110" || x=="JM01" || x=="T360101A" || x=="FastTracAC" || x=="ERM" || x=="ITriangular" || x=="fleeteye" || x=="fleeteyeNEW" || x=="TelTonika" || x=="Atlanta"  || x=="TrakM8" || x=="Securitarian"){
    document.getElementById("dataid1").style.display = "block";
    document.getElementById("dataid2").style.display = "block";
    }
	else
	{
		 document.getElementById("dataid1").style.display = "none";
		document.getElementById("dataid2").style.display = "none";
	}
  }
  function hideDevice(){
    document.getElementById("dataid1").style.display = "none";
    document.getElementById("dataid2").style.display = "none";
  }
</script>
<script type="text/javascript">

var $da = jQuery.noConflict();


    $da('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $da('.form_date').datetimepicker({
       // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $da('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });

</script>
</html>