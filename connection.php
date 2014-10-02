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

?>