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
            include 'Util.php';

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
        ?>
		
        <script src="/demo/wp-includes/js/graph/graph.js"></script>
	</body>
</html>
