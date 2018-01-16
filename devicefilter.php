<?php
//error_reporting(0);
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
//ini_set('memory_limit', '8192M');

if(isset($_SESSION['branch_id'])) {

  //Select Data Filtering By Device Type And Status
  $devstatus=select_Procedure("CALL SelectDevStatus(-1)");
  $devstatus=$devstatus[0];
  
  //Select Data Filtering By Device Status
  $devtypew=select_Procedure("CALL SelectDevType()");
  $devtypew=$devtypew[0];

  //Select Data Filtering By Client Name
  $dataclient=select_Procedure("CALL SearchClient_data()");
  $dataclient=$dataclient[0];
  //print_r($dataclient);
  
}
else {
  header("Location:".__SITE_URL."/index.php");
}  
  
?>
<head>
   <style type="text/css">
   select{
    width:30%;
   }
   </style>
</head>
<body>

	<div class="processing-img" id="loadingmessage" style='display:none;'>
	<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
	</div>
	<article>
    <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
      <div class="portlet box yellow">
        <div class="portlet-title">
          <div class="caption"> <i class="fa fa"></i>Device Filter</div>
        </div>
        <div class="portlet-body">
          <form method="post">
            <div class="radio">
                
                <label><input type="radio" name="optradio" id="devId" value="2" checked="checked">ID</label>
				<label><input type="radio" name="optradio" id="devItgcId" value="1">ITGC Id</label>
                <label><input type="radio" name="optradio" id="devTyp" value="3">Device Type</label>
                <label><input type="radio" name="optradio" id="devCliName" value="4">Date</label>
                <!--<label><input type="radio" name="optradio" id="devCliName" value="5">Client Name</label>-->
                <label><input type="radio" name="optradio" id="devDisReport" value="6">Dispatch Report</label>
                <div id="fiter1" class="devfilter" value="1">
                  <table class="table table-bordered table-hover" id="">
                  <thead>
                    <tr>
                      <td>Filtering By ITGC Id</td>
                    </tr>
                    <tr>
                      <td>
                        <input type="text" id="itgc1" class="form-group" style="width:20%">X<input type="text" id="itgc2" class="form-group" style="width:20%">
                      </td>
                    </tr>
                    <tr>
                      <td><input type="button" class="btn btn-primary" id="submit1" value="SEARCH"></td>
                    </tr>
                  </table>
                </div>
                <div id="fiter2" class="devfilter" value="2">  
                  <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td>Filtering By SerialNo,IMEI,SimID,ClientID,PhoneNo</td>
                    </tr>
                    <tr>
                      <td><input type="text" id="keyid" class="form-group" style="width:20%"><div id="errmsg2" style="color:red"></div>
                    </tr>
                    <tr>
                      <td><input type="button" class="btn btn-primary" id="submit2" value="SEARCH"></td>
                    </tr>
                  </table>
                </div>
                <div id="fiter3" class="devfilter" value="3"> 
                  <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td colspan="2">Filtering By Device Type And Status</td>
                    </tr>
                    <tr>
                      <td>
                        Device Type
                      </td>
                      <td>
                        <select id="devstatus">
                        <option role="presentation" value="0">Select</option>
                        <?php 
                          for($i=0;$i<count($devtypew);$i++){
                        ?>
                         <option role="presentation" value="<?php echo $devtypew[$i]['item_id'] ?>"><?php echo $devtypew[$i]['item_name'] ?></option>
                        <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>  
                      <td>   
                        Device Status
                      </td>
                      <td>
                        <select id="devtyp">
                        <option role="presentation" value="0">Select</option>
                        <?php 
                          for($i=0;$i<count($devstatus);$i++){
                        ?>
                        <option role="presentation" value="<?php echo $devstatus[$i]['status_sno'] ?>"><?php echo $devstatus[$i]['status'] ?></option>
                       
                        <?php } ?>
                        </select> 
                      </td>
                    </tr>
          					<tr>
          					  <td colspan="2"><div id="errmsg3" style="color:red"></div></td>
          					</tr>
                    <tr>
                      <td colspan="2"><input type="button" class="btn btn-primary" id="submit3" value="SEARCH"></td>
                    </tr>
                  </table>
                </div> 
                <div id="fiter4" class="devfilter" value="4">   
                  <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td colspan="2">Filtering By Date</td>
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
                      <td colspan="2"><input type="button" class="btn btn-primary" id="submit4" value="SEARCH"></td>
                    </tr>
                  </table>
                </div>  
                <div id="fiter5" class="devfilter" value="5">   
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
                      <td colspan="2"><input type="button" class="btn btn-primary" id="submit5" value="SEARCH"></td>
                    </tr>
                  </table>
                </div>
                <div id="fiter6" class="devfilter" value="6">  
                  <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td colspan="2">Filtering By Date</td>
                    </tr>
                    <tr>
                      <td>
                        Start Date
                      </td>
                      <td>
                        <input type="text" id="datepick3" class="form-control form_date">
                      </td>
                    </tr>
                    <tr>  
                      <td>   
                        End Date
                      </td>
                      <td>
                        <input type="text" id="datepick4" class="form-control form_date">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2"><input type="button" class="btn btn-primary" id="submit6" value="SEARCH"></td>
                    </tr>
                  </table>
                  </div>
                </div>
                <div id="divTable" >
                  <table class="table" id="filtertable">
                    <thead>
                      <tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
                              <th scope="col">ITGC Id</th>
                              <th scope="col">Device Sno.</th>
                              <th scope="col">Device IMEI</th>
                              <th scope="col">Received Date</th>
                              <th scope="col">Device Name</th>
                              <th scope="col">Device Status</th>
                              <th scope="col">Branch Name</th>
                              <th scope="col" nowrap>Phone No</th>
                              <th scope="col">SIM NO</th>
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
	            </div>
              </div>
            </form> 
          </div>
        </div>
      </div>
    <!-- END BORDERED TABLE PORTLET--> 
    </div>
  </article>
  <script>
   var $fil = jQuery.noConflict()
    $fil('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $fil('.form_date').datetimepicker({
       // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $fil('.form_time').datetimepicker({
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

    $fil(document).ready(function() {
			
      $fil("#fiter2").show();
      $fil("#fiter1").hide();
      $fil("#fiter3").hide();
      $fil("#fiter4").hide();
      $fil("#fiter5").hide();  
      $fil("#fiter6").hide(); 
      $fil("#divTable").hide();

      var numericExpression = /^[0-9]+$/;  

       $fil("input[name$='optradio']").change(function() {
          $fil("#divTable").hide();
          var test = $fil(this).val();
          if(test == 1) {
            $fil("#fiter1").show();
            $fil("#fiter2").hide();
            $fil("#fiter3").hide();
            $fil("#fiter4").hide();
            $fil("#fiter5").hide();  
            $fil("#fiter6").hide(); 
          }
          if(test == 2) {
            $fil("#fiter1").hide();
            $fil("#fiter2").show();
            $fil("#fiter3").hide();
            $fil("#fiter4").hide();
            $fil("#fiter5").hide();  
            $fil("#fiter6").hide(); 
          }
          if(test == 3) {
            $fil("#fiter1").hide();
            $fil("#fiter2").hide();
            $fil("#fiter3").show();
            $fil("#fiter4").hide();
            $fil("#fiter5").hide();  
            $fil("#fiter6").hide(); 
          }
          if(test == 4) {
            $fil("#fiter1").hide();
            $fil("#fiter2").hide();
            $fil("#fiter3").hide();
            $fil("#fiter4").show();
            $fil("#fiter5").hide();  
            $fil("#fiter6").hide(); 
          }
          if(test == 5) {
            $fil("#fiter1").hide();
            $fil("#fiter2").hide();
            $fil("#fiter3").hide();
            $fil("#fiter4").hide();
            $fil("#fiter5").show();  
            $fil("#fiter6").hide(); 
          }
          if(test == 6) {
            $fil("#fiter1").hide();
            $fil("#fiter2").hide();
           $fil("#fiter3").hide();
           $fil("#fiter4").hide();
           $fil("#fiter5").hide();  
           $fil("#fiter6").show(); 
          }
       });
      // Search ITGC Id

     $fil("#submit1").click(function(){
       
      var itgc1 =$fil("#itgc1").val();
      var itgc2 =$fil("#itgc2").val();
      //alert(itgc1)  ;alert(itgc2)  ;  
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'it1='+ itgc1 + '&it2=' + itgc2;
        if (itgc1 == '' || itgc2 == '') {
          alert("Please Fill All Fields.");
        }
        else if(!itgc1.match(numericExpression) || !itgc2.match(numericExpression))
        {
          alert("ITGC must be filled with numbers only");
          return false;
        }

        else {
			document.getElementById('divTable').style.display = "none";
			$fil( "#loadingmessage" ).show();
          // AJAX Code To Submit Form.
          $fil.ajax({
            type: "POST",
            url: "process_devfilter.php",
            data: dataString,
            cache: false,
            success: function(data){ 

            if(data == "Error") {
                document.getElementById("errmsg1").innerHTML = "<b>*Record Not Found</b>"; 
                //$("#errmsg1").innerHTML('<b>*Record Not Found</b>');
                document.getElementById("divTable").style.display = "none";
				$fil( "#loadingmessage" ).hide();
              }
            
            else{                 
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = '';
			  	 $fil( "#loadingmessage" ).hide();
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].itgc_id + '</td><td id="b">' + data[i].device_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].recd_date + '</td><td id="e">' + data[i].item_name + '</td><td id="f">' + data[i].status + '</td><td id="g">'  + data[i].dispatch_branch + '</td><td id="h">'  + data[i].phone_no + '</td><td id="i">'  + data[i].sim_no + '</td></tr>'
                  }
                }
               $fil("#filterId").html(tblBodyData);
               $fil("#footerId").html(dataLength);
              }
            }
          });
        }
       return false;
      }); 

      // End Search ITGC Id

      // Search Device Filter By ID

     $fil("#submit2").click(function(){
      var keyid =$fil("#keyid").val();

      $fil("#errmsg2").empty();

      // alert(keyid);
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'key='+ keyid;
      //alert(dataString);
        if(keyid=='')
        {
          alert("Please Fill Fields");
		  return false;
        }
        else if(!keyid.match(numericExpression))
        {
          alert("Only Numbers to be Filled.");
          return false;
        }
        else
        {
			document.getElementById('divTable').style.display = "none";
			$fil( "#loadingmessage" ).show();
          // AJAX Code To Submit Form.
          $fil.ajax({
            type: "POST",
            url: "process_devfilter.php",
            data: dataString,
            cache: false,
            success: function(data){
              //alert(data);
			  if(data=="Error")
			  {
				  document.getElementById("errmsg2").innerHTML = "<b>*Record Not Found</b>"; 
					//$("#errmsg1").innerHTML('<b>*Record Not Found</b>');
					document.getElementById("divTable").style.display = "none";
					$fil( "#loadingmessage" ).hide();
			  }
			  else
			  {
				//alert(JSON.parse(data));
				var data = JSON.parse(data);
				var dataLength=data.length; 
              
				var tblBodyData = '';
				 $fil( "#loadingmessage" ).hide();
                if (data) {
                  //alert(data);
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].itgc_id + '</td><td id="b">' + data[i].device_sno + '</td><td id="c">' + data[i].device_imei + '</td><td id="d">' + data[i].recd_date + '</td><td id="e">' + data[i].item_name + '</td><td id="f">' + data[i].status + '</td><td id="g">'  + data[i].dispatch_branch + '</td><td id="h">'  + data[i].phone_no + '</td><td id="i">'  + data[i].sim_no + '</td></tr>'
                  }
                }
               $fil("#filterId").html(tblBodyData);
               $fil("#footerId").html(dataLength);
              }
			}
          });
        }
       return false;
      });

      // End Search Device Filter By ID

      // Search Device Type

     $fil("#submit3").click(function(){
      var devstatus =$fil("#devstatus").val();
      var devtyp =$fil("#devtyp").val();

      $fil("#errmsg3").empty();
      
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'dstatus='+ devstatus + '&dtype=' + devtyp;
      //alert(dataString)

        if(devstatus==0 || devtyp==0)
        {
          alert("Please Select Fields");
        }
        else
        {
			 document.getElementById('divTable').style.display = "none";
			$fil( "#loadingmessage" ).show();
          // AJAX Code To Submit Form.
          $fil.ajax({
            type: "POST",
            url: "process_devfilter.php",
            data: dataString,
            cache: false,
            success: function(data){
				// alert(data)   
				if(data == "Error") { 
				//alert('tt');
                document.getElementById("errmsg3").innerHTML = "<b>*Record Not Found</b>";
                document.getElementById("divTable").style.display = "none";
				$fil( "#loadingmessage" ).hide();
				}
            
            else{            
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = '';
				 $fil( "#loadingmessage" ).hide();
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].itgc_id + '</td><td id="b">' + data[i].device_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].recd_date + '</td><td id="e">' + data[i].item_name + '</td><td id="f">' + data[i].status + '</td><td id="g">'  + data[i].dispatch_branch + '</td><td id="h">'  + data[i].phone_no + '</td><td id="i">'  + data[i].sim_no + '</td></tr>'
                  }
                }
               $fil("#filterId").html(tblBodyData);
               $fil("#footerId").html(dataLength);

             }    
            }
          });
        }
       return false;
      });

      // End Search Device Type

      // Search Date

     $fil("#submit4").click(function(){
      
      var date1 =$fil("#datepick1").val();
      var date2 =$fil("#datepick2").val();

      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'dt1='+ date1 + '&dt2=' + date2;

        if(date1==''||date2=='')
        {
          alert("Please Fill All Fields");
        }
        else
        {
			document.getElementById('divTable').style.display = "none";
			$fil("#loadingmessage").show();
          // AJAX Code To Submit Form.
          $fil.ajax({
            type: "POST",
            url: "process_devfilter.php",
            data: dataString,
            cache: false,
            success: function(data){  
              //alert(data)
              var data = JSON.parse(data);
              var dataLength=data.length; 
              
              var tblBodyData = '';
			        $fil( "#loadingmessage" ).hide();
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].itgc_id + '</td><td id="b">' + data[i].device_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].recd_date + '</td><td id="e">' + data[i].item_name + '</td><td id="f">' + data[i].status + '</td><td id="g">'  + data[i].dispatch_branch + '</td><td id="h">'  + data[i].phone_no + '</td><td id="i">'  + data[i].sim_no + '</td></tr>'
                  }
                }
               $fil("#filterId").html(tblBodyData);
               $fil("#footerId").html(dataLength);
              }
          });
        }
       return false;
      });

      // End Search Date

      // Search Dispatch Report

     $fil("#submit5").click(function(){
      var client =$fil("#searchclient").val();

      $fil("#errmsg5").empty();
      //alert(client)
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'clientName='+ client;

        if(client==0)
        {
          alert("Please Fill Fields");
        }
        else
        {
			 document.getElementById('divTable').style.display = "none";
			$fil( "#loadingmessage" ).show();
          // AJAX Code To Submit Form.
          $fil.ajax({
            type: "POST",
            url: "process_devfilter.php",
            data: dataString,
            cache: false,
            success: function(data){  
              //alert(data)
              if(data == "Error") { 
                document.getElementById("errmsg5").innerHTML = "<b>*Record Not Found</b>";
                document.getElementById("divTable").style.display = "none";
				$fil( "#loadingmessage" ).hide();
              } 
              
              else{  

              var data = JSON.parse(data);
              var dataLength=data.length;
             
              var tblBodyData = '';
			  		 $fil( "#loadingmessage" ).hide();
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].itgc_id + '</td><td id="b">' + data[i].device_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].recd_date + '</td><td id="e">' + data[i].item_name + '</td><td id="f">' + data[i].status + '</td><td id="g">'  + data[i].dispatch_branch + '</td><td id="h">'  + data[i].phone_no + '</td><td id="i">'  + data[i].sim_no + '</td></tr>'
                  }
                }
               $fil("#filterId").html(tblBodyData);
               $fil("#footerId").html(dataLength);
              }  
            }
          });
        }
       return false;
      });

      // End Search Dispatch Report

     $fil("#submit6").click(function(){
      var date3 =$fil("#datepick3").val();
      var date4 =$fil("#datepick4").val();
      
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'dt3='+ date3 + '&dt4=' + date4;
      //alert(dataString);
        if(date3==''||date4=='')
        {
          alert("Please Fill All Fields");
        }
        else
        {
			 document.getElementById('divTable').style.display = "none";
			$fil( "#loadingmessage" ).show();
          // AJAX Code To Submit Form.
          $fil.ajax({
            type: "POST",
            url: "process_devfilter.php",
            data: dataString,
            cache: false,
            success: function(data){  
              //alert(data);            
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = '';
			  	 $fil( "#loadingmessage" ).hide();
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].itgc_id + '</td><td id="b">' + data[i].device_id + '</td><td id="c">' + data[i].device_sno + '</td><td id="d">' + data[i].recd_date + '</td><td id="e">' + data[i].item_name + '</td><td id="f">' + data[i].status + '</td><td id="g">'  + data[i].dispatch_branch + '</td><td id="h">'  + data[i].phone_no + '</td><td id="i">'  + data[i].sim_no + '</td></tr>'
                  }
                }
               $fil("#filterId").html(tblBodyData);
               $fil("#footerId").html(dataLength);
            }
          });
        }
       return false;
      });
  });
</script>

</body>
</html>