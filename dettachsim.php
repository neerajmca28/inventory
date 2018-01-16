<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
include_once "function.php";

if(isset($_SESSION['branch_id'])) {

  $sliced_array=select_Procedure("CALL SelectSimDettachment()");
  $sliced_array=$sliced_array[0]; 

  // Pagination

 /*  $total=count($sliced_array);

  $start = 0;
  $limit = 10;

  if(isset($_GET['id'])) {

  	$id = $_GET['id'];
  	$start = ($id-1)*$limit;

  } else { 

  	$id = 1;

  }

  $page = ceil($total/$limit);
  $sliced_array = array_slice($sliced_array, $start,  $limit); */

  // End Pagination 

  $sliced_array_sim=select_Procedure("CALL SelectSimNo()");
  $sliced_array_sim=$sliced_array_sim[0];
  // echo "<pre>";
  // print_r($sliced_array_sim);
  // echo "</pre>";
  // die();
}  
else {
  header("Location:".__SITE_URL."/index.php");
}  
?>
<article>
	<div class="col-12"> 
	<!-- BEGIN BORDERED TABLE PORTLET-->
		<div class="portlet box yellow">
			<div class="portlet-title">
				<div class="caption"> <i class="fa fa"></i>Dettach Sim</div>
			</div>
			<div class="portlet-body">
				<div>
					<table class="table table-bordered table-hover" id="filtertable">
						<thead>
							<tr>
								<th> ITGC ID </th>
								<th> Device SNo.</th>
								<th> Device Imei </th>
								<th> Phone No </th>
								<th> Reattach </th>
								<th> Dettach </th>
							</tr>
						</thead>
						<tbody>
							<form name="simreattach" id="simreattachid" method="post">
							<?php
								$select = '';

								for($i=0;$i<count($sliced_array);$i++){
									if($i == 0){
										for($j=0;$j<count($sliced_array_sim);$j++){
											$select .= '<option value="'.$sliced_array_sim[$j]['sim_id'].','.$sliced_array_sim[$j]['phone_no'].'">'.$sliced_array_sim[$j]['phone_no'].'</option>';
										}
									}
							?>
							<tr class="delete">
								<td><?php echo $sliced_array[$i]['itgc_id']; ?></td>
								<td id='delId_<?php echo $i; ?>'><?php echo $sliced_array[$i]['device_id']; ?></td>
								<td><?php echo $sliced_array[$i]['device_imei']; ?></td>

								<input type="hidden" class="field1" id='oldId_<?php echo $i; ?>' value='<?php echo $sliced_array[$i]['sim_id']; ?>'  >
								
								<td>
									<span id="text_<?php echo $i; ?>" >
										<?php echo $sliced_array[$i]['phone_no']; ?>
									</span>
									
									<select class="newsim" name="phone" id="select_<?php echo $i; ?>" style="display:none">
				                        <option role="presentation" value="0" >ALL</option>  
				                        <?php echo $select; ?>
				                    </select>
								</td>
								<td  nowrap>
									<a name="edit" href="javascript:void(0)" id="btn_<?php echo $i; ?>"
										onclick="showtext('text_<?php echo $i; ?>','select_<?php echo $i; ?>','btn_<?php echo $i; ?>','btn2_<?php echo $i; ?>','btn3_<?php echo $i; ?>')" class="oldsimclass" value="<?php echo $sliced_array[$i]['sim_id']; ?>">
										<img style="border-style:none" src="actionEdit.gif" />
										
									</a>
									<a class="formAnchor" href="javascript:void(0)" style="display: none;" id="btn2_<?php echo $i; ?>"
										onclick="save('oldId_<?php echo $i; ?>','text_<?php echo $i; ?>','select_<?php echo $i; ?>','btn_<?php echo $i; ?>','btn2_<?php echo $i; ?>','btn3_<?php echo $i; ?>')">
										<img style="border-style:none" src="save.png" />
									</a>
									<a href="javascript:void(0)" style="display: none;" id="btn3_<?php echo $i; ?>"
										onclick="hidetext('text_<?php echo $i; ?>','select_<?php echo $i; ?>','btn_<?php echo $i; ?>','btn2_<?php echo $i; ?>','btn3_<?php echo $i; ?>')">
										<img style="border-style:none" src="cancel.png" />
									</a>
								</td>
								<td>
									<a href="javascript:void(0)" onclick="del('delId_<?php echo $i; ?>')">
										<img style="border-style:none" src="delete.png" />
									</a>
								</td>
							</tr>
							<?php               
							} 
							?>
						</form>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- END BORDERED TABLE PORTLET--> 
	</div>
</article>
<script type="text/javascript">

	function showtext(textspan, textf, btn11, btn12, btn13){
		
		var txt = document.getElementById(textspan)
		var txt1 = document.getElementById(textf)
		var btn1 = document.getElementById(btn11)
		var btn2 = document.getElementById(btn12)
		var btn3 = document.getElementById(btn13)
		
	      	txt.style.display = "none";	//Hidden Select Box
			btn1.style.display = "none";	//Edit Image
			btn2.style.display = "block";	// Save Image
			btn3.style.display = "block";  // Cancel Image
			txt1.style.display = "block"; // Phone No

	}
	function hidetext(textspan, textf, btn11, btn12, btn13){
		
		var txt = document.getElementById(textspan)
		var txt1 = document.getElementById(textf)
		var btn1 = document.getElementById(btn11)
		var btn2 = document.getElementById(btn12)
		var btn3 = document.getElementById(btn13)
		txt.style.display = "block";
		btn1.style.display = "block";
		btn2.style.display = "none";
		btn3.style.display = "none";

		alert(txt)
	}

	function save(oldId,textspan, textf, btn11, btn12, btn13){
		var oldid = document.getElementById(oldId)
		var txt = document.getElementById(textspan)
		var txt1 = document.getElementById(textf)
		var btn1 = document.getElementById(btn11)
		var btn2 = document.getElementById(btn12)
		var btn3 = document.getElementById(btn13)
		//var oldnmbr = alert(oldid.value);
		
		//alert(oldid.value + " "+txt1.options[txt1.selectedIndex].value)
		var num = txt1.options[txt1.selectedIndex].value.split(',')
		var dataString = 'oldNumber='+ oldid.value + '&newNumber=' + num[0];
		//alert(dataString)
		$.ajax({
            type: "POST",
            url: "process_rettachsim.php",
            data: dataString,
            cache: false,
            success: function(data){
            //alert(data)	
            	 // document.getElementById("textspan").style.display = 'block';
              // 	 document.getElementById("textspan").innerHTML=num[1];

            		// //$("textspan").text(num[1]); = ;
            }

        });
		txt.style.display = "block";
		btn1.style.display = "block";
		txt1.style.display = 'none';
		btn2.style.display = "none";
		btn3.style.display = "none";
		location.reload();
	}
	

	function del(delId){
		
		var delId = document.getElementById(delId)

		var NumberData  = { 'oldNumber': delId.innerHTML }

		var result = confirm("Are you sure you want to dispatch???");
		    if (result == true) {
		        $.ajax({
		            type: "POST",
		            url: "process_rettachsim.php",
		            data: NumberData,
		            cache: false,
		            success: function(data){

		            	location.reload();
		            }
		        });
		    } else {
		        txt = "Please again Select!";
		    }

		
	}

</script>

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
        loader: false,

        status_bar: true,

        status_bar_css_class: 'myStatus',

        extensions:[{
            name: 'sort',
            types: ['number','number','number','number','number','number','string','string','number','number','number','string']
        }]
    };
    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>