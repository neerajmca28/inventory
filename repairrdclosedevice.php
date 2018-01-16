<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if(isset($_SESSION['username']) && isset($_SESSION['userId_inv']) && !empty($_SESSION['username']) &&  !empty($_SESSION['userId_inv']))
{
  $data=select_Procedure("CALL SelectCrackedDevice()");
  $data=$data[0];
} 

?>

<head>

</head>
<body>
  
<article>
  <div class="col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Repair Close RD Device </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover">
          <form method="post">
          <tbody>
            <tr>
              <td>
                From date
              </td>
              <td>
                <input type="text" id="datepick1" class="form-control form_date">
              </td>
            </tr>
            
              <tr>
              <td>
                Todate date
              </td>
              <td>
                <input type="text" id="datepick2" class="form-control form_date">
              </td>
            </tr>
            <tr>
              <td colspan="2"><input type="button" id="submit" value="Submit"></td>
            </tr>
          </tbody>
          </form> 
        </table>
      </div>
      </div> </div>
        <div class="col-12" id="divTable" style="display:none"> 
      <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> Repair Close RD Details </div>
      </div>
      <div class="portlet-body fix-table">
      
      <div >
        <table class="table" id="filtertable">
          <thead>
            <tr style="color:White;background-color:#5D7B9D;font-weight:bold;">
              <th scope="col" nowrap>Device Id</th>
              <th scope="col" nowrap>Device Imei</th>
              <th scope="col" nowrap>Client Name</th>
              <th scope="col" nowrap>Veh No</th>
              <th scope="col" nowrap>Status</th>
              <th scope="col" nowrap>Opencase Date</th>
              <th scope="col" nowrap>Closecase Date</th>
              <th scope="col" nowrap>Open Case Problem</th>
              <th scope="col" nowrap>Close Case Problem</th>
              <th scope="col" nowrap>Device Removed Remarks</th>
              <th scope="col" nowrap>Manufacture Remarks</th>
            </tr>
          </thead>
          <tbody id="filterId">
          </tbody>
        </table>
      </div> 
      </div></div> 
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>

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

  $(document).ready(function(){
    $("#submit").click(function(){
    var date1 = $("#datepick1").val();
    var date2 = $("#datepick2").val();
    
    // Returns successful data submission message when the entered information is stored in database.
    var dataString = 'dt1='+ date1 + '&dt2=' + date2;
      if(date1==''||date2=='')
      {
        alert("Please Fill All Fields");
      }
      else
      {
        // AJAX Code To Submit Form.
        $.ajax({
          type: "POST",
          url: "process_repairrdcldevice.php",
          data: dataString,
          cache: false,
          success: function(data){
          //alert(data)            
            var data = JSON.parse(data);
            var dataLength=data.length; 
            //alert(dataLength)

            if(data)
            {
             // alert(dataLength)
              for(var i=0;i<=dataLength;i++){
                //alert(i)
                document.getElementById("divTable").style.display = "block";
                $("#filterId").append('<tr><td id="a">' + data[i].device_id + '</td><td id="b">' + data[i].device_imei + '</td><td id="c">' + data[i].client_name + '</td><td id="d">' + data[i].veh_no + '</td><td id="e">' + data[i].status + '</td><td id="f">' + data[i].opencase_date + '</td><td id="g">'  + data[i].closecase_date + '</td><td id="h">'  + data[i].opencaseproblem + '</td><td id="i">'  + data[i].closecaseproblem + '</td><td id="j">'  + data[i].device_removed_remarks + '</td><td id="k">'  + data[i].ManufactureRemarks + '</td></tr>');
              }
            }   
          }
        });
      }
     return false;
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

	
	
	
  });
</script>
<script data-config>
    var filtersConfig = {
        base_path: 'dist/tablefilter/',
        paging: false,

        remember_grid_values: false,
        remember_page_number: false,
        remember_page_length: false,
        alternate_rows: false,
        btn_reset: true,
        rows_counter: true,
        loader: false,

        status_bar: true,

        status_bar_css_class: 'myStatus',

        extensions:[{
            name: 'sort',
            types: ['number', 'number','string','string','string','number','number','string','string','string','string']
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>