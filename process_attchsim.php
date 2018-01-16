<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');
include("device_status.php");

	//$MSG="Vehicle : sim test";
    //$MobileNum='7505854066';
    //$MobileNum=$_POST["simno"];

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
    if(empty($buffer))
    { 
      echo " buffer is empty ";
    }
    else 
    {
         //echo $buffer;
         //echo "Successfully Sent";
		$device = $_POST['deviceid'];
      	$simid = $_POST['simid'];
		$devicestatus = $AttachSim_At_Stock_Recd;
        //echo "CALL AttachPermentPhoneNo('".$device."','".$simid."','".$devicestatus."')"; die;
		$attachSim=select_Procedure("CALL AttachPermentPhoneNo('".$device."','".$simid."','".$devicestatus."')");
		print_r($attachSim);
    	//$attachSim=$attachSim[0];

    }
    curl_close($ch);  

