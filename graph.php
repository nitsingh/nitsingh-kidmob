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

                    // Collect all the responses to the question
                    $responses = $mysqli->query("SELECT * FROM " . $table . " where qid='$quesId'");

                    if ($quesType == "Bubble") {
                        echo createBubbleChart($responses);
                    } else if($quesType == "WordCloud") {
                        echo createWordCloud($responses);
                    } else if($quesType == "Bar") {
                        echo createBar($responses);
                    }
                }

            } catch(Exception $e) {
                echo "Caught exception: ",  $e->getMessage(), "\n";
            }

            function createBubbleChart($responses) {

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

                return $chartStart . $chartRow . $chartEnd;
            }

            function createWordCloud($responses) {
               //FIXME: Move the question to the database
               $question            = '<h1>What was your favorite part?</h1>';
               $canvas              = '<div id="myCanvasContainer">'
                                    .   '<canvas width="500" height="700" id="myCanvas">'
                                    .       '<p>'
                                    .           'Anything in here will be replaced on browsers that support the canvas element'
                                    .       '</p>'
                                    .   '</canvas>'
                                    . '</div>';

                $cloudDataStart     = '<div id="tags">'
                                    . '<ul>';
                $cloudDataEnd       = '</ul>'
                                    . '</div>';

                $cloudData          = '';
                foreach ($responses as $key => $value) {
                    $cloudData = $cloudData . '<li><a>' . $value[content] . '</a></li>';
                }

                return $question . $canvas . $cloudDataStart . $cloudData . $cloudDataEnd;
            }

            function createBar($response) {

            }
        ?>
		
		<div id="containerBarChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Browser Version	Total Market Share
Critical thinking Critical Observation	26%
Creative problem solving	20%
Communications	10%
Adaptability	35%
New skills	5%
Confidence	4%</pre>

        <script src="wp-includes/js/graph/graph.js"></script>
	</body>
</html>
