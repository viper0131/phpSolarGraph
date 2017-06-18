<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Powerplant De Hoek, Live</title>
		
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="../Highcharts/js/highcharts.src.js"></script>
		<script src="../Highcharts/js/highcharts.js"></script>
		<script src="../Highcharts/js/highcharts-more.js"></script>
		<script src="../Highcharts/js/modules/exporting.js"></script>

		
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		<script type="text/javascript">
		var chart; // global
		var chartGauches;

		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		function requestData() {
			$.ajax({
				url: 'getLiveData.php', 
				success: function(points) {
					//document.write(points);
					var seriesPV = chart.series[0],
					    seriesYL = chart.series[1],
					    shiftPV  = seriesPV.data.length > 50,
					    shiftYL  = seriesYL.data.length > 50; // shift if the series is longer than 20
		
					// add the point
					chart.series[0].addPoint(eval(points[0]), true, shiftPV);
					chart.series[1].addPoint(eval(points[1]), true, shiftYL);
					chart.series[2].addPoint(eval(points[2]), true, shiftPV);

					var left  = chartGauches.series[0].points[0],
					    right = chartGauches.series[1].points[0],
					    leftVal, rightVal;
			    
					leftVal =  eval(points[0]);
					rightVal = eval(points[1]);
			    
					left.update(leftVal, false);
					right.update(rightVal, false);
					chartGauches.redraw();
					
					// call it again after one second
					setTimeout(requestData, 1000);	
				},
				cache: false
			});
		}
			
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					defaultSeriesType: 'areaspline',
					events: {
						load: requestData
					}
				},
				title: {
					text: 'Short history'
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 100,
					maxZoom: 20 * 1000
				},
				yAxis: {
					title: {
						text: 'Watt',
						margin: 0
					}
				},

				series: [{
					name: 'Solar panels',
					data: []
				        },{
					name: 'Youless',
					data: []
				        },{
					name: 'Yield of the Day',
					data: []
				        }]

			});	
			chartGauches = new Highcharts.Chart({
    
				chart: {
				    renderTo: 'pvCauche',
				    type: 'gauge',
				    plotBorderWidth: 1,
				    plotBackgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
					stops: [
					    [0, '#FFF4C6'],
					    [0.3, '#FFFFFF'],
					    [1, '#FFF4C6']
					]
				    },
				    plotBackgroundImage: null,
				    height: 200
				},			    
				title: {
				    text: 'Power dashboard'
				},
				pane: [{
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['25%', '145%'],
				    size: 300
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['75%', '145%'],
				    size: 300
				}],                        			    
				yAxis: [{
				    
				    min: 0,
				    max: 6000,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 500,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 1500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 1500,
					to: 6000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 0,
				    title: {
					text: 'Solar panels<br/><span style="font-size:10px">(Watt)</span>',
					y: -40
				    }
				}, {
				    min: 0,
				    max: 6000,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 500,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 1500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 1500,
					to: 6000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 1,
				    title: {
					text: 'Youless<br/><span style="font-size:10px">(Watt)</span>',
					y: -40
				    }
				}],
				plotOptions: {
				    gauge: {
					dataLabels: {
					    enabled: true
					},
					dial: {
					    radius: '100%'
					}
				    }
				},			    
				series: [{
				    data: [0],
				    dataLabels: {
				        y: -74,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + ' Watt</span><br/>';
                			},
				    },
				    yAxis: 0
				}, {
				    data: [0],
				    dataLabels: {
				        y: -74,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + ' Watt</span><br/>';
                			},
				    },
				    yAxis: 1,
				    tooltip: {valueSuffix: ' Watt'}
				}]		    
			});

		});
		</script>
		
	</head>
	<body>
		
		<!-- 3. Add the container -->
		<div id="pvCauche" style="width: 600px; height: 300px; margin: 0 auto"></div>
		<div id="container" style="width: 600px; height: 300px; margin: 0 auto"></div>
		
	</body>
</html>