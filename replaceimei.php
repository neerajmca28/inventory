<?php
include("config.php");
include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$Display_ReplaceIMEI=select_Procedure("CALL Display_ReplaceIMEI()");
$Display_ReplaceIMEI=$Display_ReplaceIMEI[0];
$rowcount=count($Display_ReplaceIMEI);
$masterObj = new master();
//echo '<pre>'; print_r($Display_ReplaceIMEI); echo '</pre>';die;
if($_SESSION['user_name_inv']!='delhiStock')
{
 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php
}
if(isset($_POST['submit']))
{
	$count=0;
	$flag=0;
	$errorMsg=array();
	for($i=0;$i<$rowcount;$i++)
	{
		for($j=$i+1;$j<$rowcount;$j++)
		{
			if(($_POST['new_imei'][$i]==$_POST['new_imei'][$j]) && (!empty($_POST['new_imei'][$i]) || $_POST['new_imei'][$i]!="") ) 
			{
				//echo 'tt';
				$flag=1;
				break;
			}
		}
	}
	
		if($flag==0)
		{
				for($i=0;$i<$rowcount;$i++)
				{
					if(!empty($_POST['new_imei'][$i]) || $_POST['new_imei'][$i]!="")
					{
						//echo 'ss';
						$checkIMEI=$masterObj->checkIMEI($_POST['new_imei'][$i]);
						if($checkIMEI>0)
						{
							$flag=2;
							break;
						}
					}
					if(empty($_POST['new_imei'][$i]) || $_POST['new_imei'][$i]=="")
					{
						//echo 'hh';
						$count++;
						//$flag=3;
					}
					else
					{
						$flag=4;
					}	
				}
		}
				
				
	
	//echo $count;die;
		//die;
	
	if($flag==1)
	{
		 $errorMsg="Enter the Unique IMEI in each Textbox";
	}
	else if($flag==2)
	{
		 $errorMsg="IMEI Already Exist";
	}
	else if($count==$rowcount)
	{
		//echo $count;die;
		$errorMsg="Please Insert Atleast One IMEI No.";
	} 
	else
	{
		for($i=0;$i<$rowcount;$i++)
		{
			// echo 'tt'; die;
			 $DeviceId=$_POST['device_id'][$i]; 
			 $new_ime=$_POST['new_imei'][$i]; 
			
			if(!empty($_POST['new_imei'][$i]) || $_POST['new_imei'][$i]!="")
			{
				//echo 'hh';die;
				//echo "CALL ReplaceIMEI('".$DeviceId."', '".$new_ime."')";die();
				$tt=select_Procedure("CALL ReplaceIMEI('".$DeviceId."', '".$new_ime."')");
				$flag=3;				
			}
		
			
		}
		?><script><?php echo("location.href = '".__SITE_URL."/manufacturedevice.php';");?></script><?php
		//echo 'tt'; die;
		
	}
	
	
	if($errorMsg!="")
	{	
		echo "<script type='text/javascript'>alert('$errorMsg');</script>";	
	}		
	
}
?>
<head>
</head>
<body>
<article>
  <div class="col-12">
      	<form name="replace_imei" id="replace_imei" method="post" action="" onsubmit="return validateForm();">
      <!-- BEGIN BORDERED TABLE PORTLET-->
      <div class="portlet box yellow">
        <div class="portlet-title">
          <div class="caption"> Replace IMEI </div>
        </div>
        <div class="portlet-body fix-table"> 
        <table class="table table-bordered">
           <thead>
            <tr>
              <th>ITGC ID </th>
              <th>New IMEI </th>
            </tr>
          </thead>
          <tbody>
		  <?php
		  for($x=0;$x<$rowcount;$x++)
			{$y=$x+1;?>
		
			<tr><td><?php echo $Display_ReplaceIMEI[$x]['itgc_id']; ?></td>
			<td><input type="text" name="new_imei[]" class="form-control" id="new_imei_<?php echo $y;?>"  onblur="myFunction(this.value,'<?php echo $y;?>')"></td>
			<input type="hidden" name="itgc_id[]" id="itgc_id" value="<?php echo $Display_ReplaceIMEI[$x]['itgc_id']; ?>">
			<input type="hidden" name="old_imei[]" id="old_imei" value="<?php echo $Display_ReplaceIMEI[$x]['device_imei']; ?>"></tr>
		    <input type="hidden" name="client_name[]" id="client_name" value="<?php echo $Display_ReplaceIMEI[$x]['client_name']; ?>"></tr>
		    <input type="hidden" name="device_id[]" id="device_id" value="<?php echo $Display_ReplaceIMEI[$x]['device_id']; ?>"></tr>
			<input type="hidden" name="veh_no[]" id="veh_no" value="<?php echo $Display_ReplaceIMEI[$x]['veh_no']; ?>"></tr>
			<input type="hidden" name="device_sno[]" id="device_sno" value="<?php echo $Display_ReplaceIMEI[$x]['device_sno']; ?>"></tr>
			 </tr>
		<?php
			}
        ?>
		  <tr>
              <td colspan="11"><input type="submit" onClick="bulk()" class="btn btn-primary" style="width:100px;" name="submit" id="submit" value="Add"></td>
            </tr>
          </tbody>
        </table>
        </div>
      </div>
  	</form>
    <!-- END BORDERED TABLE PORTLET--> 
  </div>
</article>

</body>
<script>
var $tt = jQuery.noConflict();
function validateForm() 
{
	 //alert('tt');
	 var c=0;
	 var new_imei = document.getElementsByName('new_imei[]');
	 $tt('input[name="new_imei[]"]').each(function(){
		// alert($tt(this).val());
		if($tt(this).val()=="" || $tt(this).val()==0)
		{
			c++;
		}
	
		});
		if(c==new_imei.length)
		{
			alert("At least fill one IMEI");
			return false;
		}
	 //alert(new_imei.length);
	 //alert(new_imei[1].value); return false;
  /* for(var i = 0, i < new_imei.length; i++) 
	 {
		 alert('tt');
		
	 }  */
	 /* if(c>0)
	 {
		 alert("At least fill one IMEI");
		 return false;
	 }  */
	 
}

</script>
</html>