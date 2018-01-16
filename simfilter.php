<?php
error_reporting(0);
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');
?>
<body>
	<div class="processing-img" id="loadingmessage" style='display:none;'>
			<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
			</div>
  <article>
    <div class="col-12"> 
      <form name="simfilter" method="post" action="">
      <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="portlet box yellow">

          <div class="portlet-title">
          <div class="caption"> <i class="fa fa"></i>Search By </div>
          </div>
            <div class="portlet-body control-box">
              <div class="content-box">
                <div class="right-item">
                  <table>
                    <tr>
                      <td><input type="radio" name="radio_select" id="radio_select" value="p" checked onchange="by_number(this.value)" value="1"></td>
                      <td>Number </td>
                      <td><input type="radio" name="radio_select" id="radio_select" value="d" onchange="by_date(this.value)" value="2"></td>
                      <td>Date </td>
                     <!-- <td><input type="radio" name="radio_select" id="radio_select" value="s" onchange="by_status(this.value)" value="3"></td>
                      <td>Status</td>-->
                    </tr>
                  </table>
                </div>
              </div>
              <div class="content-box" id="simFilter" style="">
                <div class="left-item" width="300%" > Filtering By Sim Number And Phone Number </div>
                <div class="right-item two-filter-inp"><input type="text" name="sim_phone" id="sim_phone"  class="form-control"></div>
                <div class="content-box">
                  <div class="left-item"></div>
                  <div class="right-item"><input class="btn btn-primary" type="submit" id="sim_search1" name="sim_search1" value="Search"> </div>
                </div>
              </div>
              <div class="content-box"  id="dateFilter" style="display:none">
                <div class="left-item"> <span>Filtering By Date  :</span> </div>
                <div><div class="left-item"> <span>Start Date  :</span> </div><div class="right-item two-filter-inp"><input style="width:180px;" type="text" id="datestart" class="form-control form_date"> </div></div>
                <div class="left-item"> <span>END Date  :</span> </div> <div class="right-item two-filter-inp"><input style="width:180px;" type="text" id="dateend" class="form-control form_date"> </div>
                <div class="content-box">
                  <div class="left-item"></div>
                  <div class="right-item"><input class="btn btn-primary" type="submit" id="sim_search2" value="Search"> </div>
                </div>
              </div>
              <div class="content-box"  id="statusFilter" style="display:none">
                <div class="left-item"> <span>Filtering By Status  :</span> </div>
                  <div class="right-item two-filter-inp">
                    <select id="status" class="form-control">
                      <option value="-2">Select Status</option>
                      <option value="1">Used</option>
                      <option value="0">UnUsed</option>
                      <option value="-1">All</option>
                    </select>
                  </div>
                  <div class="content-box">
                    <div class="left-item"></div>
                    <div class="right-item"><input type="submit" id="sim_search3" class="btn btn-primary" name="sim_search3" value="search"> </div>
                  </div>
              </div>
              <div id="divTable" >
                <table class="table" id="filtertable">
                  <thead>
                    <tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
                      <th scope="col">Device Sno. </th>
                      <th scope="col">Device IMEI </th>
                      <th scope="col">Sim No. </th>
                      <th scope="col">Phone Number</th>
                      <th scope="col">Recieved Date </th>
                      <th scope="col">Owner</th>
                      <th scope="col">Activation Status</th>
                      <th scope="col">Used Status</th>
                    </tr>
                  </thead>
                   <tbody id="filterId">
                  </tbody>
                  <tr style="color:White;background-color:#5D7B9D;font-weight:bold;" >
                      <td colspan="11" align="center" id="footerId">
                    </tr>  
                  </table>
              </div>
			 
            </div>
          </div>
      </form>
    <!-- END BORDERED TABLE PORTLET--> 
    </div>
  </article>
  <script type="text/javascript">
  function by_number(number)
  {
    document.getElementById('simFilter').style.display = "block";
    document.getElementById('dateFilter').style.display = "none";
    document.getElementById('statusFilter').style.display = "none";
  }
  function by_date(number)
  {
    document.getElementById('dateFilter').style.display = "block";
    document.getElementById('statusFilter').style.display = "none";
    document.getElementById('simFilter').style.display = "none";
  }
  function by_status(number)
  {
    document.getElementById('statusFilter').style.display = "block";
    document.getElementById('dateFilter').style.display = "none";
    document.getElementById('simFilter').style.display = "none";
  }
</script>
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

	  
	  
	  
    $("#divTable").hide();
    var numericExpression = /^[0-9]+$/;  

    $("input[name$='radio_select']").change(function() {
       $("#divTable").hide();
    });

    $("#sim_search1").click(function(){
    
      var simno = $("#sim_phone").val();
      //alert(simno)  ;
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'simphone='+ simno;
        if(simno=='')
        {
          alert("Please Fill All Fields");
        }
        else if(!simno.match(numericExpression))
        {
          alert("Sim No. & Phone No. must be filled with numbers only");
          
        }
        else if(simno.length != 10 && simno.length != 19)
        {
          alert("Please Input Sim Number 19 Or Phone Number 10");
        }
        else
        {
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_simfilter.php",
            data: dataString,
            cache: false,
            success: function(data){
            //alert(data) 

            if(data == "Error") { 
                alert("Records Not Found.")
                document.getElementById("divTable").style.display = "none";
              }
            
            else{         
              var data = JSON.parse(data);
              var dataLength=data.length; 
              //alert(dataLength)
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].simphmo1 + '</td><td id="b">' + data[i].simphmo2 + '</td><td id="c">' + data[i].sim_no + '</td><td id="d">' + data[i].phone_no + '</td><td id="e">' + data[i].rec_date + '</td><td id="f">' + data[i].owner+ '</td><td id="g">' + data[i].simphmo6 + '</td><td id="h">' + data[i].simphmo7 + '</td></tr>'
                    }
                }
                $("#filterId").html(tblBodyData);
                $("#footerId").html(dataLength);
              }
            }
          });
        }
       return false;
      }); 

    $("#sim_search2").click(function(){
     
      var strdate = $("#datestart").val();
      var enddate = $("#dateend").val();
      //alert(simno)  ;
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'dt1='+ strdate + '&dt2=' + enddate;;
        if(strdate == '' || enddate == '')
        {
          alert("Please Fill All Fields");
        }
        else
        {
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_simfilter.php",
            data: dataString,
            cache: false,
            success: function(data){
             //alert(data)        
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].simphmo1 + '</td><td id="b">' + data[i].simphmo2 + '</td><td id="c">' + data[i].sim_no + '</td><td id="d">' + data[i].phone_no + '</td><td id="e">' + data[i].rec_date + '</td><td id="f">' + data[i].owner+ '</td><td id="g">' + data[i].simphmo6 + '</td><td id="h">' + data[i].simphmo7 + '</td></tr>'
                    }
                }
                $("#filterId").html(tblBodyData)
                $("#footerId").html(dataLength);
              }
          });
        }
       return false;
      }); 

      $("#sim_search3").click(function(){
        
      var simstatus = $("#status").val();
      //alert(simno)  ;
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'status='+ simstatus;
      //alert(dataString)
        if(simstatus == '')
        {
          alert("Please Fill All Fields");
        }
        else
        {
         // $("#LoadingImage").show();
          // AJAX Code To Submit Form.
          $.ajax({
            type: "POST",
            url: "process_simfilter.php",
            data: dataString,
            cache: false,
            success: function(data){
             // $("#LoadingImage").hide();
             //alert(data)        
              var data = JSON.parse(data);
              var dataLength=data.length; 
              // alert(JSON.stringify(data))
              var tblBodyData = ''
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("divTable").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].simphmo1 + '</td><td id="b">' + data[i].simphmo2 + '</td><td id="c">' + data[i].sim_no + '</td><td id="d">' + data[i].phone_no + '</td><td id="e">' + data[i].rec_date + '</td><td id="f">' + data[i].owner+ '</td><td id="g">' + data[i].simphmo6 + '</td><td id="h">' + data[i].simphmo7 + '</td></tr>'
                    }
                }
                $("#filterId").html(tblBodyData);
                $("#footerId").html(dataLength);
              }
          });
        }
       return false;
      });  
  });
</script>
 <div style="display: none; align:center">
    <img id="LoadingImage" src="<?php echo __DOCUMENT_ROOT; ?>/loading.gif" />
</div>
<script data-config>
    var filtersConfig = {
        base_path: 'dist/tablefilter/',
        paging: true,

        remember_grid_values: false,
        remember_page_number: false,
        remember_page_length: false,
        alternate_rows: false,
        btn_reset: true,
        rows_counter: true,
        loader: true,

        status_bar: true,

        status_bar_css_class: 'myStatus',

        extensions:[{
            name: 'sort',
            types: ['number', 'number','string','number','number','number']
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</script>
</body>
</html>