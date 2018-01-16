BEGIN 
DECLARE simID varchar(50);
DECLARE deviceIDs varchar(50);
DECLARE lastID varchar(50);
DECLARE strChallanNo varchar(50);
DECLARE device_id123 varchar(50);
DECLARE lastIDchallan varchar(50);
DECLARE test varchar(50);

DECLARE exit handler for sqlexception
  BEGIN
  ROLLBACK;
END;
DECLARE exit handler for sqlwarning
 BEGIN
    
 ROLLBACK;
END;
START TRANSACTION; 
                           
set Temp=temp+1;   
set simID=(SELECT sim_id FROM sim WHERE sim_no=sim_no123 limit 1);   
INSERT INTO device(device_sno,itgc_id,device_imei,sim_id,device_status,assign_installer_date,Branch_Send,recd_date,device_type,active_status,is_cracked,client_name,dispatch_branch)                 
values(DeviceSno,itgc_id,DeviceImei,simID,64,now(),1,RecDate,modelType,1,IsCracked,ClientName,1);
UPDATE application_setting SET Id=Temp WHERE ParentID=deviceType;
select deviceType;
set lastIDchallan=(SELECT Id FROM application_setting WHERE Name='InstallerChallanNo' limit 1);
set lastIDchallan=lastIDchallan+1;
set strChallanNo=concat('CHNO',lastIDchallan);
select strChallanNo;
set deviceIDs=(SELECT device_id FROM device where device_imei=DeviceImei order by recd_date desc limit 1); 
if exists(select * from devicehistorydate where device_id=deviceIDs) THEN     
   update devicehistorydate set AssignDeviceDateInstaller=NOW() where device_id=deviceIDs; 
else          
   insert devicehistorydate(device_id,device_sno,AssignDeviceDateInstaller) values(deviceIDs,DeviceSno,NOW());      
END IF;
INSERT into device_repair (device_id,device_imei,current_record,device_status) values(deviceIDs,DeviceImei,1,64);
UPDATE challandetail SET CurrentRecord=0 WHERE DeviceID=deviceIDs;
INSERT INTO challandetail(DispatchChallanNo,InstallerChallanNo,DeviceID,ChallanStatus,CurrentRecord,InstallerID,BranchID,AssignedDate) VALUES(strChallanNo,strChallanNo,deviceIDs,1,1,installer_id,1,RecDate); 
UPDATE application_setting SET Id=lastIDchallan WHERE Name='InstallerChallanNo';
select deviceIDs;

COMMIT; 
END