<?php
include_once('connection.php');
if(!empty($_POST['rowVal']) && !empty($_POST['remark']) && !empty($_POST['con']) && !empty($_POST['imm'])){
	if(isset($_POST['submit'])){
		$rowVal_array = $_POST['rowVal'];
	    $remark_array = $_POST['remark'];
	    $con_array = $_POST['con'];
	    $imm_array = $_POST['imm'];
	    for ($i = 0; $i < count($rowVal_array); $i++) {

	        $sql="INSERT INTO `dispatchdb`(`checbox`, `remarks`, `connectors`, `immobilizer`) VALUES('".$rowVal_array[$i]."','".$remark_array[$i]."','".$con_array[$i]."','".$imm_array[$i]."')";

	        if($excute=mysqli_query($dblink2,$sql)){
				header("Location:index.php");
			}
			else{
				echo "Not Submitted";
			}
	    } 
	}
}		
?>