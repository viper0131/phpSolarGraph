<?php
include "fout.php";
include "Parameters.php";
include "sessionstart.php";
include "connect.php";

$sql = "Select From_Unixtime(Epoch+Timedrift) as timespan, Ac1_P,Ac2_P,Ac3_P, Ac1_P+Ac2_P+Ac3_P As Total
  From Pikolog
  Where From_Unixtime(Epoch+Timedrift) > '2012-09-04' And 
        From_Unixtime(Epoch+Timedrift) <= Adddate('2012-09-04',1)";
        
$result = mysql_query($sql) or die("Query failed. ".mysql_error());;

while($row = mysql_fetch_array($result)) {
  echo $row['timespan'] . "\t" . $row['Total']. "\n";
}
?> 