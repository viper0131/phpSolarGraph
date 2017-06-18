<?php header("Content-type: text/json");

include "Parameters.php";

$USE_YOULESS=true;
$USE_INVERTOR=true;
$MOCK=false;

session_start(); 

$invertor_state="Unknown";

//
// Parse the Powerstocc information page
//
if ($USE_INVERTOR) {

	$url="http://pvserver:".$PIKO_PASSWD."@".$PIKO_ADDRESS;
	$handle=fopen($url, "r");
	$teller=1;
		
	$actual_yield= 0;
	$total_yield=0;
	$total_yield_today=0;
	
	while (!feof($handle))
	{
		$line=fgets($handle);
		
		if ($teller ==  46) {$actual_yield       = strip_tags($line);}	
		if ($teller ==  51) {$total_yield        = strip_tags($line);}	
		if ($teller ==  65) {$total_yield_today  = strip_tags($line);}	
		if ($teller ==  74) {$invertor_state     = strip_tags($line);}	
		
		if ($teller == 109) {$dc1_c              = strip_tags($line);}	
		if ($teller == 114) {$ac1_c              = strip_tags($line);}	
		if ($teller == 123) {$dc1_i              = strip_tags($line);}	
		if ($teller == 128) {$ac1_p              = strip_tags($line);}	
	
		if ($teller == 148) {$dc2_c              = strip_tags($line);}	
		if ($teller == 153) {$ac2_c              = strip_tags($line);}	
		if ($teller == 162) {$dc2_i              = strip_tags($line);}	
		if ($teller == 167) {$ac2_p              = strip_tags($line);}	
	
		if ($teller == 187) {$dc3_c              = strip_tags($line);}	
		if ($teller == 193) {$ac3_c              = strip_tags($line);}	
		if ($teller == 202) {$dc3_i              = strip_tags($line);}	
		if ($teller == 208) {$ac3_p              = strip_tags($line);}		
		
		if ($teller >= 208) {
		  break;
		}
		$teller++;
	}
	fclose($handle);
}

//
// Parse the Youless information page
//
$yl_actual_yield = 0;
if ($USE_YOULESS) {
	$outputyouless = file_get_contents('http://82.95.120.155:8888/a?f=j'); 
	$json = json_decode($outputyouless); 
	$yl_actual_yield = $json->{'pwr'};  
}

// The x value is the current JavaScript time, which is the Unix time multiplied by 1000.
$x = time() * 1000;
$y1 = (int)$actual_yield;
$y2 = (int)$yl_actual_yield;
$y3 = (int)($total_yield_today*1000);
$y4 = (float)$dc1_i;
$y5 = (float)$dc2_i;
$y6 = (float)$dc3_i;
$y7 = (int)$ac1_p;
$y8 = (int)$ac2_p;
$y9 = (int)$ac3_p;

if (strpos($invertor_state,'MPP')) {
  $invertor_state = "Feeding";
} else if (strpos($invertor_state, 'stationair')) {
  $invertor_state = "Standby";
} else if (strpos($invertor_state, 'uit')) {
  $invertor_state = "Off";
}

$real_usage = 0;
$direction = 1;

if ($USE_YOULESS && $USE_INVERTOR) {
	//
	// Create new value for power usage
	// TODO: try to guess direction.....
	//
  if ($actual_yield < $yl_actual_yield) {
    $real_usage = $yl_actual_yield + $actual_yield;
    $direction = -1;
  } else {
    $real_usage = $actual_yield - $yl_actual_yield;
    $direction = 1;
  }
}
  
// Create a PHP array and echo it as JSON
$ret1 = array($x, $y1);
$ret2 = array($x, $y2);
$ret3 = array($x, $y3);
$ret4 = array($x, $y4);
$ret5 = array($x, $y5);
$ret6 = array($x, $y6);
$ret7 = array($x, $real_usage);
$ret8 = array($x, $y7);
$ret9 = array($x, $y8);
$ret10 = array($x, $y9);

$ret  = array($ret1, $ret2, $ret3, $ret4, $ret5, $ret6, $invertor_state, $total_yield, $real_usage, $direction, $ret7, $ret8, $ret9, $ret10);

echo json_encode($ret);


?>

