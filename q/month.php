<?php 
include "Parameters.php";
include "connect.php";

// Select info by month, put it in array
// show the entire month the day is in.


$date = $_GET['date'];
if (empty($_GET)) { 
	$date=date("Y-m-d");
}

$timestamp = strtotime($date);
$startDate = date('Y-m-d', mktime(0,0,0,date("m",$timestamp), 1, date("Y",$timestamp)) );
$endDate   = date('Y-m-t', $timestamp);


$valuelist="";
$categories="";
$sql=

"SELECT epoch+timedrift, AC1_P,AC2_P,AC3_P, AC1_P+AC2_P+AC3_P AS TOTAL
  FROM pikoLog
  WHERE from_unixtime(epoch+timedrift) > '$startDate' AND 
        from_unixtime(epoch+timedrift) <= adddate('$endDate',1);";

$result = mysql_query($sql) or die("Query failed.".mysql_error());
	$counter = 0;

if (mysql_num_rows($result)!=0) 
{
	while($row = mysql_fetch_array($result)){
		$valuelist .= "[".($row[0]*1000).",".$row[4]."],";
		//$categories .= "'$row[0]',";
		$counter++;
	}
	$valuelist = substr_replace($valuelist ,"",-1);
	//$categories = substr_replace($categories ,"",-1);
}

error_log( $sql );
error_log( $valuelist );
error_log( $counter );

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo $date;?></title>
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->

<script type="text/javascript">


		$(document).ready(function() {
			Highcharts.setOptions({
				global : {
					useUTC : false
				}
			});
      			var chart = new Highcharts.Chart({
			   chart: {
			      renderTo: 'dayGraph',
			      defaultSeriesType: 'column',
			      margin: [ 50, 50, 100, 80],
                              defaultSeriesType: 'area',
                              zoomType: 'x'

			   },
			   title: {
			      text: 'Daily powergraph'
			   },
			   subtitle: {
			      text: <?php echo "'$date'";?>
			   },
			   xAxis: {
			         type: 'datetime',
			         //maxZoom: 7 * 24 * 3600000, // 7 days
			         title: { text: null },
				 dateTimeLabelFormats: {
						second: '%H:%M:%S',
						minute: '%H:%M',
						hour: '%H:%M',
						day: '%e. %b',
						week: '%e. %b',
						month: '%b \'%y',
						year: '%Y'
				 },
			         labels: {
			            rotation: -45,
				    align: 'right',
				    style: {
				        font: 'normal 12px Verdana, sans-serif'
				    }
			      }
			   },
			   yAxis: {
			      min: 0,
			      title: {
			         text: 'Yield (Wh)'
			      }
			   },
			   legend: {
			      enabled: false
			   },
			   tooltip: {
				   xDateFormat: '%Y-%m-%d  %H:%M'
			   },
			        series: [{
			      name: 'Yield',
			      color: '#FFDB93', // Haystack
			      marker: { radius: 2 },
			      data: [ <?php echo $valuelist; ?> ],
			      dataLabels: {
			         enabled: false,
			         rotation: -90,
			         color: '#FFFFFF',
			         align: 'right',
			         x: 15,
			         y: 10,
			         formatter: function() {
			            return this.y;
			         },
			         style: {
			            font: 'normal 8px Verdana, sans-serif'
			         }
			      }         
			   }]
			});
		});
		</script>
	</head>
	<body>
		<!-- 3. Add the container -->
		<div id="dayGraph" style="width: 100%; height: 600px"></div>Kies een andere maand:
<!--		<form name="input" action="http://solargraph.vanampting.com/day.php" method="get">
		 <select name="maand" id="maand">
		      <option value="1" >Januari</option>
		      <option value="2" >Februari</option>
		      <option value="3" >Maart</option>
		      <option value="4" >April</option>
		      <option value="5" >Mei</option>
		      <option value="6" >Juni</option>
		      <option value="7" >Juli</option>
		      <option value="8" >Augustus</option>
		      <option value="9" >September</option>
		      <option value="10" >Oktober</option>
		      <option value="11" >November</option>
		      <option value="12" >December</option>
		      </select>
		 <select name="jaar" id="jaar">
		      <option value="2012" >2010</option>
		</select>
		<input type="submit" value="update graph">
		</form> -->
		
<?php 
$i=1;
while ($i<=31) {
   $framedate=date('Y-m-d', mktime(0,0,0,date("m",$timestamp), $i++, date("Y",$timestamp)) );
   echo '<iframe src="http://solargraph.vanampting.com/day.php?date='.$framedate.'" FRAMEBORDER=0 height=600 width=100%></iframe><br>';
}
?>
	</body>
</html>