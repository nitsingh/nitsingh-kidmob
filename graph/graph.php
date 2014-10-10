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

<script src="/wp-includes/js/graph/graph.js"></script>