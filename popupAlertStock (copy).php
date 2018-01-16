<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
//print_r($_POST); die;
// if($_POST['status']==0)
// {
// 	//echo '9320';die;
// 	//print_r($_POST); die;
// 	$popup_alertStock1=$_POST['status'];
// 	$popup_alertStock = array('popup_alertStock' => $popup_alertStock1);
// 	$installation_id1=$_POST['installation_id'];
// 	$installation_id = array('inst_req_id' => $installation_id1);
// 	//echo "UPDATE internalsoftware.installation SET popup_alertStock='".$popup_alertStock1."' where id='".$installation_id1."' "; die;
// 	$update=db__update_staging('internalsoftware.installation',$popup_alertStock,$installation_id);
// 	//$update=update_query('internalsoftware.installation',$popup_alertStock,$installation_id);
// 	//$update=db__select_staging("UPDATE internalsoftware.installation SET popup_alertStock='".$popup_alertStock1."' where id='".$installation_id1."'  ");
// 	//echo $update; die;
// 	//print_r($update); die;
// 	if($update==1)
// 	{
// 		echo "Successfully assigned by Stock";
// 	}
// }
if($_POST['status']==1)
{
	//echo "select id,inst_id from internalsoftware.installation_request where popup_alertStock=1 and installation_status=2 limit 1"; die;
	  $installList=db__select_staging("select id,inst_id from internalsoftware.installation_request where popup_alertStock=1 and installation_status=2");
	  //echo count($installList);die;
	  

	  if(count($installList)<1)
	  {
	  		$installList=db__select_staging("select id,inst_id from internalsoftware.services where popup_alertStock=1 and service_status=2 limit 1");

	  }
	  if(count($installList)<1)
	  {
	  		$installList=db__select_staging("select id,inst_id from internalsoftware.services_crack where popup_alertStock=1 and service_status=2 limit 1");
	  		
	  }
	
	//echo count($installList);die;
	if(count($installList)>0)
	{
		//echo 'tt';die;
		//echo $installList[$i]['inst_id']; die;
			for($i=0;$i<count($installList);$i++)
			{
				if($installList[$i]['inst_id']!=""  ||$installList[$i]['inst_id']!="")
				{
					//echo "select inst_name from internalsoftware.installer where is_active='1'and inst_id='".$installList[$i]['inst_id']."' "; die;
				$installName=db__select_staging("select inst_name from internalsoftware.installer where is_active='1'and inst_id='".$installList[$i]['inst_id']."' ");

			// 	$noOfInstallation= $installerList[$i]['installation_approve'];
			 	$installerName= $installName[0]['inst_name'];
			 	$id= $installList[$i]['id'];
			// 	//echo '<pre>'; print_r($installerList); die;
			// 	//echo "Please give ".$noOfInstallation." Devices to ".$installerName;
		 			echo $id.'##'.$installerName.'##'.$installList[$i]['inst_id'];
				}
				else
				{
					//echo "1";
					continue;
				}
			}
		
	}
	else
	{
		echo "No Installer is remain here to assign the devices";
	}
	// $installerList=db__select_staging("select installation_approve,inst_name,id,inst_req_id from internalsoftware.installation where popup_alertStock=1 limit 1");
	// if(count($installerList)>0)
	// {
	// 	for($i=0;$i<count($installerList);$i++)
	// 	{
	// 		$noOfInstallation= $installerList[$i]['installation_approve'];
	// 		$installerName= $installerList[$i]['inst_name'];
	// 		$id= $installerList[$i]['id'];
	// 		//echo '<pre>'; print_r($installerList); die;
	// 		//echo "Please give ".$noOfInstallation." Devices to ".$installerName;
	// 		echo $noOfInstallation.'##'.$installerName.'##'.$id;
	// 	}
	// }
	// else
	// {
	// 	echo "No Installer is remain here to assign the devices";
	// }
	
}


?>