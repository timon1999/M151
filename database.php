<?php
$host = 'localhost'; // host
$username = 'root'; // username
$password = ''; // password
$database = 'contact'; // database

// mit Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// fehlermeldung, falls verbindung fehl schlägt.
if ($mysqli->connect_error) {
 die('Conn');
    }
?>