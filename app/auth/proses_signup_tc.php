<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_ta";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Fungsi untuk tampilkan popup SweetAlert2
function showAlert($icon, $title, $text, $redirect) {
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Notifikasi</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$text',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '$redirect';
            });
        </script>
    </body>
    </html>
    ";
    exit();
}

// Cek koneksi
if ($conn->connect_error) {
    showAlert('error', 'Koneksi Gagal', 'Tidak dapat terhubung ke database.', '../auth/sign-tc.php');
}

// Ambil data dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama     = trim($_POST['nama']);
    $nig      = trim($_POST['nig']);
    $username = trim($_POST['email']);
    $password = $_POST['kata_sandi'];

    // Validasi input kosong
    if (empty($nama) || empty($nig) || empty($username) || empty($password)) {
        showAlert('warning', 'Data Tidak Lengkap', 'Semua field wajib diisi.', '../auth/sign-tc.php');
    }
// Validasi Regex format NIG
if (!preg_match('/^\d{1,16}$/', $nig)) {
    showAlert('error', 'NIG Tidak Valid', 'NIG harus terdiri dari maksimal 16 digit angka.', '../auth/sign-tc.php');
}
// Validasi Regex format password
if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
    showAlert('error', 'Kata Sandi Tidak Valid', 'Kata sandi harus minimal 8 karakter dan mengandung huruf, angka, dan simbol.', '../auth/sign-tc.php'); 
}

    // Cek apakah email sudah digunakan
    $cek = "SELECT * FROM user_teacher WHERE username = ?";
    $stmt = $conn->prepare($cek);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        showAlert('error', 'Email Sudah Terdaftar', 'Gunakan email lain.', '../auth/sign-tc.php');
    }

    // Enkripsi password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data
    $query = "INSERT INTO user_teacher (nama, nig, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nama, $nig, $username, $hash);

    if ($stmt->execute()) {
        showAlert('success', 'Registrasi Berhasil', 'Silakan login sekarang.', '../auth/login-tc.php');
    } else {
        showAlert('error', 'Registrasi Gagal', 'Terjadi kesalahan saat menyimpan data.', '../auth/sign-tc.php');
    }

    $stmt->close();
}

$conn->close();
?>
