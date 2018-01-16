<?php
include("config.php");
set_time_limit(0);
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
$branchList=select_Procedure("CALL GetBranch()");
$branchList=$branchList[0]; 
$strBranchID=$_SESSION["branch_id"];

?>

<head>


</head>
<form name="show_form" id="show_form" method="post" action="" >
<body>
<article> 

  <!--page div 1 start-->
  <div class="col-12">
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Monthly Sim Report  </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        <div class="left-item"> <span>Start Date :</span> </div>
          <div class="right-item">
         <input type="text" name="start_date" id="start_date" value="" class="form-control form_date">
          </div>
          </div>
           <div class="content-box">
           <div class="left-item"> <span>End Date :</span> </div>
          <div class="right-item"> <input type="text" name="end_date" id="end_date" value="" class="form-control form_date"></div>
          </div>
		  
		  
		    <div class="content-box">
           <div class="left-item"> <span>Branch Name :</span> </div>
          <div class="right-item" > 
         <select id="branch_name" name="branch_name" class="form-control"  style="width:45%;display:inline-block;margin-right:5px;" />
                  <option value="0">Select</option>
					<?php for($i=0;$i<count($branchList);$i++)
					{?>
						<option value="<?php echo $branchList[$i]['id']?>"><?php echo $branchList[$i]['branch_name'];?></option>
					<?php } ?>
					</select> 
<!--					<input  class="btn btn-primary" type="submit" name="show" id="show" value="Show">--></div></div>
           <div class="content-box">
           
          <div class="right-item"> <input  class="btn btn-primary" type="button" id="repair" name="repair" value="Repair" onclick="repair_month(this.value);"> <input  class="btn btn-primary" type="button" id="crack" name="crack" value="Crack" onclick="crack_month(this.value);"><input  class="btn btn-primary" type="button" name="new" id="new" value="New" onclick="new_month(this.value);"> 
          </div>
          </div>
		  
		  
		 <div class="col-12">
       	  <div  class="portlet-body" id='hh' style="display:none"></div>
		  <div  class="portlet-body" id='tt' style="display:none"></div>
		  <div  class="portlet-body" id='ss' style="display:none"></div>
        </div>


      </div>
    </div>
  </div>
  <!--page div 1 end-->  
 
</article>
</body>
</form>
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
        //language:  'fr',
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
<script type="text/javascript">
var $monthly_sim = jQuery.noConflict();
function repair_month()
{
	//alert('tt');
  var start_date = $monthly_sim('#start_date').val();
  var end_date = $monthly_sim('#end_date').val();
    var branch_id = $monthly_sim('#branch_name').val();
  //alert(start_date);alert(end_date);
  $monthly_sim.ajax({
      type:"GET",
      url:"monthly_sim_rep_rep_ajax.php?action=monthly_sim_repair",
	  dataType: "html",
      data:"start_date=" + start_date + "&end_date=" + end_date + "&branchID=" + branch_id,
      success:function(msg){
			//alert(msg);
			document.getElementById('tt').style.display = "none";
			document.getElementById('ss').style.display = "none";
			$monthly_sim("#hh").html(msg);
			document.getElementById('hh').style.display = "block";
			//document.getElementById('hh').innerHTML = msg; 
			
        }
      });
} 
function crack_month()
{
	var start_date = $monthly_sim('#start_date').val();
	var end_date = $monthly_sim('#end_date').val();
	//alert(start_date);
	$monthly_sim.ajax({
			type:"GET",
			url:"monthly_sim_rep_crack_ajax.php?action=monthly_sim_crack",
			dataType: "html",
			data:"start_date=" + start_date + "&end_date=" + end_date + "&branchID=" + branch_id,
			success:function(msg){
				document.getElementById('hh').style.display = "none";
				document.getElementById('ss').style.display = "none";
				$monthly_sim("#tt").html(msg);
				document.getElementById('tt').style.display = "block";
				//document.getElementById('tt').innerHTML = msg; 
				
				}
			});
}
function new_month()
{
	var start_date = $monthly_sim('#start_date').val();
	var end_date = $monthly_sim('#end_date').val();
	//alert(start_date);
	$monthly_sim.ajax({
			type:"GET",
			url:"monthly_sim_rep_new_ajax.php?action=monthly_sim_new",
			dataType: "html",
			data:"start_date=" + start_date + "&end_date=" + end_date + "&branchID=" + branch_id,
			success:function(msg){
				document.getElementById('tt').style.display = "none";
				document.getElementById('hh').style.display = "none";
				document.getElementById('ss').style.display = "block";
				$monthly_sim("#ss").html(msg);
				//document.getElementById('ss').innerHTML = msg; 
				
				}
			});
}
</script>

</html>