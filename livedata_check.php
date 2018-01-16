<?php 
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$masterObj = new master();
 
?>

<head>
</head>
<body>
 <form name="raw_log" id="raw_log" method="post" action="livedata_check.php" >
<div class="col-12">	
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
	<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Raw Log Data </div>
				</div>
	<div class="portlet-body control-box">
				<div class="content-box">
					<div class="left-item"><span><strong>IMEI:</strong></span> </div>
					<div class="right-item"><input type="text"  class="form-control" name="txtimei_no" id="txtimei_no" value="<?php echo $imei_no; ?>" ></div>
					</div>
		
					
			<div class="content-box">
           <div class="left-item">  </div>
          <div class="right-item"><input type="button" class="btn btn-primary btnaddsim"  name="Submit" value="Submit" id="submit"> <input  class="btn btn-default" type="button" name="Submit" id="cancel" value="Cancel" onclick='cancelAll();'></div>
		     </div>
	</div>
		   <div class="content-box">
		   
		   <div class="portlet-body fix-table" id="tt"  style="display:none">
       
			</div>
           
          </div>
		  
		  
		</div>
	
</div>
 
	   
     
          </form> 

</body>
  <script>
   var $fil = jQuery.noConflict();
       $fil(document).ready(function() {
        $fil(".btnaddsim").click(function(){
			var txtimei_no = document.getElementById("txtimei_no").value;
				$fil.ajax({
				type:"POST",
				url:"process_livedata_check.php",
				dataType: "html",
				data:'imei_no='+ txtimei_no,
				success:function(msg)
				{
					//alert(msg);
					 $fil("#tt").html(msg);
					 document.getElementById('tt').style.display = "block";
					 document.getElementById("tt").innerHTML = msg; 
				},
				error:function(msg){
            
				}
		}); 	
		});
		
		$fil("#cancel").click(function(){
			document.getElementById('txtimei_no').value = "";
			document.getElementById('data_string').style.display = "none";
			//document.getElementById('data_string').style.display = "none";
		});
	   });
	   
		</script>
</html>	