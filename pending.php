<?php

include_once('config.php'); 
include_once(__DOCUMENT_ROOT.'/private/master.php'); 

	$queryexport=mysql_query("SELECT * FROM user_details");
    $columnHeader ='';
    $columnHeader = "User Id"."\t"."User Name"."\t"."Login"."\t"."Password"."\t"."EmailId"."\t"."Date Joining"."\t"."Active Status"."\t"."Branch Id"."\t";


    $setData='';

    while($rec = mysql_fetch_array($queryexport))  
    {
      $rowData = '';
      foreach($rec as $value)       
      {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
      }
      $setData .= trim($rowData)."\n";
    }
    //echo "<pre>";print_r($setData);die();

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=User_Detail_Reoprt.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo $excelFile = ucwords($columnHeader)."\n".$setData."\n";


    // EMail Send

    
    $myfile = fopen("PendingInfo".date(Ymd).".xls", "w") or die("Unable to open file!");
    
    fwrite($myfile, $excelFile);    
    
    fclose($myfile);

       $to = "aneeraj81@gmail.com";
       $subject = "Thanks you for Register in PublisherWall Tools";
       
       $message = "<b>Your User</b>:".$email;
       $message .= "</br><b>Your Password</b>:";
       $message .= "<h4>Login Link</h4>";
       $message .= "<a href='http://publisherwall.net/dev/'>Click for Login Link</a>";
       
       $header = "From:neeraj@gtrac.in \r\n";
      
       $header .= "MIME-Version: 1.0\r\n";
       $header .= "Content-type: text/html\r\n";
       
       $retval = mail ($to,$subject,$message,$header);
       
       if( $retval == true ) {
         $msg="success";
          //echo "Message sent successfully...";
       }else {
          //echo "Message could not be sent...";
         $msg="Email sent fail";
       }

?>

