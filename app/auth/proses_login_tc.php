<?php
// Tampilkan semua error
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_ta";

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    tampilkanPopup("Koneksi Gagal", "Tidak dapat terhubung ke database!", "error", "../pages/index.php");
    exit;
}

// Pastikan data form tersedia
if (!isset($_POST['email']) || !isset($_POST['kata_sandi'])) {
    tampilkanPopup("Akses Tidak Valid", "Data tidak lengkap!", "error", "../auth/login-tc.php");
    exit;
}

$email    = $_POST['email'];
$password = $_POST['kata_sandi'];

// Cek user
$sql = "SELECT * FROM user_teacher WHERE username = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $user['username'];

        tampilkanPopup("Berhasil Login", "Selamat datang, {$user['nama']}!", "success", "../teacher/difficulty-tc.php");
    } else {
        tampilkanPopup("Login Gagal", "Password salah!", "error", "../auth/login-tc.php");
    }
} else {
    tampilkanPopup("Login Gagal", "Email tidak ditemukan!", "error", "../auth/login-tc.php");
}

$conn->close();


// ---------- Fungsi popup ----------
function tampilkanPopup($title, $message, $icon, $redirect) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
    <script>
        Swal.fire({
            icon: '$icon',
            title: '$title',
            text: '$message'
        }).then(() => {
            window.location.href = '$redirect';
        });
    </script>
    </body>
    </html>
    ";
}
?>
