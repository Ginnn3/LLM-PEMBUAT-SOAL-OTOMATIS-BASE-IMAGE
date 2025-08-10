<?php 
include_once __DIR__ . '/../../config.php';
require __DIR__ . '/../../vendor/autoload.php'; // autoload PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "
        <html>
        <head>
            <title>Invalid Email</title>
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: rgba(0,0,0,0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .popup {
                    background: #fff;
                    padding: 30px 40px;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                    text-align: center;
                    max-width: 400px;
                }
                .popup h2 {
                    color: #d32f2f;
                    margin-bottom: 10px;
                }
                .popup p {
                    color: #555;
                }
            </style>
            <script>
                setTimeout(function() {
                    window.location.href = '" . $base_url . "';
                }, 3000);
            </script>
        </head>
        <body>
            <div class='popup'>
                <h2>Invalid email address!</h2>
                <p>You will be redirected to the homepage...</p>
            </div>
        </body>
        </html>
        ";
        exit;
    }

    try {
        // Cek apakah email sudah ada
        $checkStmt = $mysqli->prepare("SELECT id FROM subscribers WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
    
        if ($checkStmt->num_rows > 0) {
            // Email sudah terdaftar
            echo "
            <html>
            <head>
                <title>Email Already Registered</title>
                <style>
                    body {
                        margin: 0;
                        font-family: Arial, sans-serif;
                        background-color: rgba(0,0,0,0.5);
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .popup {
                        background: #fff;
                        padding: 30px 40px;
                        border-radius: 10px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                        text-align: center;
                        max-width: 400px;
                    }
                    .popup h2 {
                        color: #f57c00;
                        margin-bottom: 10px;
                    }
                    .popup p {
                        color: #555;
                    }
                </style>
                <script>
                    setTimeout(function() {
                        window.location.href = '" . $base_url . "';
                    }, 3000);
                </script>
            </head>
            <body>
                <div class='popup'>
                    <h2>Email already registered!</h2>
                    <p>You will be redirected to the homepage...</p>
                </div>
            </body>
            </html>
            ";
            exit;
        }
    
        // Jika belum ada, simpan dan kirim email
        $stmt = $mysqli->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        // Kirim notifikasi email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'visiongenius.assistant@gmail.com';
        $mail->Password   = 'cyyq svtt snwn jcyf'; // app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
    
        $mail->setFrom('bayubagas0204@gmail.com', 'Your Website Vission Genius');
        $mail->setFrom('irgindanursika3@gmail.com', 'Your Website Vission Genius');
        $mail->setFrom('visiongenius.assistant@gmail.com', 'Your Website Vission Genius');
        $mail->addAddress('visiongenius.assistant@gmail.com');
        $mail->addAddress('bayubagas0204@gmail.com');
        $mail->addAddress('irgindanursika3@gmail.com');
        $mail->Subject = 'New Subscriber!';
        $mail->Body    = "You have a new subscriber: $email";
    
        $mail->send();
    
        echo "
        <html>
        <head>
            <title>Subscription Successful</title>
            <style>
                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: rgba(0,0,0,0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .popup {
                    background: #fff;
                    padding: 30px 40px;
                    border-radius: 10px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                    text-align: center;
                    max-width: 400px;
                }
                .popup h2 {
                    color: #6a1b9a;
                    margin-bottom: 10px;
                }
                .popup p {
                    color: #555;
                }
            </style>
            <script>
                setTimeout(function() {
                    window.location.href = '" . $base_url . "';
                }, 3000);
            </script>
        </head>
        <body>
            <div class='popup'>
                <h2>Thank you for subscribing!</h2>
                <p>You will be redirected to the homepage...</p>
            </div>
        </body>
        </html>
        ";
    
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    
} else {
    echo "No email submitted.";
}
