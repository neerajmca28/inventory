<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
?>
<article>
  <div class="col-md-12 col-12"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa"></i>Search By </div>
      </div>
      <div class="portlet-body control-box">
           <div class="content-box">
        
           <div class="right-item"> <table>
            <tr>
               <td><input type="radio" name="Gtrac"></td>
              <td>Device IMEI </td>
			   <td><input type="radio" name="Gtrac"></td>
              <td>Client Name</td>
              <td><input type="radio" name="Gtrac"></td>
              <td>Device ID </td>
              <td><input type="radio" name="Gtrac"></td>
              <td>Change IMEI </td>
            </tr>
          </table></div>
          </div>
           <div class="content-box">
           <div class="left-item"> <span> Filtering By Device IMEI  :</span> </div>
          <div class="right-item two-filter-inp"><input type="text" name="No-Of-Devices" class="form-control"></div>
          </div>
          
           <div class="content-box">
           <div class="left-item"></div>
          <div class="right-item"><input  class="btn btn-primary" type="button" name="Submit" value="Submit"> </div>
          </div>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
  
</article>
</body>
</html>