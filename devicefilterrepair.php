<?php
error_reporting(0);
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

  //Select Data Filtering By Device Type And Status
  $devstatus=select_Procedure("CALL SelectDevStatus(-1)");
  $devstatus=$devstatus[0];
  //$devtype=select_Procedure("CALL SelectDevType(-1)");
  //$devtype=$devtype[0];

  //Select Data Filtering By Client Name
  $dataclient=select_Procedure("CALL SearchClient_data()");
  $dataclient=$dataclient[0];
  
?>
<style type="text/css">
.loading
{
    width: 16px;
    height: 16px;
    background:transparent url('loading.gif') no-repeat 0 0;
    font-size: 0px;
    display: inline-block;
}
</style>
<body>
		<div class="processing-img" id="loadingmessage" style='display:none;'>
			<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
			</div>
	<article>
		<div class="col-12"> 
		<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box yellow">
				<div class="portlet-title">
					<div class="caption"> <i class="fa fa"></i>Search By</div>
				</div>
				<div class="portlet-body">
					<form method="post">
						<div class="radio">
								<label><input type="radio" name="optradio" value="1" checked="checked">Device IMEI</label>
								<label><input type="radio" name="optradio" value="2">Client Name</label>
								<label><input type="radio" name="optradio" value="3">Device Type</label>
                <label><input type="radio" name="optradio" value="4">Change IMEI</label>
								<div id="fiter1" class="devfilter">
  								<table class="table table-bordered table-hover">
  								<thead>
  									<tr>
  										<td>Filtering By Device IMEI</td>
  									</tr>
  									<tr>
  										<td><input type="text" id="devimei" class="form-control" style="width:20%"></td>
  									</tr>
  									<tr>
  										<td><input type="button" class="btn btn-primary" id="submit1" value="SEARCH"></td>
  									</tr>
  								</table>
                  <div id="errmsg1" style="color:red"></div>
                </div>
                <div id="fiter2" class="devfilter">  
  								<table class="table table-bordered table-hover">
  								<thead>
  									<tr>
  										<td colspan="2">Filtering By Client Name</td>
  									</tr>
  									<tr> 
                      <td>   
                        Client Name
                      </td>
                      <td>
                        <select id="searchclient" />
                        <option role="presentation" value="0">ALL</option>  
                        <?php 
                          for($i=0;$i<count($dataclient);$i++){
                        ?>
                        <option role="presentation" value="<?php echo $dataclient[$i]['client_name']; ?>"><?php echo $dataclient[$i]['client_name']; ?></option>
                        <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Start Date
                      </td>
                      <td>
                        <input type="text" id="datepick1" class="form-control form_date">
                      </td>
                    </tr>
                    <tr>  
                      <td>   
                        End Date
                      </td>
                      <td>
                        <input type="text" id="datepick2" class="form-control form_date">
                      </td>
                    </tr>
  									<tr>
  										<td colspan="2"><input type="button" class="btn btn-primary" id="submit2" value="SEARCH"></td>
  									</tr>
  								</table>
                  <div id="errmsg2" style="color:red"></div>
                </div>
                <div id="fiter3" class="devfilter"> 
  								<table class="table table-bordered table-hover">
  								<thead>
  									<tr>
  										<td>Filtering By Device ID</td>
  									</tr>
  									<tr>
  										<td>
  											<span><input type="text" id="devid" class="form-control" style="width:20%"></span>
  										</td>
                    <tr>  
  									<tr>
  										<td><input type="button" class="btn btn-primary" id="submit3" value="SEARCH"></td>
  									</tr>
  								</table>
                </div> 
                <div id="fiter4" class="devfilter">  
  								<table class="table table-bordered table-hover">
  								<thead>
  									<tr>
  										<td colspan="2">Filtering By Changed IMEI</td>
  									</tr>
  									<tr>
                      <td colspan="2">
                        <label style="margin-left:20px;"><input type="radio" name="opradio" value="1" checked="checked">Client IMEI</label>
                        <label style="margin-left:20px;"><input type="radio" name="opradio" value="2">Old Device IMEI</label>
                      </td>
                    </tr>
                    <div class="devcname">
                      <table id="cname1" class="table table-bordered table-hover" value="1">
    									<tr> 
                        <td>   
                          <span style="margin-left:20px;">Client Name</span>
                        </td>
                        <td>
                          <select id="searchclient1" />
                          <option role="presentation" value="0">Select Cleint Name</option>  
                          <?php 
                            for($i=0;$i<count($dataclient);$i++){
                          ?>
                          <option role="presentation" value="<?php echo $dataclient[$i]['client_name']; ?>"><?php echo $dataclient[$i]['client_name']; ?></option>
                          <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2"><input type="button" class="btn btn-primary" id="submit5" value="SEARCH" style="margin-left:20px;"></td>
                      </tr>
                    </table>
                    </div>
                    <div>
                    <table class="table table-bordered table-hover" id="cname2" style="display:none" value="2">  
                      <tr> 
                        <td>   
                          <span style="margin-left:20px;">Old Device IMEI </span>
                        </td>
                        <td>
                          <input type="text" class="form-control" id="olddevice" style="width:310px">
                        </td>
                      </tr>
                      <tr>
    										<td colspan="2"><input type="button" class="btn btn-primary" id="submit6" value="SEARCH" style="margin-left:20px;"></td>
    									</tr>
                    </div>  
  								</table>
                </div>  
							</div>
						</form>
            <div id="divTable" value="1" >
              <table class="table" id="filtertable">
                <thead>
                  <tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
                    <th scope="col">Device Id</th>
                    <th scope="col">ITGC Id</th>
                    <th scope="col">Device Sno.</th>
                    <th scope="col">Device IMEI</th>
                    <th scope="col">OpenCaseDate</th>
                    <th scope="col">CloseCaseDate</th>
                    <th scope="col">Device Removed Problem</th>
                    <th scope="col">Intial Problem at OpenCase</th>
                    <th scope="col">Actual Problem at CloseCase</th>
                    <th scope="col">Vehicle No</th>
                    <th scope="col">Client Name</th>
                  </tr>
                </thead>
                <tbody id="filterId">
                </tbody>
                <tr style="color:White;background-color:#5D7B9D;font-weight:bold;" >
                      <td colspan="11" align="center" id="footerId">
                      </td>  
                    </tr> 
              </table>
            </div>
            <div id="divTable2" value="2">
              <table class="table">
                <thead>
                  <tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
                    <th scope="col">Device Id</th>
                    <th scope="col">Old Device Imei</th>
                    <th scope="col">New Device Imei</th>
                    <th scope="col">Old Client Name</th>
                    <th scope="col">Old Vehicle No</th>
                    <th scope="col">New Vehicle NO</th>
                    <th scope="col">Old Itgc Id</th>
                    <th scope="col">New Itgc Id</th>
                  </tr>
                </thead>
                <tbody id="filterId1">
                </tbody>
                <tr style="color:White;background-color:#5D7B9D;font-weight:bold;" >
                      <td colspan="11" align="center" id="footerId">
                      </td>  
                    </tr> 
              </table>
            </div>   
					</div>
   
			</div>
		<!-- END BORDERED TABLE PORTLET--> 
		</div>
		
	</article>
  <script>
    $(document).ready(function() {
			$( document ).ajaxStart(function() {
	     //document.getElementById('divTable').style.display = "none";
      $( "#loadingmessage" ).show();
      });
  	    $( document ).ajaxStop(function() {
        $( "#loadingmessage" ).hide();
      });

	
	    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
       // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
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
      
      $("#fiter1").show();
      $("#fiter2").hide();
      $("#fiter3").hide();
      $("#fiter4").hide();
      $("#fiter5").hide();  
      $("#fiter6").hide();
      $("#divTable").hide(); 
      $("#divTable2").hide();
      $("#loading-image").hide();

      var numericExpression = /^[0-9]+$/;   

       $("input[name$='optradio']").change(function() {
          
          $("#divTable").hide(); 
          $("#divTable2").hide();

          var test = $(this).val();
          if(test == 1) {
            $("#fiter1").show();
            $("#fiter2").hide();
            $("#fiter3").hide();
            $("#fiter4").hide();
            $("#fiter5").hide();  
            $("#fiter6").hide();
            $("#cname2").hide();
            $("#devimei").val("");
          }
          if(test == 2) {
            $("#fiter1").hide();
            $("#fiter2").show();
            $("#fiter3").hide();
            $("#fiter4").hide();
            $("#fiter5").hide();  
            $("#fiter6").hide();
            $("#cname2").hide();
            $("#devimei").val(""); 
          }
          if(test == 3) {
            $("#fiter1").hide();
            $("#fiter2").hide();
            $("#fiter3").show();
            $("#fiter4").hide();
            $("#fiter5").hide();  
            $("#fiter6").hide(); 
            $("#cname2").hide();
            $("#devimei").val("");
          }
          if(test == 4) {
            $("#fiter1").hide();
            $("#fiter2").hide();
            $("#fiter3").hide();
            $("#fiter4").show();
            $("#fiter5").hide();  
            $("#fiter6").hide();
            $("#cname2").hide();
            $("#devimei").val(""); 
          }
          if(test == 5) {
            $("#fiter1").hide();
            $("#fiter2").hide();
            $("#fiter3").hide();
            $("#fiter4").hide();
            $("#fiter5").show();  
            $("#fiter6").hide();
            $("#cname2").hide();
            $("#devimei").val(""); 
          }
          if(test == 6) {
            $("#fiter1").hide();
            $("#fiter2").hide();
            $("#fiter3").hide();
            $("#fiter4").hide();
            $("#fiter5").hide();  
            $("#fiter6").show();
            $("#cname1").show();
            $("#cname2").hide();
            $("#devimei").val("");
          }
      });

      $("input[name$='opradio']").change(function(){

        $("#divTable2").hide();

        var test1 = $(this).val();

        if(test1 == 1) {
          $("#cname1").show();
          $("#cname2").hide();
        }

        if(test1 == 2) {
          $("#cname1").hide();
          $("#cname2").show();
        }
      });  
     
    $("#submit1").click(function(){
    
      var deviceimei = $("#devimei").val();
      //alert(deviceimei)  ;

      var dataString = 'dimei='+ deviceimei;
        if(deviceimei=='')
        {
          alert("Please Fill All Fields");
        }
        else if(!deviceimei.match(numericExpression))
        {
          alert("Device IMEI must be filled with numbers only");
          return false;
        }
        else
        {
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_devicefilterrepair.php",
            data: dataString,
            cache: false,
            success: function(data){
             //alert(data)

               if(data == "Error") { 
                
                  document.getElementById("errmsg1").innerHTML = "<b>*Record Not Found</b>"; 
                  document.getElementById("loadingmessage").style.display = "none";
              }
              else{
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].itgc_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].device_imei + '</td><td id="e">' + data[i].opencase_date + '</td><td id="f">' + data[i].closecase_date+ '</td><td id="g">' + data[i].device_removed + '</td><td id="h">' + data[i].problem + '</td><td id="i">' + data[i].actual_problem + '</td><td id="j">' + data[i].veh_no + '</td><td id="h">' + data[i].client_name + '</td></tr>'
                    }
                }
                $("#filterId").html(tblBodyData)
                $("#footerId").html(dataLength)
              }
            }
          });
        }
       return false;
      });

      $("#submit2").click(function(){
    
      var cname = $("#searchclient").val();
      var strdt = $("#datepick1").val();
      var enddt = $("#datepick2").val();
      //alert(cname);
     
      var dataString = 'cnm='+ cname + '&dt1='+ strdt + '&dt2='+ enddt;
      //alert(dataString);
        if(cname == '' && strdt == '' && enddt == '')
        {
          alert("Please Fill All Fields");
        }
        else
        {
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_devicefilterrepair.php",
            data: dataString,
            cache: false,
            success: function(data){
            // alert(data) 
             if(data == "Error") { 
                  document.getElementById("errmsg2").innerHTML = "<b>*Record Not Found</b>"; 
                  document.getElementById("loadingmessage").style.display = "none";
              }       
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].itgc_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].device_imei + '</td><td id="e">' + data[i].opencase_date + '</td><td id="f">' + data[i].closecase_date+ '</td><td id="g">' + data[i].actual_problem + '</td><td id="h">' + data[i].problem + '</td><td id="i">' + data[i].device_removed + '</td><td id="j">' + data[i].veh_no + '</td><td id="h">' + data[i].client_name + '</td></tr>'
                    }
                }
                $("#filterId").html(tblBodyData)
              }
          });
        }
       return false;
      });


      $("#submit3").click(function(){
    
      var deviceid = $("#devid").val();
      
      //alert(deviceid);
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'did='+ deviceid;
      //alert(dataString);
        if(deviceid == '')
        {
          alert("Please Fill All Fields");
        }
        else if(!deviceid.match(numericExpression))
        {
          alert("Device ID must be filled with numbers only");
          return false;
        }
        else
        {
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_devicefilterrepair.php",
            data: dataString,
            cache: false,
            success: function(data){
             //alert(data)
              if(data == "Error") { 
                  document.getElementById("errmsg1").innerHTML = "<b>*Record Not Found</b>"; 
                  document.getElementById("divTable").style.display = "none";
              }        
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].itgc_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].device_imei + '</td><td id="e">' + data[i].opencase_date + '</td><td id="f">' + data[i].closecase_date+ '</td><td id="g">' + data[i].actual_problem + '</td><td id="h">' + data[i].problem + '</td><td id="i">' + data[i].device_removed + '</td><td id="j">' + data[i].veh_no + '</td><td id="h">' + data[i].client_name + '</td></tr>'
                    }
                }
                $("#filterId").html(tblBodyData)
             }
          });
        }
       return false;
      });

      $("#submit5").click(function(){
   
      var searchcleint = $("#searchclient1").val();
      
      //alert(searchcleint);
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'scleint='+ searchcleint;
      //alert(dataString);
        if(searchcleint == 0)
        {
          alert("Please Select Fields");
        }
        else
        {
          $('#loading-image').show();
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_devicefilterrepair.php",
            data: dataString,
            cache: false,
            success: function(data){
              $("#loading-image").hide(); 
             //alert(data) 

              if(data == "Error") { 
                  document.getElementById("errmsg1").innerHTML = "<b>*Record Not Found</b>";
                  document.getElementById("divTable").style.display = "none";
              }       
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable2").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].old_device_imei + '</td><td id="c">' + data[i].new_device_imei + '</td><td id="d">' + data[i].old_client_name + '</td><td id="e">' + data[i].old_veh_no + '</td><td id="f">' + data[i].veh_no+ '</td><td id="g">' + data[i].old_itgc_id + '</td><td id="h">' + data[i].new_itgc_id + '</td></tr>'
                    }
                }
                $("#filterId1").html(tblBodyData)
              }
          });
        }
       return false;
      });


      $("#submit6").click(function(){
   
      var olddeviceimei = $("#olddevice").val();
      
      //alert(olddeviceimei);
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'oldimei='+ olddeviceimei;
      //alert(dataString);
        if(olddeviceimei == '')
        {
          alert("Please Fill All Fields");
        }
        else if(!olddeviceimei.match(numericExpression))
        {
          alert("Device IMEI must be filled with numbers only");
          return false;
        }
        else
        {
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_devicefilterrepair.php",
            data: dataString,
            cache: false,
            success: function(data){
             //alert(data)  
             if(data == "Error") { 
                  alert("Record Not Found Match")
                  document.getElementById("divTable").style.display = "none";
              }       
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable2").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].old_device_imei + '</td><td id="c">' + data[i].new_device_imei + '</td><td id="d">' + data[i].old_client_name + '</td><td id="e">' + data[i].old_veh_no + '</td><td id="f">' + data[i].veh_no+ '</td><td id="g">' + data[i].old_itgc_id + '</td><td id="h">' + data[i].new_itgc_id + '</td></tr>'
                    }
                }
                $("#filterId1").html(tblBodyData)
              }
          });
        }
       return false;
      });                
		});
  </script>
 
</body>
</html>