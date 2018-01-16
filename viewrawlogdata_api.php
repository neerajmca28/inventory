<?php

include('config.php');

include('include/header.php');

include_once(__DOCUMENT_ROOT.'/private/master.php');

if(!isset($_SESSION['branch_id']))

{

 ?><script><?php echo("location.href = '".__SITE_URL."/index.php';");?></script><?php

} 

$masterObj = new master();

print_r($_GET);

$error=$_GET['error'];

$dev_type=$_GET['device_type'];

$date=$_GET['date'];

$dev_imei=$_GET['dev_imei'];

$ext=$_GET['ext'];

//echo $dev_type; die;

echo $path1 = "C:\\ProcessingTest\\".$dev_type."\\".$date."\\".$dev_imei.".".$ext; 

echo $path2 = "G:\\ProcessingTest\\".$dev_type."\\".$date."\\".$dev_imei.".".$ext; 

//$path1 = "C://ProcessingTest//".$dev_type."//".$date."//".$dev_imei.".".$ext;

//$path2 = "G://ProcessingTest//".$dev_type."//".$date."//".$dev_imei.".".$ext; 

if (file_exists($path1)) 

{

	 $fp=fopen($path1,'r');

	 $filedata=fread($fp,filesize($path1));

	 $time=@filemtime($path1); 

}

else if(file_exists($path2))

{

	 $fp=fopen($path2,'r');

	 $filedata=fread($fp,filesize($path2));

	 $time=@filemtime($path2);

}

 


?>

<body onload="hideDevice()">

<article>

  <div class="col-12"> 

    <!-- BEGIN BORDERED TABLE PORTLET-->

    <div class="portlet box yellow">

      <div class="portlet-title">

        <div class="caption"> <i class="fa fa"></i> View Raw Log Data </div>

      </div>

      <div class="portlet-body">

        <table class="table table-bordered table-hover">

          <form method="post" action="" name="" enctype="multipart/form-data">

          <tbody>

            <tr>

              <td>

                Device Type

              </td>

              <td>

                <select name="devtype" id="myDevice" onchange="myDeviceid()" class="form-control"/>

                  <option role="presentation" value="0">Select</option>

                  <?php for($i=0;$i<count($data);$i++): ?>

                  <option role="presentation" value="<?php echo $data[$i]['item_name']; ?>"><?php echo $data[$i]['item_name']; ?></option>

                  <?php endfor; ?>

                </select>

                <td><span id="dataid1"><input type="radio" id="format" name="data" style="margin-left:20px;" value="1" />&#160;&#160;Format data</span></td>

                <td><span id="dataid2"><input type="radio" id="dataRaw" name="data" style="margin-left:10px;" value="2" />&#160;&#160;Raw data</span></td>

              </td>

            </tr>

            <tr>

              <td>

                Device Imei

              </td>

              <td colspan="3">

                <input type="text" name="deviceimei" class="form-control">

              </td>

            </tr>

            <tr>

              <td>

                Date

              </td>

               <td colspan="3">

                <input type="date" name="datepick"  class="form-control form_date" />

              </td>

            </tr>

            <tr>

              <td colspan="5"><input type="submit" name="submit" value="Submit"></td>

            </tr>

            <tr>

              <td>

                Raw Log

              </td>

               <td colspan="3">

                <textarea rows="10" cols="100" name="rawlog" class="form-control" value="">

                <?php $filedata; ?>

                </textarea> 

              </td>

            </tr>

            <tr>

              <td>               

                Insert Error Raw Log

              </td>

               <td colspan="3">

                <textarea rows="10" cols="100" name="errorrawlog" class="form-control">

				    <?php $filedata; ?>

				</textarea> 

              </td>

            </tr>

          </tbody>

          </form> 

        </table>

      </div>

    </div>

    <!-- END BORDERED TABLE PORTLET--> 

  </div>

</article>



</body>



</html>