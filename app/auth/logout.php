<?php
session_start();
session_destroy();

// Base URL 
$base_url = 'http://localhost/APLIKASI-TA/';
header("Location: " . $base_url . "index.php?page=landing-page");
exit;
