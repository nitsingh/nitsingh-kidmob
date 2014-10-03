<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>
		<script src="http://www.goat1000.com/jquery.tagcanvas.min.js" type="text/javascript"></script>
		<script src="http://code.highcharts.com/modules/data.js"></script>
		<script src="http://code.highcharts.com/modules/drilldown.js"></script>
		
		
		<script type="text/javascript" src="http://d3js.org/d3.v2.js"></script>
		<script type="text/javascript" src="http://treesheets.org/release/cts-0.5.js"></script>
		<script type="text/cts" src="http://people.csail.mit.edu/eob/cts/widgets/bubblechart.cts"></script>
		
	</head>
	<body>

        <?php
            // Including database connection
            include 'connection.php';

            try{
                $mysqli = getDBConnection();

                // questions table has mapping of tables qid to graph type
                $questionsMap = $mysqli->query("SELECT * FROM questions");

                foreach ($questionsMap as $key => $questionData) {
                    $quesId     =  $questionData[qid];
                    $quesType   =  $questionData[type];
                    $table      =  $questionData[table];

                    if ($quesType == "Bubble") {
                        createBubbleChart($mysqli, $quesId, $table);
                    }
                }

            } catch(Exception $e) {
                echo "Caught exception: ",  $e->getMessage(), "\n";
            }

            function createBubbleChart($mysqli, $quesId, $table) {

                // Collect all the responses to the question
                $responses = $mysqli->query("SELECT options, count FROM " . $table . " where qid='$quesId'");

                $chartStart = '<div class="bubblechart">'
                            .   '<ul class="bubblechains">'
                            .       '<li>'
                		    .           '<span>Responses</span>'
                		    .           '<table>';

                $chartEnd   =           '</table>'
                            .	    '</li>'
                            .   '</ul>'
                            .'</div>';
                $chartRow   = '';

                foreach ($responses as $key => $value) {
                    $chartRow = $chartRow . '<tr><td>' . $value[options] . '</td><td>' . $value[count] . '</td></tr>';
                }

                echo $chartStart . $chartRow . $chartEnd;
            }
        ?>

		<h1>What was your favorite part?</h1>
		<div id="myCanvasContainer">
			<canvas width="500" height="700" id="myCanvas">
				<p>
					Anything in here will be replaced on browsers that support the canvas element
				</p>
			</canvas>
		</div>
		<div id="tags">
			<ul>
				<li>
					<a href="http://www.google.com" target="_blank">3D Printing!</a>
				</li>
				<li>
					<a href="/fish">Putting my hand in the tube thing and forming the thermal plastic</a>
				</li>
				<li>
					<a href="/chips">From day one to the final minutes, I loved it!</a>
				</li>
				<li>
					<a href="/salt">I am not shore</a>
				</li>
				<li>
					<a href="/vinegar">We should meet moHow I got to see how a 3d printer works and I had enough materials</a>
				</li>
				<li>
					<a href="/chips">The building process </a>
				</li>
				<li>
					<a href="/salt">3d printing</a>
				</li>
				<li>
					<a href="/vinegar">3D Printing</a>
				</li>
			</ul>
		</div>
		
		<div id="containerBarChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Browser Version	Total Market Share
Critical thinking Critical Observation	26%
Creative problem solving	20%
Communications	10%
Adaptability	35%
New skills	5%
Confidence	4%</pre>

        <script>
                $(document).ready(function() {

                    /**
                     * This code creates the Word cloud
                     */
                    if(!$('#myCanvas').tagcanvas({
                        textColour: '#ff0000',
                        outlineColour: '#ff00ff',
                        reverse: true,
                        depth: 0.8,
                        maxSpeed: 0.05
                    },'tags')) {
                        // something went wrong, hide the canvas container
                        $('#myCanvasContainer').hide();
                    }


                    /**
                     * This code creates the Bar chart
                     */
                    Highcharts.data({
                        csv: document.getElementById('tsv').innerHTML,
                        itemDelimiter: '\t',
                        parsed: function (columns) {

                            var brands = {},
                                brandsData = [],
                                versions = {},
                                drilldownSeries = [];

                            // Parse percentage strings
                            columns[1] = $.map(columns[1], function (value) {
                                if (value.indexOf('%') === value.length - 1) {
                                    value = parseFloat(value);
                                }
                                return value;
                            });

                            $.each(columns[0], function (i, name) {
                                var brand,
                                    version;

                                if (i > 0) {

                                    // Remove special edition notes
                                    name = name.split(' -')[0];

                                    // Split into brand and version
                                    version = name.match(/([0-9]+[\.0-9x]*)/);
                                    if (version) {
                                        version = version[0];
                                    }
                                    brand = name.replace(version, '');

                                    // Create the main data
                                    if (!brands[brand]) {
                                        brands[brand] = columns[1][i];
                                    } else {
                                        brands[brand] += columns[1][i];
                                    }

                                    // Create the version data
                                    if (version !== null) {
                                        if (!versions[brand]) {
                                            versions[brand] = [];
                                        }
                                        versions[brand].push(['v' + version, columns[1][i]]);
                                    }
                                }

                            });

                            $.each(brands, function (name, y) {
                                brandsData.push({
                                    name: name,
                                    y: y,
                                    drilldown: versions[name] ? name : null
                                });
                            });
                            $.each(versions, function (key, value) {
                                drilldownSeries.push({
                                    name: key,
                                    id: key,
                                    data: value
                                });
                            });

                            // Create the chart
                            $('#containerBarChart').highcharts({
                                chart: {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Which of the following things did you do this week? (Bonus Points! Pick a few you feel most strongly about and give an example)'
                                },
                                subtitle: {
                                    text: ''
                                },
                                xAxis: {
                                    type: 'category'
                                },
                                legend: {
                                    enabled: false
                                },
                                plotOptions: {
                                    series: {
                                        borderWidth: 0,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.y:.1f}%'
                                        }
                                    }
                                },

                                tooltip: {
                                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                                },

                                series: [{
                                    name: 'Brands',
                                    colorByPoint: true,
                                    data: brandsData
                                }],
                                drilldown: {
                                    series: drilldownSeries
                                }
                            });
                        }
                    });


                    /**
                     * This code creates the Pie chart
                     */

                    // Make monochrome colors and set them as default for all pies
                    Highcharts.getOptions().plotOptions.pie.colors = (function () {
                        var colors = [],
                            base = Highcharts.getOptions().colors[0],
                            i;

                        for (i = 0; i < 10; i += 1) {
                            // Start out with a darkened base color (negative brighten), and end
                            // up with a much brighter color
                            colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
                        }
                        return colors;
                    }());

                    // Build the chart
                    $('#container').highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        title: {
                            text: 'On a scale from 1 to AWESOME!!! how would you rank this workshop?'
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                    }
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Browser share',
                            data: [
                                ['Awesome',    60],
                                ['3',     30],
                                ['No response',   10]
                            ]
                        }]
                    });
                });
        </script>
	</body>
</html>
