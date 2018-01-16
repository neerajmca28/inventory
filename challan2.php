<?php
ob_start();
//ini_set("session.auto_start", 0);
include("config.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
require_once('/fpdf/fpdf.php');

 //echo date('H:i:sa'); die;
$masterObj = new master(); 
 //print_r($_GET); die; 
$login_name=$_SESSION['user_name_inv'];
$strChallanNo=$_GET['challanNo'];
$to_installer_name=$_GET['to_installer'];
//$strChallanNo='CHNO109';
 $GetInstallerChallanDetailByNo=$masterObj->GetInstallerChallanDetailByNo($strChallanNo);  
$count=count($GetInstallerChallanDetailByNo);

//echo '<pre>';print_r($GetInstallerChallanDetailByNo);die;	  
if($count>1)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">

    <script type="text/javascript" language="javascript">
        function HidePrintButton() {
            document.getElementById("divPrintButton").style.display = 'none';
            window.print();
            window.close();
            return false;
        }
    </script>

    <title>

</title><link href="css/style.css" rel="stylesheet" type="text/css" /></head>
<body>
    <form name="form1" method="post" action="PrintChallanInstaller.aspx?CHNO=CHNO12727" id="form1">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwULLTE5NDY0MzAzMTIPZBYCAgMPZBYCAgEPZBYOAgEPDxYCHgRUZXh0BQlDSE5PMTI3MjdkZAIDDw8WAh8ABQsxMiBBcHIgMjAxN2RkAgUPDxYCHwAFCDE4OjQzOjM4ZGQCBw8PFgIfAAUSQVBNIE1hcmtldFZlaGljbGVzZGQCCQ8PFgIfAAUKZGVsaGlTdG9ja2RkAgsPFgIeB1Zpc2libGVoZAINDzwrAA0BAA8WBB4LXyFEYXRhQm91bmRnHgtfIUl0ZW1Db3VudAIBZBYCZg9kFgQCAQ9kFhBmD2QWAmYPFQEBMWQCAQ8PFgIfAAUIMDE4MTkxMDVkZAICDw8WAh8ABQ8zNTI4NDgwMjcwOTE5ODhkZAIDDw8WAh8ABQRNaXNjZGQCBA8PFgIfAAUBMGRkAgUPDxYCHwAFBE5vbmVkZAIGDw8WAh8ABQEwZGQCBw8PFgIfAAUBMGRkAgIPDxYCHwFoZGQYAQUQZ3JkQ2hhbGxhbkRldGFpbA88KwAKAQgCAWTia37iV0pA7qN0xod0GsoVz8fe4Q==" />
</div>

    <div id="Challan">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" border="1">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" border="1">
                        <tr>
                            <td colspan="5">
                                <img src="images/header3.png" width="700" height="30" />
							</td>
						</tr>
						<tr>
							<td style="valign" width:80%" >
								<img src="images/header1.png" width="400" height="250" />
							</td>
						
							<td nowrap>Challan No :<?php echo $strChallanNo; ?><br>Date :<?php echo date('y-m-d'); ?><br>Time:<?php echo date('H:i:s'); ?></td>
							
                            
                       </tr>
                      
                    </table>
					   
                        <tr>
                            <td class="margin">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
                     
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-left: 20px; padding-right: 20px; padding-top: 10px;">
                               <span id="lblTime"><strong>DELIVERY CHALLAN</strong></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="120px" class="autogenrate-text">
                                            <div align="left" style="padding-top: 8px; width: 120px;">
                                                Installer Name :</div>
                                        </td>
                                        <td width="122" align="left" style="padding-top: 8px; width: 150px;">
                                            <span id="lblInstallerName"><?php echo $to_installer_name; ?> </span>
                                        </td>
                                        <td width="120px" valign="top" class="autogenrate-text">
                                            <div align="left" style="padding-top: 8px; width: 120px;">
                                                Delivered by :</div>
                                        </td>
                                        <td width="122" align="left" style="padding-top: 8px; width: 150px;">
                                            <span id="lblDeliveredBy"><?php echo $login_name; ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
                         
                         <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
     <tr>
     <td valign="top" style="padding-left: 20px; width: 100%">
     <div>
	<table cellspacing="0" rules="all" border="1" id="grdChallanDetail" style="width:98%;border-collapse:collapse;">
		<tr align="left">
			<th scope="col">SNo.</th><th scope="col">ITGC ID</th><th scope="col">IMEI</th><th scope="col">Device Type</th><th scope="col">Antenna</th><th scope="col">ImmobelizerType</th><th scope="col">Immobelizer</th><th scope="col">Connector</th>
		</tr><?php 
		for($j=0;$j<$count;$j++)
		{
			$y=$j+1;
		?>
			<tr align="left">
			<td style="height:20px;"><?php echo $y;?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['itgc_id'];?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['device_imei'];?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['DeviceType'];?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['AssignedAntennaCount'];?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['AssignedImmobilizerType'];?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['AssignedImmobilizerCount'];?></td>
			<td align="center"><?php echo $GetInstallerChallanDetailByNo[$j]['AssignedConnectorCount'];?></td>
			</tr>
		<?php }?>
	</table>
</div>
 </td>
 </tr>
                        <tr>
                            <td style="padding-left: 20px; padding-right: 20px;">
                                &nbsp;
                            </td>
                        </tr>
               
                     
                   
                        <tr>
                            <td>
                                <img src="images/footer.png" width="700" height="150" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="divPrintButton">
                                    <label>
                                        <input type="submit" name="Submit" value="Print" onclick="return HidePrintButton()" />
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    </form>
</body>
</html>
<?php
}
else
{
	echo "There is Some Problem. Please Inform Your Software Team";
}
