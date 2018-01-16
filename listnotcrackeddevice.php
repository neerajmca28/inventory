<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
?>
<head>

</head>
<body>
<div class="processing-img" id="loadingmessage" style='display:none;'>
			<img src="<?php echo __SITE_URL;?>/file/loader.gif" >
			</div>
<article>
 
  	<form name="simfilter" method="post" action="">
    <!-- BEGIN BORDERED TABLE PORTLET-->
     <div class="col-12"> 
    <div class="portlet box yellow">

      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i> List of Cracked/Not Cracked Devices

</div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> <table>
            <tr>
              <td><input type="radio" name="radio_select" id="not_cracked" value="n" onchange="handleChange1();"></td>
              <td>Not Cracked Devices  </td>
              <td><input type="radio" name="radio_select" id="cracked" value="c"  onchange="handleChange2();"></td>
              <td>Cracked Devices </td>
           </tr>
          </table></div>
          </div>
         
		  
         
      </div>

    </div>
    </div>
     <div class="col-12"> 
	<div class="portlet box yellow" id="ss" style="display:none">
      
    </div>

    </div>
	</form>
		  
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
</article>

</body>

<script type="text/javascript">
var $crack = jQuery.noConflict();
 $crack(document).ready(function () {
    $crack( document ).ajaxStart(function() {
		//document.getElementById('ss').style.display = "none";
      $crack( "#loadingmessage" ).show();
    });
	    $crack( document ).ajaxStop(function() {
      $crack( "#loadingmessage" ).hide();
    });

/* 	 $crack('#loading-image').bind('ajaxStart', function(){
    $crack(this).show();
}).bind('ajaxStop', function(){
    $crack(this).hide();
}); */
    $crack('input:radio[name=radio_select]').change(function() {
	//alert(this.value);
		//$crack('#loadingmessage').show();
		$crack.ajax({
				type:"POST",
				cache: false,
				url:"crack_uncrack_list.php",
				dataType: "html",
				data:'crack_uncrack='+ this.value,
				success:function(msg)
				{
					 //alert(msg);
					  $crack("#ss").html(msg);
					  // $crack('#loadingmessage').hide();
					   	document.getElementById('ss').style.display = "block";
					 //document.getElementById("ss").innerHTML = msg; 
					
				},
				error:function(msg){
            
				}
		});
}); 
	
});

</script>
</html>