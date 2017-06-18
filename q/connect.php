<?php
$con = mysql_connect($sserver, $susername, $spassword); //connect met de database
if (!$con){
 	//die('Could not connect: ' . mysql_error());
 	echo ('error: '.mysql_error());
 	die("Connection error: $sserver, $susername, $spassword");
  }
//$condatabase = mysql_select_db($sdatabase_name, $con) or die ('Could not connect:'. mysql_error);
$condatabase = mysql_select_db($sdatabase_name, $con) or die ('Error opening database schema');

//$file = fopen ('prefix.dat', "r")or die (header('location:opstart_installatie.php?fout=table')); 
//$prefixpar=fgets($file, 1024); 
//$prefixpar=trim($prefixpar);
?>
