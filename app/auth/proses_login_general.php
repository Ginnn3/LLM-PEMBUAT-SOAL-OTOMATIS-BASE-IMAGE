<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_ta";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    tampilkanPopup("Koneksi Gagal", "Tidak dapat terhubung ke database!", "error", "../pages/index.php");
    exit;
}

// Validasi form
if (!isset($_POST['email']) || !isset($_POST['kata_sandi'])) {
    tampilkanPopup("Akses Tidak Valid", "Data tidak lengkap!", "error", "../auth/login-general.php");
    exit;
}

$email    = trim($_POST['email']);
$password = $_POST['kata_sandi'];

$sql = "SELECT * FROM user_general WHERE username = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];  // konsisten nama session 'fullname'
        $_SESSION['username'] = $user['username'];

        // Redirect dengan popup sukses login
        tampilkanPopup("Berhasil Login", "Selamat datang, {$user['fullname']}!", "success", "../general/difficulty-general.php");
    } else {
        tampilkanPopup("Login Gagal", "Password salah!", "error", "../auth/login-general.php");
    }
} else {
    tampilkanPopup("Login Gagal", "Username tidak ditemukan!", "error", "../auth/login-general.php");
}

$conn->close();

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
