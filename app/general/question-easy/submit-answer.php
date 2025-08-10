<?php
include_once(__DIR__ . '/../../../config.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: " . $base_url . "auth/login-general.php");
    exit();
}

$fullname = $_SESSION['fullname'];

$conn = new mysqli("localhost", "root", "", "db_ta");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = isset($_POST['question_id']) ? (int)$_POST['question_id'] : 0;
    $answer = $_POST['answer'] ?? '';

    $correct_answers = [
        1 => 'A',
        2 => 'A',
        3 => 'A',
        4 => 'A',
        5 => 'B',
        6 => 'C'
    ];

    if ($question_id < 1 || $question_id > 6 || empty($answer)) {
        echo "Invalid question or answer.";
        exit;
    }

    $correct_answer = $correct_answers[$question_id];
    $is_correct = ($answer === $correct_answer) ? 1 : 0;

    $stmt = $conn->prepare("REPLACE INTO user_answers_easy (fullname, question_id, answer, is_correct) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sisi", $fullname, $question_id, $answer, $is_correct);
    $stmt->execute();
    $stmt->close();

    if ($question_id >= 1 && $question_id < 6) {
        header("Location: " . $base_url . "app/general/pict-general-easy.php");
    } elseif ($question_id == 6) {
        header("Location: " . $base_url . "app/general/question-easy/result-easy.php");
    }
    exit();
} else {
    echo "Invalid request method.";
}
?>
