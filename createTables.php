<?php
include "fout.php";
include "Parameters.php";
include "sessionstart.php";
include "connect.php";

$sql="DROP TABLE pikoLog";
mysql_query($sql) or die("Query failed. Drop table pikoLog ".mysql_error());
echo "TABLE pikoLog -> dropped<BR>";

$sql="CREATE TABLE `pikoLog` (
  `epoch` int(11) NOT NULL,
  `Zeit` int(11),
  `DC1_U` int(11),
  `DC1_I` int(11),
  `DC1_P` int(11),
  `DC1_T` int(11),
  `DC1_S` int(11),
  `DC2_U` int(11),
  `DC2_I` int(11),
  `DC2_P` int(11),
  `DC2_T` int(11),
  `DC2_S` int(11),
  `DC3_U` int(11),
  `DC3_I` int(11),
  `DC3_P` int(11),
  `DC3_T` int(11),
  `DC3_S` int(11),
  `AC1_U` int(11),
  `AC1_I` int(11),
  `AC1_P` int(11),
  `AC1_T` int(11),
  `AC2_U` int(11),
  `AC2_I` int(11),
  `AC2_P` int(11),
  `AC2_T` int(11),
  `AC3_U` int(11),
  `AC3_I` int(11),
  `AC3_P` int(11),
  `AC3_T` int(11),
  `AC_F` float,
  `FC_I` int(11),
  `Ain1` int(11),
  `Ain2` int(11),
  `Ain3` int(11),
  `Ain4` int(11),
  `AC_S` int(11),
  `Err` int(11),
  `ENS_S` int(11),
  `ENS_Err` int(11),
  `KB_S` varchar(200),
  `total_E` int(11),
  `Iso_R` int(11),
  `Ereignis` varchar(200),
  `Inserted` datetime,
  UNIQUE KEY `epoch` (`epoch`),
  KEY `zeit_idx` (`Zeit`)
);";
mysql_query($sql) or die("Query failed. create table pikoLog ".mysql_error());
echo "TABLE pikoLog -> created<BR>";

?>