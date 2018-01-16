//var Path="http://trackingexperts.com/format/";
var Path="http://localhost/inventory_old/";

function Show_record(RowId,tablename,DivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=getrowSales",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		 data:"RowId="+RowId+"&tablename="+tablename,
		success:function(msg){
		document.getElementById("popup1").innerHTML = msg;
						
		}
	});
}


 function Show_reset_pwd(reset_pwd,DivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"popup.php?action=getreset_pwd",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		 data:"reset_pwd="+reset_pwd,
		success:function(msg){
			
		  
		document.getElementById("popup1").innerHTML = msg;
						
		}
	});
}


function toggle_visibility(id) {
	if(id=='TxtSeparate')
		{
		var e = document.getElementById('TxtMainUser');
		 e.style.display = 'none';
		}
		else
		{
       var e = document.getElementById(id);
       
          e.style.display = 'block';
		  
		  }
		
    }		

function showUser(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=showUser",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		success:function(msg){
			
		
		document.getElementById(setDivId).innerHTML = msg;
						
		}
	});
}

function getClientPrice(user_id,paymentmode,device,rent,payment,AccPrice,AccRent,accountId)
{
	$.ajax({
		  type:"GET",
		  url:"userInfo.php?action=pricing",
		  data:"user_id="+user_id,
		  beforeSend: function(msg){
			  $("#showrslt").hide();
		  },
		  success:function(msg){
		   //alert(msg);
		   $("#showrslt").show();
		   document.getElementById('price_check').style.display = "block";
		   
		   document.getElementById('price_diff_chkbox').checked = false;
		   document.getElementById('type_of_account').style.display = "none";
		 
		   
		   var spl = msg.split('##');
		    
		 
		   if(spl[0] == 'Cheque')
		   {
			   document.getElementById(paymentmode).innerHTML = spl[0] + ' - Payment Mode';
			   document.getElementById(device).innerHTML = spl[1] + ' - Device Price Without Tax';
			   document.getElementById(rent).innerHTML = spl[2] + ' - Rent Price Without Tax';
			   document.getElementById(payment).value = spl[0];
			   document.getElementById(AccPrice).value = spl[1];
			   document.getElementById(AccRent).value = spl[2];   
			   document.getElementById(accountId).value = spl[3]; 
			   if(spl[1]==0 || spl[1]=='' || spl[1]==null || spl[2]==0 || spl[2]=='' || spl[2]==null)
			   {
				   document.getElementById('type_of_account').style.display = "block";
				   document.getElementById('price_diff_chkbox').checked = true;
			   }
		   }
		   else if(spl[0] == 'Cash')
		   {
			   document.getElementById(paymentmode).innerHTML = spl[0] + ' - Payment Mode';
			   document.getElementById(device).innerHTML = spl[1] + ' - Cash Device Price';
			   document.getElementById(rent).innerHTML = spl[2] + ' - Cash Rent Price';
			   document.getElementById(payment).value = spl[0];
			   document.getElementById(AccPrice).value = spl[1];
			   document.getElementById(AccRent).value = spl[2]; 
			   document.getElementById(accountId).value = spl[3];
			   if(spl[1]==0 || spl[1]=='' || spl[1]==null || spl[2]==0 || spl[2]=='' || spl[2]==null)
			   {
				   document.getElementById('type_of_account').style.display = "block";
				   document.getElementById('price_diff_chkbox').checked = true;
			   }
			   
			   
		   }
		   else if(spl[0] == 'Lease')
		   {
			   document.getElementById(paymentmode).innerHTML = spl[0] + ' - Payment Mode';
			   document.getElementById(device).innerHTML = spl[1] + ' - Lease Amount';
			   document.getElementById(payment).value = spl[0];
			   document.getElementById(AccPrice).value = spl[1];
			   document.getElementById(AccRent).value = spl[2];
			   document.getElementById(accountId).value = spl[3]; 
			   if(spl[1]==0 || spl[1]=='' || spl[1]==null || spl[2]==0 || spl[2]=='' || spl[2]==null)
			   {
				   document.getElementById('type_of_account').style.display = "block";
				   document.getElementById('price_diff_chkbox').checked = true;
			   }
			 
		   }
		   else if(spl[0] == 'Demo')
		   {
			   document.getElementById(paymentmode).innerHTML = spl[0] + ' - Payment Mode';
			   document.getElementById(device).innerHTML = spl[1] + ' - Demo Days';
			   document.getElementById(payment).value = spl[0];
			   document.getElementById(AccPrice).value = spl[1];
			   document.getElementById(AccRent).value = spl[2]; 
			   document.getElementById(accountId).value = spl[3]; 
			   if(spl[1]==0 || spl[1]=='' || spl[1]==null || spl[2]==0 || spl[2]=='' || spl[2]==null)
			   {
				   document.getElementById('type_of_account').style.display = "block";
				   document.getElementById('price_diff_chkbox').checked = true;
			   }
			 
		   }
		   else if(spl[0] == 'Crack')
		   {
			   document.getElementById(paymentmode).innerHTML = spl[0] + ' - Payment Mode';
			   document.getElementById(device).innerHTML = spl[1] + ' - Crack Device Price';
			   document.getElementById(rent).innerHTML = spl[2] + ' - Rent Price Without Tax';
			   document.getElementById(ModePay).value = spl[0];
			   document.getElementById(AccPrice).value = spl[1];
			   document.getElementById(AccRent).value = spl[2]; 
			   document.getElementById(accountId).value = spl[3]; 
			   if(spl[1]==0 || spl[1]=='' || spl[1]==null || spl[2]==0 || spl[2]=='' || spl[2]==null)
			   {
				   document.getElementById('type_of_account').style.display = "block";
				   document.getElementById('price_diff_chkbox').checked = true;
			   }
			  
		   }
		   else if(spl[0] == 'FOC' || spl[0] == 'Trip Based')
		   {
			   document.getElementById(paymentmode).innerHTML = spl[0] + ' - Payment Mode';
			   document.getElementById(device).innerHTML = spl[1] + ' - Device Price Without Tax';
			   document.getElementById(rent).innerHTML = spl[2] + ' - Rent Price Without Tax';
			   document.getElementById(ModePay).value = spl[0];
			   document.getElementById(AccPrice).value = spl[1];
			   document.getElementById(AccRent).value = spl[2];
			   document.getElementById(accountId).value = spl[3]; 
			   if(spl[1]==0 || spl[1]=='' || spl[1]==null || spl[2]==0 || spl[2]=='' || spl[2]==null)
			   {
				   document.getElementById('type_of_account').style.display = "block";
				   document.getElementById('price_diff_chkbox').checked = true;
			   }
			 
		   }
		   else
		   {
			
			   document.getElementById('type_of_account').style.display = "block";
			   document.getElementById('price_diff_chkbox').checked = true;
			   document.getElementById(paymentmode).innerHTML = '' + ' - Payment Mode';
			   document.getElementById(device).innerHTML = 0 + ' - Device Price Without Tax';
			   document.getElementById(rent).innerHTML = 0 + ' - Rent Price Without Tax';
			   document.getElementById(ModePay).value = 0;
			   document.getElementById(AccPrice).value = 0;
			   document.getElementById(AccRent).value = 0; 
			  // document.getElementById(accountId).value =0; 
			   
			   
			 
		   }   
	  }
	 });
}

function showUserddl(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=getdataddl",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		success:function(msg){
			
		
		document.getElementById(setDivId).innerHTML = msg;
						
		}
	});
}


function DetailVehicle(value,user_Id)
{
	var rootdomain="http://"+window.location.hostname
	var loadstatustext="<img src='"+rootdomain+"/images/icons/other/waiting.gif' />"
	document.getElementById("DetailVehicle").innerHTML=loadstatustext; 

$.ajax({
		type:"GET",
		url:Path +"userInfo.php?action=DetailVehicle",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		 data:"RowId="+value+"&user_Id="+user_Id,
		success:function(msg){
			 
		document.getElementById("DetailVehicle").innerHTML = msg;
						
		}
	});
}

function showDeleteImei(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=ReInstalltion",
		data:"user_id="+user_id,
		success:function(msg){
			
		document.getElementById(setDivId).innerHTML = msg;
						
		}
	});
}


 function showUserreplace(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=getdatareplce",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		success:function(msg){
			
		
		document.getElementById(setDivId).innerHTML = msg;
						
		}
	});
}


function gettotal_veh_byuser(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=total",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		success:function(msg){
			
		
		document.getElementById(setDivId).value = msg;
						
		}
	});
}


function getCompanyName(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=companyname",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		 beforeSend: function(msg){
		  	$("#button1").prop('disabled', true);
		  },
		success:function(msg){
			
		 $("#button1").prop('disabled', false);
		 document.getElementById(setDivId).value = msg;
						
		}
	});
}


function getInstallermobile(inst_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=installermobile",
 
		data:"inst_id="+inst_id,
		success:function(msg){
			
		 
		document.getElementById(setDivId).value = msg;
						
		}
	});
}

function getTransferCompanyName(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=companyname",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		success:function(msg){
			
		 
		document.getElementById(setDivId).value = msg;
						
		}
	});
}


function getCreationDate(user_id,setDivId)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=creationdate",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"user_id="+user_id,
		success:function(msg){
			
		 
		document.getElementById(setDivId).value = msg;
						
		}
	});
}


function getdeviceImei(veh_reg,divDeviceIMEI)
{
 
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=deviceImei",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"veh_reg="+veh_reg,
		success:function(msg)
		{
		  
		 
		document.getElementById(divDeviceIMEI).value = msg;
						
		}
	});
}

function getdevicemobile(veh_reg,divDeviceMobile)
{
  
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=deviceMobile",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"veh_reg="+veh_reg,
		success:function(msg)
		{
		 
		 
		document.getElementById(divDeviceMobile).value = msg;
						
		}
	});
}


function getInstaltiondate(veh_reg,Divdate_of_install)
{
	//alert(user_id);
	//return false;
$.ajax({
		type:"GET",
		url:"userInfo.php?action=Instaltiondate",
		//data:"category="+category+"&expairy="+expairy1+"&duration="+durationlist+"&sortby="+sortby+"&price="+price+"&search="+search1,
		data:"veh_reg="+veh_reg,
		success:function(msg){
			
		 
		document.getElementById(Divdate_of_install).value = msg;
						
		}
	});
}

 



 