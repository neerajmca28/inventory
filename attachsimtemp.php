<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

if($_SESSION['user_name_inv']!='aditya')
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}

  $data=select_Procedure("CALL SelectConfigureDevices()");
  $data=$data[0]; 
  //print_r($data);die();

  $data1=select_Procedure("CALL SelectTestedSimNo()");
  $data1=$data1[0]; 
  //print_r($data1);die();

?>
<style>
tr.highlighted {
    background:#ffd396;
}
</style>
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Attach Sim Temprarily</div>
         </div>
         <div class="portlet-body fix-table">
           <table class="table table-bordered" id="filtertable">
             <thead>
               <tr>
                 <th> S No. </th>
                 <th> Device Serial No. </th>
                 <th> ITGC ID </th>
                 <th> IMEI </th>
                 <th> Recieved Date </th>
                 <th> Attach Sim </th>
               </tr>
             </thead>
             <tbody>
                <?php 
                for($i=0;$i<count($data);$i++){


                  if($i == 0){
                    for($j=0;$j<count($data1);$j++){
                      $select .= '<option value="'.$data1[$j]['sim_id'].'">'.$data1[$j]['phone_no'].'</option>';
                    }
                  }


                ?>
                <tr id="row<?php echo $i; ?>">
	                <td><?php echo $i+1; ?></td>
	                <td><?php echo $data[$i]['device_id']; ?></td>
	                <td><?php echo $data[$i]['itgc_id']; ?></td>
                  <td><?php echo $data[$i]['device_imei']; ?></td>
	                <td><?php echo date("d-m-Y h:i:s",strtotime($data[$i]['recd_date'])) ?></td>
                	<td><input type="button" value="AttachSim" class="btn btn-info" onclick="ChangeRowColor('row<?php echo $i; ?>','btn<?php echo $i; ?>','imei_<?php echo  $data[$i]['device_imei']; ?>','deviceid_<?php echo $data[$i]['device_id']; ?>')" name="btn<?php echo $i;?>" id="btn<?php echo $i;?>"></td>
                  <input type="hidden" value="" id="hideImei">
                  <input type="hidden" value="" id="hideSimId">
                  <input type="hidden" value="" id="hidePhNumber">
                  <input type="hidden" value="" id="hideDeviceId">
                </tr>
                <?php              	
             		}
           	    ?>
             </tbody>
           </table>
   		  
        <div>
          <label>Phone Number</label> 
          <select name="phno" disabled="disabled" id="simno" onchange="getSimId()">
            <option value="0">--SELECT--</option>
            <?php echo $select; ?>
          </select>
        </div>
            <button type="submit" name="submit" class="btn btn-default table-btn-submit" onclick="finalSubmit()" id="finalSubmit" value="">ATTACH</button>
        </div>
      </div>
     <!-- END BORDERED TABLE PORTLET--> 
     </div>
   

   </article>
   <script type="text/javascript">   
     
	 $(document).ready(function(){
		$('#filtertable tr').click(function(e) {
			$('#filtertable tr').removeClass('highlighted');
			$(this).addClass('highlighted');
			
		});
	})
      function ChangeRowColor(row,btn,imei,deviceid) {

        // Imei Id
        var fields = imei.split('_');
        var name = fields[0];
        var street = fields[1];
        document.getElementById("hideImei").value = street; 
        //alert(street)
        // End Imei


        // Device Id
        var fields1 = deviceid.split('_');
        var name1 = fields1[0];
        var street1 = fields1[1];
        document.getElementById("hideDeviceId").value = street1; 
        //alert(street1)
        // End Device Id
       
          

         //document.getElementById(row).style.backgroundColor = "#a4cbe3";   
         document.getElementById("simno").disabled=false;           
         document.getElementById("finalSubmit").disabled=false;
          
          var hiddenControl = document.getElementById(hideImei).value
          var hidenIMEI = document.getElementById(hideName); 

          document.getElementById(hiddenControl).value = document.getElementById(row).cells[0].firstChild.data;
          document.getElementById(hidenIMEI).value = document.getElementById(row).cells[3].firstChild.data;
         
          previousRow = row;
         return false;
        }

      function getSimId(){
        var simphone = document.getElementById("simno");
        var simId = simphone.options[simphone.selectedIndex].value;
        var phnumber = simphone.options[simphone.selectedIndex].text;
        document.getElementById("hideSimId").value = simId; 
        document.getElementById("hidePhNumber").value = phnumber;
      }

      function finalSubmit(){

        var imei=document.getElementById("hideImei").value;
        var simid=document.getElementById("hideSimId").value;
        var phnumber=document.getElementById("hidePhNumber").value;
        var deviceid=document.getElementById("hideDeviceId").value;

        var datastring = 'imei='+imei+'&simid='+simid+'&phnumber='+phnumber+'&deviceid='+deviceid;
        //alert(datastring)
        if(imei=='' || simid=='' || phnumber=='' || deviceid=='')
        {
          alert("Please Attach Sim");
        }
        else
        {
          $.ajax({
            url:"process_attchsimtmp.php", //the page containing php script
            type: "POST", //request type
            data: datastring,
            success:function(result){
             //alert(result);
             document.location.href = 'testdevice.php';
             }
          });
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
            types: ['number', 'number','string','number','number','number']
        }]
    };
    var tf = new TableFilter('filtertable', filtersConfig);
    tf.init();
</script>
</body>
</html>