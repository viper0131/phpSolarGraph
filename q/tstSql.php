<?php
include "fout.php";
include "Parameters.php";
include "sessionstart.php";
include "connect.php";

$sql="select * from settings";
mysql_query($sql) or die("Query failed. ".mysql_error());
echo "select done<BR>";


?>