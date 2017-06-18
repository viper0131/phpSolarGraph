<?php 
include "Parameters.php";
include "connect.php";

// Select info by day, put it in array
$date = $_GET['date'];
if (empty($_GET)) { 
	$date=date("Y-m-d");
}

$valuelist="";
$categories="";
$sql=
"SELECT epoch+timedrift, AC1_P,AC2_P,AC3_P, AC1_P+AC2_P+AC3_P AS TOTAL
  FROM pikoLog
  WHERE from_unixtime(epoch+timedrift) > '$date' AND 
        from_unixtime(epoch+timedrift) <= adddate('$date',1);";
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
		<div id="dayGraph" style="width: 100%; height: 600px"></div>Kies een andere maand:
	</body>
</html>