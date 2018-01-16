<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script lang="javascript" type="text/javascript">
   $(document).ready(function () {
	   
       $.ajax({
           type: "GET",
           url: "http://203.115.101.109/newtracking/clientview/challandetail_mahaveera.php?vehicle_no=HR47C8007",
           success: function(data)
		   {
			   alert(data);
			   //alert(data.place_date);
			   //$tt=json.parse[data];
			   //var tt = JSON.parse(data);
			   //alert(tt.place_date);
		   }
	   });
   });
</script>