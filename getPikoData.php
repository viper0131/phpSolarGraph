<?php header('Refresh: 30'); ?>
<?php
include "Parameters.php";
//include "../sessionstart.php";
//include "../fout.php";
//include "Keuze.php";
include "connect.php";
include "header.php";

$outstring = "";
$urlToDisplay="http://pvserver:******@".$PIKO_ADDRESS."/LogDaten.dat";
?>
<div id="container" >
<?php 
echo'
	<div id="bodytext">
		<div class="top-left"></div><div class="top-right"></div>
		<div class="inside">
			<h1 class="notopgap" align="center">Get Data</h1>
			<div id="tabelgegevens">
				        Omvormer<br>
					Host<br>
					User<br>
					Password<br>
					Database<br>
					DB user<br>
					DB password<br>
					Invertor URL
			</div>
			<div id="gegevens1">
				     <p>: '.$omvormer.'<br>
					: '.$PIKO_ADDRESS.'<br>
					: pvserver<br>
					: ******<br>
					: '.$sdatabase_name.'<br>
					: '.$susername.'<br>
					: ******<br>
					: '.$urlToDisplay.'</p>
			</div>
			<p class="nobottomgap"></p>
		</div>
		<div class="bottom-left"></div><div class="bottom-right"></div>			
	</div>
	';
?>
</div>

<div id="container">
	<div id="bodytext">
		<div class="top-left"></div><div class="top-right"></div>
		<div class="inside">
		<div id="showcode">

<?php

//override default connection timeout
set_time_limit(360);

// 
// Check when we last checked our convertor (in epoch)
//
$sql="SELECT 
  valueAsInt 
FROM 
  settings
WHERE
  sleutel='LastChecked'";
$result = mysql_query($sql) or die("Query failed. last check ".mysql_error());
if (mysql_num_rows($result)==0){
	$LastCheckedOn=0;
}
else {
	while($row = mysql_fetch_array($result)){
		$LastCheckedOn="$row[0]";
	}
}

$currenttimestamp = time();

//
// als laatste check >15minuten geleden en het is tussen 6.00am en 22.30pm start next check....
// 
$checkInvertor = false;

// Check if we are more than interval time further
$checkInvertor = ($currenttimestamp >= $LastCheckedOn + ($checkInterval * 60));

// If we checked the lasttime after 22:30 and it's not 6:00 yet, skip also.
if (date("Gi",$LastCheckedOn)>"2230" && date("Gi")<"600") {
  $checkInvertor = false;
}

if ( $checkInvertor ) { 


	$max_zeit=0;
	$sql="SELECT max( Zeit ) FROM pikoLog";
	$result = mysql_query($sql) or die("Query failed. max Zeit ".mysql_error());
	if (mysql_num_rows($result)!=0){
		while($row = mysql_fetch_array($result)){
			$max_zeit= $row[0];
		}
	}

	$url="http://pvserver:".$PIKO_PASSWD."@".$PIKO_ADDRESS."/LogDaten.dat";
	$handle=fopen($url, "r");
	$teller=1;
	
	// skip to 4th line
	while (!feof($handle)&&($teller<5))
	{
		$line=str_replace("\t", ":", fgets($handle));
		//$geg=fgets($handle);
		echo "line\t".$teller.": ".$line."<br>";
		$teller++;
	}

	if (strlen($line)==0) {
		echo "PIKO website not online<BR>";
		$curr_zeit=0;
		$diff=0;
		$outstring="PIKO website not online<BR>";
	}
	else {
	        // Find current zeit
		$arr = explode(":", $line);
		$cur_zeit=(int)$arr[2];
		$cur_zeit_epoch = $cur_zeit+$pikoStarted;
		
		echo 'Datalog timestamp: '.$cur_zeit_epoch.': - '.date(DATE_RFC822, $cur_zeit_epoch).'<br>';
		$now_epoch=time();
		echo 'Now: '.$now_epoch.': - '.date(DATE_RFC822, $now_epoch).'<br>';
		$diff=$cur_zeit_epoch - $now_epoch;
		echo 'Timedrift:'.$diff.'<br><br><br>';
		
		$timedrift=$max_zeit-$cur_zeit;
		$diff = $cur_zeit-$max_zeit;
		$outstring .= " - Time diff.: $diff s (Piko: $cur_zeit, Dbase: $max_zeit)<br>";
		
		//
		// if timedrift more than 1 minute store it.
		if ($timedrift > 60) { 
			$sql="update settings set valueAsInt = ValueAsInt + '.$timedrift.' where sleutel='timedrift'";
			$result = mysql_query($sql) or die("Query failed to update settings.timedrift: ".mysql_error());
		
		}
	
	}
	
	// Load data if diff is more then interval time
	if ($diff <= ($checkInterval*60)){
		// don't load
		fclose($handle);
		$outstring .= "No new log item's available<br>";
	} else {

		//
		// Retrieve current timedrift
		//
		$sql="select ValueAsInt from settings where sleutel='timedrift'";
		$result = mysql_query($sql) or die("Query failed to update settings.timedrift: ".mysql_error());
		if (mysql_num_rows($result)!=0){
			while($row = mysql_fetch_array($result)){
				$drift = $row[0];
			}
		}

		// load data
		$outstring .= "start reading data<br>";
		// read away empty line and headers
		$line=fgets($handle);
		$line=fgets($handle);
		$line=fgets($handle);
		$outstring .= "start reading data<br>";
		
		$nrOfInsertedRecords=0;
		$nrOfReadRecords=0;
		while (!feof($handle)) { 
			$tmp=fgets($handle);
			$line=str_replace("\t", ";", $tmp);
			$nrOfReadRecords++;
			//echo $line."<br>";
			$arr = explode(";", $line);
        	        $nrOfFields=count($arr);
			$piko_zeit=(int)$arr[0];
			$unix_time=$piko_zeit + $pikoStarted+$drift;
			//echo $unix_time."<br><br>";
			
			
			//insert if new records or last column contains data
			//$outstring .= " - T".$teller2.": ".$zeit.">".$max_zeit."<br>";
			if (($piko_zeit>0)&&($piko_zeit>$max_zeit)&&($arr[1]<>"")) {
				$sql = "INSERT INTO pikoLog VALUES(".$unix_time.", '".trim($arr[0])."', ";
				$i=1;
				while ($i<$nrOfFields)
				{
					$sql .= "'".trim((string)$arr[$i])."', ";
					$i++;
				}
				while ($i<42)
				{
					$sql .= "'', ";
					$i++;
				}
				$sql .= "NOW(),$timedrift);";


				//$diff=$cur_zeit-$zeit;
				//$diff2=$zeit-$prev_zeit;
				//if ($diff2>$PIKO_interval) {$diff2=$PIKO_interval;}
				//$prev_zeit=$zeit;

	
				mysql_query($sql) or die ('***SQL Error string: $sql->'. mysql_error());
				echo $sql."<br><br>";
				$nrOfInsertedRecords++;
			} 
		}
		fclose ($handle);
		$outstring .= " - inserted ".$nrOfInsertedRecords."/".$nrOfReadRecords." row(s)";
		
	}
	
	fclose ($handle);

	// update last check date
	$sql="UPDATE settings set valueAsInt=UNIX_TIMESTAMP(now()) where sleutel='LastChecked'";
        $result = mysql_query($sql) or die("Query failed. last check ".mysql_error());
	$outstring .= " - lastchecked updated";

}
else 
{
	// do nothing, come back later....
	echo "Skip check on invertor, next check in: ".($LastCheckedOn + ($checkInterval * 60) - $currenttimestamp)." seconds...";
}

//
// If records are inserted, update the default zonPHP tables.
//
/*
if ($teller>0)
		{
			$sql="Delete from ".$prefix."_dag where datum_dag>=date(NOW());";
			mysql_query($sql) or die ('SQL Error string:'. mysql_error());

			$sql="Delete from ".$prefix."_maand where datum_maand>=date(NOW());";
			mysql_query($sql) or die ('SQL Error string:'. mysql_error());
	
			
			$sql="insert into ".$prefix."_dag SELECT zeit, addtime(tijdstip, '00:01'), $PIKO_coef*(ac1_p+ac2_p+ac3_p), $PIKO_coef*duration/3600*(ac1_p+ac2_p+ac3_p), 'Piko' FROM `zon_piko` WHERE DC1_P>0 and tijdstip>=date(DATE_ADD(NOW(), INTERVAL 6 HOUR))";
			mysql_query($sql) or die ('SQL Error string: $sql->'. mysql_error());
		
			$sql="insert into ".$prefix."_maand SELECT date(datum_dag), date(datum_dag), sum(kwh_dag)/1000, naam FROM ".$prefix."_dag where datum_dag>=date(DATE_ADD(NOW(), INTERVAL 6 HOUR)) group by date(datum_dag), naam;";
			mysql_query($sql) or die ('SQL Error string: $sql->'. mysql_error());
			
			$outstring .= " - Updated website data (incl. aggregates).";
		}
	}

*/
?>

		</div>
			<p class="nobottomgap"></p>
		</div>
		<div class="bottom-left"></div><div class="bottom-right"></div>			
	</div>
</div>
<?php
include "../footer.php";
?>