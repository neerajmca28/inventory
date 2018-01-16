<?php
include("config.php");
//include("include/header.php");
include_once(__DOCUMENT_ROOT.'/private/master.php'); 
$data=array();
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
	// echo "select id,inst_id from internalsoftware.installation_request where popup_alertStock=1 and installation_status=2 limit 1"; die;
	  $installList=db__select_staging("select id,inst_id,instal_reinstall from internalsoftware.installation_request where popup_alertStock=1 and installation_status=2");
	  //echo count($installList);die;
	  if(count($installList)>0)
	  {

			for($s=0;$s<count($installList);$s++)
			{
						$arr=array(

		                  'inst_id' => $installList[$s]["inst_id"],
		                    'req_type' => $installList[$s]["instal_reinstall"],
		                    'req_id' => $installList[$s]["id"],
		                   'table_name' => 'installation_request'
								) ;
							array_push($data,$arr);	
			}
	  }
	  

	  $installList1=db__select_staging("select id,inst_id,service_reinstall from internalsoftware.services where popup_alertStock=1 and service_status=2 and service_reinstall!='crack'");
	  if(count($installList1)>0)
	  {
	 	   for($s=0;$s<count($installList1);$s++)
			{
						$arr=array(

		                  'inst_id' => $installList1[$s]["inst_id"],
		                    'req_type' => $installList1[$s]["service_reinstall"],
		                    'req_id' => $installList1[$s]["id"],
		                   'table_name' => 'services'
								) ;
							array_push($data,$arr);	
			}
		}
	$installList2=db__select_staging("select id,inst_id,service_reinstall from internalsoftware.services_crack where popup_alertStock=1 and service_status=2 ");
	  if(count($installList2)>0)
	  {
	 	   for($s=0;$s<count($installList2);$s++)
			{
						$arr=array(

		                  'inst_id' => $installList2[$s]["inst_id"],
		                    'req_type' => $installList2[$s]["service_reinstall"],
		                    'req_id' => $installList2[$s]["id"],
		                   'table_name' => 'services_crack'
								) ;
							array_push($data,$arr);	
			}
	  }

	//echo print_r($data);die;
	if(count($data)>0)
	{
			//echo 'tt';die;
			//echo $installList[$i]['inst_id']; die;
			for($i=0;$i<count($data);$i++)
			{
				if($data[$i]['inst_id']!=""  || $data[$i]['inst_id']!=0)
				{
					//echo $data[$i]['inst_id'];die;
				
					//echo "select inst_name,inst_id from internalsoftware.installer where is_active='1'and inst_id='".$data[$i]['inst_id']."' "; die;
					$installName=db__select_staging("select inst_name,inst_id from internalsoftware.installer where is_active='1'and inst_id='".$data[$i]['inst_id']."' ");

					// 	$noOfInstallation= $installerList[$i]['installation_approve'];
				 	$installerName= $installName[0]['inst_name'];
				 	$inst_id= $installName[0]['inst_id'];
				 	// echo $data[$i]['req_id'].'<br>';
				 	// echo $data[$i]['inst_id'].'<br>';
				 	// 	echo $data[$i]['table_name'];
				 	// 	die;	
					//echo '<pre>'; print_r($installerList); die;
					//echo "Please give ".$noOfInstallation." Devices to ".$installerName;
			 			echo $data[$i]['req_id'].'##'.$installerName.'##'.$inst_id.'##'; 
			 			exit;
				}
				else
				{
					//echo "1";
					//continue;
				}
			}
	}
	else
	{
		//echo "No Installer is remain here to assign the devices";
	}

	
}


?>