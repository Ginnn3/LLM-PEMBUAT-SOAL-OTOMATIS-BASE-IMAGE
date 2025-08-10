<?php
session_start();

// Mengecek apakah user sudah login
if (isset($_SESSION['username'])) {
    echo "<script>
        alert('Anda sedang aktif, tidak dapat mengakses halaman ini, silakan login kembali dan logout!');
        window.location.href = 'app/pages/home.php';
    </script>";
    return;
}

// Base URL
$base_url = 'http://localhost/APLIKASI-TA/';

// Koneksi database
include __DIR__ . '/config.php';


// Routing halaman berdasarkan parameter ?page=
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'about':
            include __DIR__ . '/app/pages/about.php';
            break;
        case 'help':
            include __DIR__ . '/app/pages/help.php';
            break;
        case 'home':
            include __DIR__ . '/app/pages/home.php';
            break;
        case 'landing-page':
            include __DIR__ . '/app/pages/landing-page.php';
            break;
        default:
            include __DIR__ . '/app/pages/landing-page.php';
            break;
    }
} else {
    include __DIR__ . '/app/pages/landing-page.php';
}
?>
