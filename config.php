<?php
// config.php

$base_url = "http://localhost/APLIKASI-TA/";

// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "db_ta"; 

// Koneksi mysqli
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");
