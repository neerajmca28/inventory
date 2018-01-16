<?php
include("config.php");
include('include/header.php');
?>
<article>
  <div class="col-md-6"> </div>
  <div class="col-md-6"> 
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet box yellow">
      <div class="portlet-title">
        <div class="caption"> <i class="fa fa-coffee"></i>Bordered Table </div>
      </div>
      <div class="portlet-body">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th> # </th>
              <th> First Name </th>
              <th> Last Name </th>
              <th class="hidden-XS"> Username </th>
              <th> Status </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td> 1 </td>
              <td> Mark </td>
              <td> Otto </td>
              <td class="hidden-XS"> makr124 </td>
              <td><span class="label label-success"> Approved </span></td>
            </tr>
            <tr>
              <td> 2 </td>
              <td> Jacob </td>
              <td> Nilson </td>
              <td class="hidden-XS"> jac123 </td>
              <td><span class="label label-info"> Pending </span></td>
            </tr>
            <tr>
              <td> 3 </td>
              <td> Larry </td>
              <td> Cooper </td>
              <td class="hidden-XS"> lar </td>
              <td><span class="label label-warning"> Suspended </span></td>
            </tr>
            <tr>
              <td> 3 </td>
              <td> Sandy </td>
              <td> Lim </td>
              <td class="hidden-XS"> sanlim </td>
              <td><span class="label label-danger"> Blocked </span></td>
            </tr>
            <tr>
              <td> 1 </td>
              <td> Mark </td>
              <td> Otto </td>
              <td class="hidden-XS"> makr124 </td>
              <td><span class="label label-success"> Approved </span></td>
            </tr>
            <tr>
              <td> 2 </td>
              <td> Jacob </td>
              <td> Nilson </td>
              <td class="hidden-XS"> jac123 </td>
              <td><span class="label label-info"> Pending </span></td>
            </tr>
            <tr>
              <td> 3 </td>
              <td> Larry </td>
              <td> Cooper </td>
              <td class="hidden-XS"> lar </td>
              <td><span class="label label-warning"> Suspended </span></td>
            </tr>
            <tr>
              <td> 3 </td>
              <td> Sandy </td>
              <td> Lim </td>
              <td class="hidden-XS"> sanlim </td>
              <td><span class="label label-danger"> Blocked </span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>
</body>
</html>