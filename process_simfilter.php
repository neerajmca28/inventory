<?php
error_reporting(0);
include('config.php');
include_once(__DOCUMENT_ROOT.'/private/master.php');

// Search Dispatch Report
if(isset($_POST['simphone'])){
    $simphn = $_POST['simphone'];
    $simphn_count = strlen($simphn);
    if ($simphn_count == 10) {
        $simphonesearch=select_Procedure("CALL SearchSim('NIL','".$simphn."')");
    }
    else{
         $simphonesearch=select_Procedure("CALL SearchSim('".$simphn."','NIL')");
    }
    $simphonesearch=$simphonesearch[0]; 
    
    if(count($simphonesearch) > 0) {

    for($i=0;$i<count($simphonesearch);$i++){
        
        if($simphonesearch[$i][0]== 1){
           $sim1 = "NIL";
        }
        else {
            $sim1 = "NIL";
        }
       
        if($simphonesearch[$i][1]== 1){
          $sim2 = "NIL";
        }
        else {
            $sim2 = "NIL";
        }

        if($simphonesearch[$i][6]== 1){
          $sim6 = "Inactive";
        }
        else{
          $sim6 = "Active";
        }

        if($simphonesearch[$i][7]== 1){
          $sim7 = "Used";
        }
        else{
          $sim7 = "Unused";
        }
              
        $abc[$i] = array(
            "simphmo1" => $sim1,
            "simphmo2" => $sim2,
            "sim_no"  => $simphonesearch[$i][2],
            "phone_no" => $simphonesearch[$i][3],
            "rec_date" => $simphonesearch[$i][4],
            "owner" => $simphonesearch[$i][5],
            "simphmo6" => $sim6,
            "simphmo7" => $sim7
        );

       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
    }
  else{
    echo $err = "Error";
  }  
}    
// End Search Dispatch Report

// Search Dispatch Report
if(isset($_POST['dt1'])){
    $date1 = $_POST['dt1'];
    $date2 = $_POST['dt2'];
    $simphonesearchdate=select_Procedure("CALL SearchSimDate('".$date1."','".$date2."')");
    $simphonesearchdate=$simphonesearchdate[0]; 
  for($i=0;$i<count($simphonesearchdate);$i++){
        
        if($simphonesearchdate[$i][0]== 1){
           $sim1 = "NIL";
        }
        else {
            $sim1 = "NIL";
        }
       
        if($simphonesearchdate[$i][1]== 1){
          $sim2 = "NIL";
        }
        else {
            $sim2 = "NIL";
        }

        if($simphonesearchdate[$i][6]== 1){
          $sim6 = "Inactive";
        }
        else{
          $sim6 = "Active";
        }

        if($simphonesearchdate[$i][7]== 1){
          $sim7 = "Unused";
        }
        else{
          $sim7 = "Used";
        }
              
        $abc[$i] = array(
            "simphmo1" => $sim1,
            "simphmo2" => $sim2,
            "sim_no"  => $simphonesearchdate[$i][2],
            "phone_no" => $simphonesearchdate[$i][3],
            "rec_date" => $simphonesearchdate[$i][4],
            "owner" => $simphonesearchdate[$i][5],
            "simphmo6" => $sim6,
            "simphmo7" => $sim7
        );

       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
}    
// End Search Dispatch Report
// Search Dispatch Report
if(isset($_POST['status'])){
    $simstatuscheck = $_POST['status'];
   
    $simstatusrecord=select_Procedure("CALL SearchSimStatus('".$simstatuscheck."')");
    $simstatusrecord=$simstatusrecord[0]; 
  
    if(count($simstatusrecord) > 0) {

    for($i=0;$i<count($simstatusrecord);$i++){
       
        if($simstatusrecord[$i][0]== 1){
           $sim1 = "NIL";
        }
        else {
            $sim1 = "NIL";
        }
       
        if($simstatusrecord[$i][1]== 1){
          $sim2 = "NIL";
        }
        else {
            $sim2 = "NIL";
        }

        if($simstatusrecord[$i][6]== 1){
          $sim6 = "Inactive";
        }
        else{
          $sim6 = "Active";
        }

        if($simstatusrecord[$i][7]== 1){
          $sim7 = "Unused";
        }
        else{
          $sim7 = "Used";
        }
              
        $abc[$i] = array(
            "simphmo1" => $sim1,
            "simphmo2" => $sim2,
            "sim_no"  => $simstatusrecord[$i][2],
            "phone_no" => $simstatusrecord[$i][3],
            "rec_date" => $simstatusrecord[$i][4],
            "owner" => $simstatusrecord[$i][5],
            "simphmo6" => $sim6,
            "simphmo7" => $sim7
        );

       $s[$i]=$abc[$i]; 
    }
    echo json_encode($s);
    }
  else{
    echo $err = "Error";
  }  
}    
// End Search Dispatch Report
?>