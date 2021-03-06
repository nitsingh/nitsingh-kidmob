<?php

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

    function createBar($responses) {
        $data = '[';
        foreach ($responses as $key => $value) {
            $data = $data . '["' . $value[options] . '",' . $value[count] . '],';
        }
        $data = rtrim($data, ",");
        $data = $data . ']';

        $canvas = '<div id="containerBarChart" data-graph=\'' . $data . '\' style="min-width: 310px; height: 400px; margin: 0 auto"></div>';

        return $canvas;
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

?>