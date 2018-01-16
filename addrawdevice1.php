<?php
ob_start();
include("config.php"); 
include_once(__DOCUMENT_ROOT.'/private/master.php'); 


?>
<head>

</head>



<script src="<?php echo __SITE_URL;?>/bootstrap/1.12.4/jquery.min.js"></script>

<script lang="javascript" type="text/javascript">
       $(document).ready(function () {
     alert('tt');
           $.ajax({
                       type: "GET",
                     //url:'http://203.115.101.109/newtracking/clientview/challandetail_mahaveera.php',
       url:'http://trackingexperts.com/mobileapp/vehilestatus_xpress.php?veh_reg=HR744403',
        //url:'https://api.nike.com/plus/v3/plans/me?source=nike.nrc&source=nike.ntc&created_before=now&access_token=qBGdnD1Nd2sbPZigJHN2AgfBgdnf',
         //url:'http://192.168.1.164/testing/final2.php',
                               dataType : 'json',
       
          data:{},
 
                       success: function(data)
        {
        // alert('tt');
         alert(data);
          //alert(data.vehicle_no);
        // alert(data.error_id);
          //title = data.title;
       //alert(title);
        }
     });
    });

 </script>
</html>