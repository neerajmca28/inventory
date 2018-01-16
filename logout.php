<?php
error_reporting(0);
ob_start();
session_start();
session_destroy();
 header("location:index.php");
?>