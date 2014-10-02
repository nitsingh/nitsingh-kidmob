<?php
    try {
        $filePath = "survey.xml";

        $mysqli = getDBConnection();
        $xml = xmlParser($filePath);

        xmlToDB($mysqli, $xml);

    } catch(Exception $e) {
        echo "Caught exception: ",  $e->getMessage(), "\n";
    }

    function xmlToDB($mysqli, $xml) {
        $page = $xml->page;
        $questions = $page->question;

        xmlToMCQTable($mysqli, $questions);
        xmlToFreeTextTable($mysqli, $questions);
    }

    function xmlToFreeTextTable($mysqli, $questions) {
        foreach ($questions as $qNo => $ques) {
            $qText = $ques->qText;
            $qid =  $ques->attributes()[1];

            if($ques->attributes()[0] == 200){
                $responseArr = [];
                $responseObj = ($ques->responses->response);
                foreach ($responseObj as $key => $res) {
                    array_push($responseArr, (string)$res);
                }
                $responseArr = array_filter($responseArr);
                foreach ($responseArr as $key => $value) {
                    $query = "INSERT INTO freetext(qid,content) VALUES ('$qid','$value')";
                    $response = $mysqli->query($query);

                    if(!$response) {
                        throw new Exception("Table insertion failed: (" . $mysqli->errno . ") " . $mysqli->error);
                    }
                }

            }
        }
    }

    function xmlToMCQTable($mysqli, $questions) {
        foreach ($questions as $qNo => $ques) {
            $qText = $ques->qText;
            $qid =  $ques->attributes()[1];

            if ($ques->attributes()[0] == 400) {
                $responseArr = [];
                $responseObj = ($ques->responses);
                foreach ($responseObj as $key => $res) {
                    foreach ($res as $key => $options) {
                        foreach ($options as $key => $option) {
                            foreach ($option as $optkey => $optVal) {
                                array_push($responseArr, (string)$optVal);
                            }
                        }
                    }
                }
                $responseArr = array_filter($responseArr);

                $responseArr = array_count_values($responseArr);
                foreach ($responseArr as $key => $value) {
                    $query = "INSERT INTO mcq(qid,options,count) VALUES ('$qid','$key','$value')";
                    $response = $mysqli->query($query);

                    if(!$response) {
                        throw new Exception("Table insertion failed: (" . $mysqli->errno . ") " . $mysqli->error);
                    }
                }
            }
        }
    }

    function getDBConnection() {
        $host = "127.0.0.1";
        $user = "root";
        $password = "root";
        $database = "kidmob";
        $port = 8889;

        $mysqli = new mysqli($host, $user, $password, $database, $port);
        if ($mysqli->connect_errno) {
            throw new Exception("DB connection failed: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error . "\n");
        }

        return $mysqli;
    }

    function xmlParser($filePath) {
        if (file_exists($filePath)) {

            // simplexml_load_file will return FALSE on failure
            $xml = simplexml_load_file($filePath);
            if($xml === FALSE) {
                throw new Exception("XML parsing failed for " . $filePath);
            } else {
                return $xml;
            }
        } else {
            throw new Exception("Failed to open " . $filePath);
        }
    }
?>