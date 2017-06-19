
<?php
    error_reporting(22527);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		<script src="./js/highcharts.js"></script>
		<script src="./js/highcharts-more.js"></script>	
	
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Powerplant De Hoek, Live</title>
		<style type="text/css" title="text/css">

.clockCauche {
	float: left;
	width: 200px;
	height: 200px;
	background-color: #FFFFFF;
}

.pvCauche {
	float: left;
	width: 900px;
	height: 200px;
	background-color: #FFFFFF; 
}
.pvCaucheSmall {
	float: left;
	width: 900px;
	height: 200px;
	background-color: #FFFFFF; 
}

.shortHistory {
        float: left;
	width: 98%;
	height: 400px;
	background-color: #FFFFFF; 
}

.statetbl {
	float: left;
	width: 200px;
	height: 200px;
	background-color: #FFFFFF; 
}


</style>
		
<!--		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/highcharts.src.js"></script>
		<script src="js/highcharts.js"></script>
		<script src="js/highcharts-more.js"></script> -->
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		<script type="text/javascript">
		var chart;
		var chartGauches;
		var chartACFases;
		var chartDCiFases;
		
		var clock;
		var now = getNow();


		/**
		 * Get the current time
		 */
		function getNow () {
			var now = new Date();
			    
			return {
			    hours: now.getHours() + now.getMinutes() / 60,
			    minutes: now.getMinutes() * 12 / 60 + now.getSeconds() * 12 / 3600,
			    seconds: now.getSeconds() * 12 / 60
			};
		};
		
		/**
		 * Request data from the server, add it to the graph and set a timeout to request again
		 */
		function requestData() {
			$.ajax({
				url: 'getLiveData.php', 
				success: function(points) {
					//document.write(points+"<br>"); 

					//
					// Update document title
					//
					var title = eval(points[0]);
					document.title = "(" + title[1] + ") PV DeHoek";

					//
					// update state
					//
					document.getElementById("invertorState").innerHTML = points[6]+"<br>TotalYield: "+points[7]+"<br>RealYield: "+points[8]+"<br>Direction: "+points[9];	
					
					//
					// Update Graphics
					//
					var 
					seriesPV = chart.series[0],
					seriesYL = chart.series[1],
					shiftPV  = seriesPV.data.length > 1000,
					shiftYL  = seriesYL.data.length > 1000; 
		
					// add the point
					chart.series[0].addPoint(eval(points[0]), true, shiftPV);
					chart.series[1].addPoint(eval(points[1]), true, shiftYL);
					chart.series[2].addPoint(eval(points[2]), true, shiftPV);
					chart.series[3].addPoint(eval(points[11]), true, shiftPV);
					chart.series[4].addPoint(eval(points[12]), true, shiftPV);
					chart.series[5].addPoint(eval(points[13]), true, shiftPV);

					// 
					// Update Youless and Actual Power gauges
					//
					var left  = chartGauches.series[0].points[0],
					    right = chartGauches.series[1].points[0],
					    real  = chartGauches.series[2].points[0],
					    leftVal, rightVal, realVal;
			    
					leftVal =  eval(points[0]);
					rightVal = eval(points[1]);
					realVal =  eval(points[10]);
			    
					left.update(leftVal, false);
					right.update(rightVal, false);
					real.update(realVal, false);
					chartGauches.redraw();
					
					//
					// Update AC gauges
					//
					var ac1 = chartACFases.series[0].points[0],
					    ac2 = chartACFases.series[1].points[0],
					    ac3 = chartACFases.series[2].points[0],
					    ac1Val, ac2Val, ac3Val;
			    
					ac1Val = eval(points[11]);
					ac2Val = eval(points[12]);
					ac3Val = eval(points[13]);
			    
					ac1.update(ac1Val, false);
					ac2.update(ac2Val, false);
					ac3.update(ac3Val, false);
					chartACFases.redraw();

					//
					// Update DCi gauges
					//
					var dc1 = chartDCiFases.series[0].points[0],
					    dc2 = chartDCiFases.series[1].points[0],
					    dc3 = chartDCiFases.series[2].points[0],
					    dc1Val, dc2Val, dc3Val;
			    
					dc1Val = eval(points[3]);
					dc2Val = eval(points[4]);
					dc3Val = eval(points[5]);
			    
					dc1.update(dc1Val, false);
					dc2.update(dc2Val, false);
					dc3.update(dc3Val, false);
					chartDCiFases.redraw();
										
					//
					// Set clock
					//
					var newDate = new Date(points[0][0]);
					
			    		var hours = newDate.getHours() + newDate.getMinutes() / 60,
			    		    min   = newDate.getMinutes() * 12 / 60 + newDate.getSeconds() * 12 / 3600,
			    		    secs  = newDate.getSeconds() * 12 / 60;
            
            				var hourDial = clock.get('hour'),
                			    minuteDial = clock.get('minute'),
                			    secondDial = clock.get('second');

            				hourDial.update(hours, true, false);//, animation);
            				minuteDial.update(min, true, false);//, animation);
            				secondDial.update(secs, true, false);//, animation);
					
					clock.redraw();
					
					
					
					// call it again after two second
					setTimeout(requestData, 500);	
				},
				cache: false
			});
		}
			
		$(document).ready(function() {

			Highcharts.setOptions({
				global : {
				useUTC : false
				}
			});		
			chart = new Highcharts.Chart({
			    chart: {
				renderTo: 'shortHistory',
				borderWidth: 1,
                                backgroundColor: '#FFFFE7',
//				zoomType: 'xy',
				events: {
						load: requestData
					}
			    },
			    plotOptions: {
				areaspline: {
				  stacking: 'normal',
				  lineColor: '#666666',
				  lineWidth: 1,
				  marker: {
				    lineWidth: 1,
				    lineColor: '#666666'
				  }
				}
			      },
			    
			    credits: {
				enabled: false
			    },
			    title: {
				text: 'Last few minutes...'
			    },
			    subtitle: {
				text: 'Source: youless and powerstocc'
			    },
			    xAxis: [{
					type: 'datetime',
					tickPixelInterval: 100,
					maxZoom: 20 * 1000
				}],
			    yAxis: [{ // Primary yAxis
				title: {
				    text: 'Wh'
				},
				opposite: true
		    
			    }, { // Secondary yAxis
				gridLineWidth: 0,
				title: {
				    text: 'Watt',
				}
		    
			    }],

			    
			    series: [{
				name: 'Solar Panels',
				type: 'spline',
				yAxis: 1,
				data: [],
				marker: {
				    enabled: false
				}
		    
			    }, {
				name: 'Youless',
				type: 'spline',
				yAxis: 1,
				data: [],
				marker: {
				    enabled: false
				},
				dashStyle: 'shortdot'
		    
			    }, {
				name: 'Daily Yield',
				type: 'spline',
				data: [],
				marker: {
				    enabled: false
				},
				dashStyle: 'shortdot'
		    
			    }, {
				name: 'String1 Yield',
				type: 'areaspline',
				yAxis: 1,
				data: [],
				marker: {
				    enabled: false
				}
		    
			    }, {
				name: 'String2 Yield',
				type: 'areaspline',
				yAxis: 1,
				data: [],
				marker: {
				    enabled: false
				}
		    
			    }, {
				name: 'String3 Yield',
				type: 'areaspline',
				yAxis: 1,
				data: [],
				marker: {
				    enabled: false
				}
		    
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
				credits: {
					enabled: false
				},
				title: {
				    text: 'Power dashboard'
				},
				pane: [{
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['17%', '145%'],
				    size: 300
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['50%', '145%'],
				    size: 300
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['83%', '145%'],
				    size: 300
				}],                        			    
				yAxis: [
				{				    
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
				}, 
				{
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
				}, 
				{
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
				    pane: 2,
				    title: {
					text: 'USAGE<br/><span style="font-size:10px">(Watt)</span>',
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
				        y: -90,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + ' Watt</span><br/>';
                			},
				    },
				    yAxis: 0
				}, {
				    data: [0],
				    dataLabels: {
				        y: -90,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + ' Watt</span><br/>';
                			},
				    },
				    yAxis: 1,
				    tooltip: {valueSuffix: ' Watt'}
				}, {
				    data: [0],
				    dataLabels: {
				        y: -90,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + ' Watt</span><br/>';
                			},
				    },
				    yAxis: 2,
				    tooltip: {valueSuffix: ' Watt'}
				}]		    
			});
			
			chartDCiFases = new Highcharts.Chart({
    
				chart: {
				    renderTo: 'DciFasesCauche',
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
				    height: 160
				},			    
				credits: {
					enabled: false
				},
				title: {
				    text: 'DC I'
				},
				pane: [{
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['17%', '125%'],
				    size: 180
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['50%', '125%'],
				    size: 180
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['83%', '125%'],
				    size: 180
				}],                        			    
				yAxis: [{
				    
				    min: 0,
				    max: 5,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 200,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 200,
					to: 500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 2000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 0,
				    title: {
					text: 'DC i 1<span style="font-size:10px">(Amp)</span>',
					y: -20
				    }
				}, {
				    
				    min: 0,
				    max: 5,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 200,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 200,
					to: 500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 2000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 1,
				    title: {
					text: 'DC i 2<span style="font-size:10px">(Amp)</span>',
					y: -20
				    }
				},{
				    
				    min: 0,
				    max: 5,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 200,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 200,
					to: 500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 2000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 2,
				    title: {
					text: 'DC i 3<span style="font-size:10px">(Amp)</span>',
					y: -20
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
				        y: -50,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + '</span><br/>';
                			},
				    },
				    yAxis: 0
				}, {
				    data: [0],
				    dataLabels: {
				        y: -50,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + '</span><br/>';
                			},
				    },
				    yAxis: 1,
				    tooltip: {valueSuffix: ' Watt'}
				}, {
				    data: [0],
				    dataLabels: {
				        y: -50,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + '</span><br/>';
                			},
				    },
				    yAxis: 2,
				    tooltip: {valueSuffix: ' Watt'}
				}]		    
			});
			chartACFases = new Highcharts.Chart({
    
				chart: {
				    renderTo: 'AcFasesCauche',
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
				    height: 160
				},			    
				credits: {
					enabled: false
				},
				title: {
				    text: 'AC Power dashboard'
				},
				pane: [{
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['17%', '125%'],
				    size: 180
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['50%', '125%'],
				    size: 180
				}, {
				    startAngle: -45,
				    endAngle: 45,
				    background: null,
				    center: ['83%', '125%'],
				    size: 180
				}],                        			    
				yAxis: [{
				    
				    min: 0,
				    max: 2000,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 200,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 200,
					to: 500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 2000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 0,
				    title: {
					text: 'AC 1<span style="font-size:10px">(Watt)</span>',
					y: -20
				    }
				}, {
				    
				    min: 0,
				    max: 2000,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 200,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 200,
					to: 500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 2000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 1,
				    title: {
					text: 'AC 2<span style="font-size:10px">(Watt)</span>',
					y: -20
				    }
				},{
				    
				    min: 0,
				    max: 2000,
				    minorTickPosition: 'outside',
				    tickPosition: 'outside',
				    labels: {
					rotation: 'auto',
					distance: 20
				    },
				    plotBands: [{
					from: 0,
					to: 200,
					color: '#C02316',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 200,
					to: 500,
					color: '#FFA500',
					innerRadius: '100%',
					outerRadius: '105%'
				    },{
					from: 500,
					to: 2000,
					color: '#008000',
					innerRadius: '100%',
					outerRadius: '105%'
				    }
				    ],
				    pane: 2,
				    title: {
					text: 'AC 3<span style="font-size:10px">(Watt)</span>',
					y: -20
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
				        y: -50,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + '</span><br/>';
                			},
				    },
				    yAxis: 0
				}, {
				    data: [0],
				    dataLabels: {
				        y: -50,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + '</span><br/>';
                			},
				    },
				    yAxis: 1,
				    tooltip: {valueSuffix: ' Watt'}
				}, {
				    data: [0],
				    dataLabels: {
				        y: -50,	
                			formatter: function () {
                    				var value = this.y;
                    				return '<span style="color:#339">'+ value + '</span><br/>';
                			},
				    },
				    yAxis: 2,
				    tooltip: {valueSuffix: ' Watt'}
				}]		    
			});
			

			clock = new Highcharts.Chart({
				chart: {
				    renderTo: 'clockCauche',
				    type: 'gauge',
				    plotBackgroundColor: null,
				    plotBackgroundImage: null,
				    plotBorderWidth: 0,
				    plotShadow: false,
				    height: 200
				},
				credits: {
				    enabled: false
				},
				title: {
				    text: 'Time'
				},
				pane: {
				    background: [{
					// default background
				    }, {
					// reflex for supported browsers
					backgroundColor: Highcharts.svg ? {
					    radialGradient: {
						cx: 0.5,
						cy: -0.4,
						r: 1.9
					    },
					    stops: [
						[0.5, 'rgba(255, 255, 255, 0.2)'],
						[0.5, 'rgba(200, 200, 200, 0.2)']
					    ]
					} : null
				    }]
				},
				yAxis: {
				    labels: {
					distance: -20
				    },
				    min: 0,
				    max: 12,
				    lineWidth: 0,
				    showFirstLabel: false,
				    
				    minorTickInterval: 'auto',
				    minorTickWidth: 1,
				    minorTickLength: 5,
				    minorTickPosition: 'inside',
				    minorGridLineWidth: 0,
				    minorTickColor: '#666',
			    
				    tickInterval: 1,
				    tickWidth: 2,
				    tickPosition: 'inside',
				    tickLength: 10,
				    tickColor: '#666',
				    title: {
					text: '',
					style: {
					    color: '#BBB',
					    fontWeight: 'normal',
					    fontSize: '8px',
					    lineHeight: '10px'                
					},
					y: 10
				    }       
				},
				series: [{
				    data: [{
					id: 'hour',
					y: now.hours,
					dial: {
					    radius: '60%',
					    baseWidth: 4,
					    baseLength: '95%',
					    rearLength: 0
					}
				    }, {
					id: 'minute',
					y: now.minutes,
					dial: {
					    baseLength: '95%',
					    rearLength: 0
					}
				    }, {
					id: 'second',
					y: now.seconds,
					dial: {
					    radius: '100%',
					    baseWidth: 1,
					    rearLength: '20%'
					}
				    }],
				    animation: false,
				    dataLabels: {
					enabled: false
				    }
				}]
			});			
   
		});		
		</script>
	</head>
	<body>	
		<div id="shortHistory"      class="shortHistory"></div>
		<div id="pvCauche"          class="pvCauche"></div>
		<div id="invertorState"     class="statetbl">State:</div>
		<div id="clockCauche"       class="clockCauche"></div>
		<div id="AcFasesCauche"     class="pvCaucheSmall"></div>
		<div id="DciFasesCauche"    class="pvCaucheSmall"></div>
<!--		<div style="font-family: Arial;background-color: #fff4ba;border: 1px solid transparent;width: 315px;height: 250px;-moz-box-shadow: 0 0 2px 1px transparent;-webkit-box-shadow: 0 0 2px 1px transparent;box-shadow: 0 0 2px 1px transparent;overflow: hidden; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;"><div style="width: 315px;height: 250px;"><div style="margin:7px 10px;"><div style="color: #222222;font-family: Arial;font-size: 12px;font-weight: bold;margin: 0px 0px 7px 0px;line-height: 14px;">UV-index<br/><span style="font-weight:normal;">Haalderen</span></div><iframe id="widget-frame" src="http://www.weeronline.nl/Go/ExternalWidgetsNew/TwoDaysCityUV?gid=4057771&temperatureScale=Celsius&defaultSettings=False" width="295" height="145" frameborder="0" scrolling="no" style="border: none;" allowtransparency="true"></iframe><a href="http://www.weeronline.nl/Europa/Nederland/Zonkracht-Haalderen/4057771" style="background: url(http://www.weeronline.nl/Shared/Images/widget/list_icon_blue_trans.gif) no-repeat scroll left 1px transparent;color: #0160b2;font-family: Arial;font-size: 12px;font-weight: normal;padding-left: 14px;margin: 7px 0px 5px 0px;line-height: 12px;outline: none;text-decoration: none;display: inline-block;" target="_blank">Uitgebreide UV-index verwachting in Haalderen</a><a href="http://www.weeronline.nl/" style="background: url(http://www.weeronline.nl/Shared/Images/widget/new-widget-logo.png) repeat scroll left bottom transparent;display: block;height: 25px;width: 113px;margin: 0px 10px 8px 0px;outline: none;text-decoration: none;" title="WeerOnline.nl Altijd jouw weer" target="_blank"></a></div></div></div>
-->
	</body>
</html>
