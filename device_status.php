<?php
///////////////Device Status///////////////////////
        $RawInventory=20;
        $recdConfigureDevice=19;
        $Configure=60;
		$Installed=55;
		$ReadytoShip=56;
        //OutOfStock is for dispatch
        $OutOfStock=57;
        $Tested=58;
        $TempraryAttachment=61;
        $FinalAttachSim=62;
        $BranchRecd = 63;
        $AssignToInstaller=64;
        $DeviceInstalled = 65;
        //Repairable Status
        $DeviceRemoved = 66;


        // create by rajat
        $SendToRepairCentre = 122;
        $RemoveDeviceForRDrecive = 79;
        // end rajat code

       // SendToRepairCentre = 79,


		//create by rajat

		$Sim_RepairForRD = 193;

		// end rajat code 
        $RemovedDeviceRecd = 67;
        $OpenCaseForRepairedDevice =68;
        $CloseCaseForRepairedDevice = 105;
        $DeadDevice=70;
        $ReplaceOnRepairDevice = 71;
        //New Status
        $BranchRepair = 75;
        $DeviceAgainstPymentWithFFC = 76;
        $DeviceAgainstPymentWithoutFFC = 77;
        $UnCrackedDevice = 80;
        $RecdRemoveDevice =81;
        $InternalBranchRepaired = 82;
        $SendToRepair_ByBranch=83;
        $Device_Manufacture=84;
        $Device_Manufacture_send = 85;
        $Device_Replaced_By_Manufactured =86;
        $Sim_Dispatch=87;
        $Sim_Recd=88;   
        $Sim_Reassign=89;
        $Sim_Servies=90;
        $Sim_Installed=91;
        $Sim_Deactivation=92;
        $Sim_Repair=93;
        $AssignDeadDevice=94;
        $DeadDeviceToClient=95;
        $ReAssignDeadDevice = 96;
        $RecdDeadDevice=97;
        $Replaced_FFC=98;
        $FFC_AS_New=99;
        $Replace_FFC=100;
        $Very_Old_SIM=102;
        $Client_Office=103;
        $FFCDevicePending=69;
        $DeviceDeleteAccount=104;
		$DeadDeviceRemarksPending=72;
        $Sim_is_Pending_for_Deactivation=106;
        $CloseCaseRepairDevice=105;
        $ArchievDeadList=108;
        $SendToRepairCentreManufacture1 = 109;
        $VendorDevice = 111;
        $MissingDeviceInInventory = 120;
        $RecdRepairDeviceStock = 116;
        $AttachSim_At_Stock_Recd=194;
        $New_Device_ByBranch=195;
		$recd_manufacture_devByStock=196;
		
		////////////////ChallanMode//////////////////
		$Dispatch = 1;
        $Installer = 2;
        $Sim = 3;
       /////////////////////Device Condition////////////////////////
	    $New = 0;
        $FFC = 1;
        $Cracked = 2;
		$Repaired = 3;
		/////////////////////Flag///////////////////////
		  $available=1;
		  $unavailable=2;
		/////////////////////ItemType/////////////////////////  
		$Device = 1;
        $Item = 2;
		
		/////////////////////ItemType/////////////////////////  
		$All = -1;
        $Used = 0;
        $UnUsed = 1;
		
		/////////////////////ItemType/////////////////////////  
		$All = -1;
        $Active = 0;
        $NotActive = 1;
?>