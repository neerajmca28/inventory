<?php
error_reporting(0);
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(isset($_SESSION['branch_id'])) {

  if(isset($_SESSION['user_name_inv']) && isset($_SESSION['userId_inv']) && !empty($_SESSION['user_name_inv']) &&  !empty($_SESSION['userId_inv']))
  {
    $data=select_Procedure("CALL SelectTestedDevice()");
    $data=$data[0];
    $datasim=select_Procedure("CALL SelectSimNo()");
    $datasim=$datasim[0];

    //$strPhoneNo = $_POST['simno'];
    //$strPhoneNo = '7505854066';
    //$msgText = "Vehicle : sim test";

    // $strUrl = "http://api.mVaayoo.com/mvaayooapi/MessageCompose?user=gary@itglobalconsulting.com:itgc@123&senderID=GTRACK&receipientno='".$strPhoneNo."'&dcs=0&msgtxt='".$msgText."'&state=4";
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
    // $buffer = curl_exec($ch);

    // if(empty ($buffer)){ echo " buffer is empty "; } else { echo $buffer; }

    // curl_close($ch); 

    $MSG="Vehicle : sim test";
    //$MobileNum=$_POST["Number"];
    $MobileNum='7505854066';

    $ch = curl_init();
    $user="gary@itglobalconsulting.com:itgc@123";
    $receipientno=$MobileNum;
    $senderID="GTRACK";
    $msgtxt=$MSG;
    curl_setopt($ch,CURLOPT_URL, "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
    $buffer = curl_exec($ch);
    if(empty ($buffer)) { echo " buffer is empty "; }
    else { echo $buffer; echo "Successfully Sent"; }
    curl_close($ch);  


    }

}  
else {

  ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php

}  
?>
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Attach Sim</div>
         </div>
         <div class="portlet-body fix-table">
           <table class="table table-bordered table-hover" id="filtertable">
             <thead>
               <tr>
                 <th> S No. </th>
                 <th> ITGC ID </th>
                 <th> Device Serial No.</th>
                 <th> IMEI </th>
                 <th> Recieved Date </th>
                 <th> Attach Sim </th>
               </tr>
             </thead>
             <tbody>
                <?php 
                for($i=0;$i<count($data);$i++){
                ?>
                <tr>
                  <td><?php echo $i+1; ?></td>
                  <td><?php echo $data[$i]['itgc_id']; ?></td>
                  <td><?php echo $data[$i]['device_sno']; ?></td>
                  <td><?php echo $data[$i]['device_imei']; ?></td>
                  <td><?php echo date('d-m-Y H:i:s',strtotime($data[$i]['recd_date']));  ?></td>
                  <td><input type="button" onclick="enable(<?php echo $i;?>)" value="AttachSim" name="attbtn<?php echo $i;?>" id="attbtn<?php echo $i;?>"></td>
                </tr>
                <?php               
                } 
                ?>
             </tbody>
           </table>
            <form method="post">
            <div>
                 <label>Phone Number</label>
                 <select id="simno" name="simno" disabled="disabled" />
                   <option role="presentation" value="0">Select</option>
                   <?php 
                    for($i=0;$i<count($datasim);$i++){

                   ?>
                   <option role="presentation" value="<?php echo $datasim[$i]['phone_no']; ?>"><?php echo $datasim[$i]['phone_no']; ?></option>
                   <?php } ?>
                   <?php 
                    for($i=0;$i<count($datasim);$i++){
                   ?>
                   <input type="hidden" value="<?php echo $datasim[$i]['device_imei']; ?>" name="deviceimei">
                   <?php } ?>
                 </select> 
            </div>
            
         </div>
         <input type="submit" onClick="bulk()" name="submit" class="btn btn-default table-btn-submit" id="submit" value="ATTACH">
            </form> 
       </div>
       <!-- END BORDERED TABLE PORTLET--> 
     </div>
   </article>
   <script type="text/javascript">
      function enable(rowId){
        var sim=document.getElementById("attbtn"+rowId).onclick;
        if(sim){
          document.getElementById("simno").disabled = false;
        }
        else{
          document.getElementById("simno").disabled = true;
        }    
      }
      $(document).ready(function () {
        $('tr').click(function () {
          if(this.style.background == "" || this.style.background =="white") {
              $(this).css('background', '#D5D4D4');
          }
          else {
              $(this).css('background', 'white');
          }
        });
      });
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