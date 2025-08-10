<?php
// Menampilkan error untuk debugging
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

// Fungsi untuk menampilkan SweetAlert2 popup
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
    showAlert('error', 'Koneksi Gagal', 'Tidak dapat terhubung ke database.', '../auth/sign-general.php');
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['email']);
    $password = $_POST['kata_sandi'];

    // Validasi input kosong
    if (empty($fullname) || empty($username) || empty($password)) {
        showAlert('warning', 'Data Tidak Lengkap', 'Semua field wajib diisi.', '../auth/sign-general.php');
    }

     // Validasi format password
     if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        showAlert('error', 'Kata Sandi Tidak Valid', 'Kata sandi harus minimal 8 karakter dan mengandung huruf, angka, dan simbol.', '../auth/sign-general.php');
    }

    // Cek apakah email sudah terdaftar
    $checkQuery = "SELECT * FROM user_general WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        showAlert('error', 'Email Sudah Terdaftar', 'Gunakan email lain untuk registrasi.', '../auth/sign-general.php');
    }

    // Enkripsi password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data baru
    $insertQuery = "INSERT INTO user_general (fullname, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $fullname, $username, $hash);

    if ($stmt->execute()) {
        showAlert('success', 'Registrasi Berhasil', 'Akun berhasil dibuat. Silakan login.', '../auth/login-general.php');
    } else {
        showAlert('error', 'Registrasi Gagal', 'Terjadi kesalahan saat menyimpan data.', '../auth/sign-general.php');
    }

    $stmt->close();
}

$conn->close();
?>
