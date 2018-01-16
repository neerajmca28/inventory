<?php
error_reporting(0);
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php');

$masterObj = new master();

$portSqlQuery=db__select_matrix("select des_movement_id as port,count(*) as number  from latest_telemetry where des_movement_id!='' group by latest_telemetry.des_movement_id");

?>
<style type="text/css">
#leftdiv{width:500px;float:left;}
#rightdiv{width:800px;float:right;}
</style>
<div class="processing-img" id="loadingmessage" style='display:none;'>
  <img src="<?php echo __SITE_URL;?>/file/loader.gif" >
</div>
<article>
	<!-- BEGIN BORDERED TABLE PORTLET-->
	<div class="col-12"> 
		<div class="portlet box yellow">
			<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>View Port Data</div>
			</div>
			<div class="portlet-body-">
				<div id="leftdiv">
					<table class="table table-bordered table-hover" id="filtertable1">
						<thead>
							<tr>
								<th> PORT </th>
								<th> NUMBER</th>
							</tr>
						</thead>
						<tbody>
							<?php for($i=0;$i<=count($portSqlQuery);$i++) { ?>
							<tr class="portrecord">
								<td>
                  <!-- // View Port Data
									<a href="javascript:void(0)" onclick="portNumber('<?php echo $portSqlQuery[$i]['port']; ?>')">  -->
										<span style="color:#72a7f9;">
											<?php echo $portSqlQuery[$i]['port']; ?>
										</span>
				  <!--					</a> 
                  -->
                 
								</td>
								<td>
									<span>
										<?php echo $portSqlQuery[$i]['number']; ?>
									</span>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div id="rightdiv" style="display:none">
					<table class="table table-bordered table-hover" id="filtertable2">
						<thead>
							<tr>
								<th> VEHICLE REG </th>
								<th nowrap> LAST CONTACT</th>
								<th> PORT</th>
								<th> IMEI</th>
								<th> MOBILE NO</th>
							</tr>
						</thead>
						<tbody id="filtertable"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END BORDERED TABLE PORTLET--> 
</article>
<script type="text/javascript">
function portNumber(port){	
	var datastring = 'portNumber='+port;
        //alert(datastring)
        if(port=='')
        {
          alert("Please Select Port Number");
        }
        else
        {
          $( "#loadingmessage" ).show();
          $.ajax({
            url:"process_portData.php", //the page containing php script
            type: "POST", //request type
            dataType: "html",
            data: datastring,
            success:function(data){
            //alert(data)
             if(data == "Error") {
                document.getElementById("errmsg1").innerHTML = "<b>*Record Not Found</b>"; 
                document.getElementById("divTable").style.display = "none";
				        $( "#loadingmessage" ).hide();
              }
            
            else{                 
              var data = JSON.parse(data);
              var dataLength=data.length; 
              var tblBodyData = '';
			  	    $( "#loadingmessage" ).hide();
                if (data) {
                  for (var i = 0; i < dataLength;  i++) {
                    document.getElementById("rightdiv").style.display = "block";
                    tblBodyData += '<tr><td id="a">' + data[i].veh_reg + '</td><td id="b" nowrap>' + data[i].lastconta + '</td><td id="c">' + data[i].port + '</td><td id="d">' + data[i].imei + '</td><td id="e">' + data[i].mobile_no + '</td>'
                  }
                }
               $("#filtertable").html(tblBodyData);
               }
            }
          });
        }
       return false;
      }
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
            types: ['number','number','number','number','number','number','string','string','number','number','number','string']
        }]
    };
    var tf1 = new TableFilter('filtertable1', filtersConfig);
    tf1.init();
    var tf2 = new TableFilter('filtertable2', filtersConfig);
    tf2.init();
</script>
</body>
</html>