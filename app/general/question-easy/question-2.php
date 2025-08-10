<?php
session_start();
include_once __DIR__ . '/../../../config.php';

if (!isset($_SESSION['id'])) {
    header("Location: " . $base_url . "auth/login-general.php");
    exit;
}

$fullname = $_SESSION['fullname'] ?? '';

// Koneksi DB
$conn = new mysqli("localhost", "root", "", "db_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil progres terakhir (soal terakhir yang sudah dijawab user)
$stmt = $conn->prepare("SELECT MAX(question_id) AS last_question FROM user_answers_easy WHERE fullname = ?");
$stmt->bind_param("s", $fullname);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$last_question = (int)($row['last_question'] ?? 0);
$stmt->close();

$current_question = 2;

// Jika user coba akses soal lebih dari 1 soal berikutnya yang belum dijawab, redirect ke soal 1
if ($current_question > $last_question + 1) {
    header("Location: " . $base_url . "app/general/question-easy/question-1.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Question 2</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/general/css/question.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">

</head>
<body>
  <?php include(__DIR__ . '/../../components/navbar.php'); ?>

  <div class="container">
    <h2>Question 2: What is the color of the fire truck in front of which the group of firemen are standing?</h2>
    <img src="<?= $base_url ?>app/general/images/firefighter.png" alt="Question Image" width="200" style="margin-bottom: 20px;" />
    <form id="quizForm" method="POST" action="<?= $base_url ?>app/general/question-easy/submit-answer.php">
      <input type="hidden" name="question_id" value="2" />
      <input type="hidden" name="fullname" value="<?= htmlspecialchars($fullname) ?>" />
      <div class="choices">
        <input type="radio" id="optA" name="answer" value="A" required />
        <label for="optA">A. Yellow and red</label>

        <input type="radio" id="optB" name="answer" value="B" />
        <label for="optB">B. Silver</label>

        <input type="radio" id="optC" name="answer" value="C" />
        <label for="optC">C. White</label>

        <input type="radio" id="optD" name="answer" value="D" />
        <label for="optD">D. Black</label>
      </div>
      <button class="btn-question" type="submit" style="font-family: 'Righteous', cursive; font-size: 16px; align-items: center; gap: 8px;">
        Selesai
      </button>
    </form>
  </div>

  <?php include(__DIR__ . '/../../components/footer.php'); ?>

  <script>
    const BASE_URL = "<?= $base_url ?>";
    const USER_FULLNAME = <?= json_encode($fullname) ?>;
  </script>
  <script src="<?= $base_url ?>app/assets/js/footer.js"></script>
</body>
</html>
