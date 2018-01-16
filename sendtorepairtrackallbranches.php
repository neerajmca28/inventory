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
  <div class="col-12"> 
  	<form name="simfilter" method="post" action="">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">

      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>  Send To Repair Device of All Branches
		</div>
      </div>
      <div class="portlet-body">
           <div class="content-box">
        
           <div class="right-item"> <table>
            <tr>
              <td><input type="radio" name="radio_select" id="not_cracked" value="rd" ></td>
              <td>Repair Device    </td>
              <td><input type="radio" name="radio_select" id="cracked" value="rdd"></td>
              <td>Repair Dispatch Device </td>
           </tr>
          </table></div>
          </div>

      </div>

	  <div class="fix-table" id="ss" style="display:none">
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
   $crack( "#loadingmessage" ).show();
    });
	    $crack( document ).ajaxStop(function() {
      $crack( "#loadingmessage" ).hide();
    });
    $crack('input:radio[name=radio_select]').change(function() {
		if(this.value=="rd")
		{
				$crack.ajax({
					type:"POST",
					cache: false,
					url:"send_to_rep_track_allbranches.php",
					data:'send_repair_allBranch='+ this.value,
					 dataType: "html",
					success:function(msg)
					{
						document.getElementById('ss').style.display = "block";
						$crack("#ss").html(msg);
					},
					error:function(msg){
				
					}
			});
		}
		if(this.value=="rdd")
		{
				$crack.ajax({
					type:"POST",
					url:"send_to_rep_track_allbranches_dispatch.php",
					data:'send_repair_allBranch='+ this.value,
					 dataType: "html",
					success:function(msg)
					{
						document.getElementById('ss').style.display = "block";
						$crack("#ss").html(msg);
					},
					error:function(msg){
				
					}
			});
		}
		
		
}); 
	
});

</script>
<!-- <script data-config>
    var filtersConfig = {
        base_path: 'dist/tablefilter/',
        paging: true,

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
          types: [
                    'number', 'number','number','number','string','string','number','string','number', 'string','number','number'
                ]
        }]
    };

    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();

</script> -->	

</html>