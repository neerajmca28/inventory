<?php
include('config.php');
include('include/header.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
if(!isset($_SESSION['branch_id']))
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
  $data=select_Procedure("CALL SelectSimDettachment()");
  $data=$data[0];
  
?>
<head>
</head>
<body>
   <article>
     <div class="col-12"> 
       <!-- BEGIN BORDERED TABLE PORTLET-->
       <div class="portlet box yellow">
         <div class="portlet-title">
           <div class="caption"> <i class="fa fa"></i>Select SIM For RD Recive</div>
         </div>
         <div class="portlet-body">
           <table class="table table-bordered table-hover">
             <tbody>
                <tr>
                  <td><label>There is no SIM for Assignment</label></td>
	           </tbody>
           </table>
   		  <div>
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
   </script>
</body>
</html>