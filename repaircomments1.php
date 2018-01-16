<?php
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

//print_r($_POST);

if(isset($_POST['devid'])){
    $device_id = $_POST['devid'];
    $comment = $_POST['commnt'];
    $username = $_POST['usrnm'];
    $getRepairComment=select_Procedure("CALL AddRepairComment('".$device_id."','".$comment."','".$username."')");
	if(count($getRepairComment)>0)
	{
		echo "Comment Successfully Added.";
	}
	else
	{
		echo "There is Some Problem.";
	}
    
}

