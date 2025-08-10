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

// Ambil progres terakhir user untuk soal medium
$stmt = $conn->prepare("SELECT MAX(question_id) AS last_question FROM user_answers_medium WHERE fullname = ?");
$stmt->bind_param("s", $fullname);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$last_question = (int)($row['last_question'] ?? 0);
$stmt->close();

$current_question = 2;

// Cegah user lompat soal
if ($current_question > $last_question + 1) {
    header("Location: " . $base_url . "app/general/question-medium/question-1.php");
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>
  <?php include(__DIR__ . '/../../components/navbar.php'); ?>

  <div class="container">
    <h2>Question 2:  Short answer based on the image shown</h2>
<p style="font-family: 'Righteous', cursive; font-size: 18px; margin-bottom: 12px;">
  Look at the image below. Short answer:<br>
  A cactus is growing in a desert with other plants around it. What color are the clouds in the sky?
</p>
    <img src="<?= $base_url ?>app/general/images/cactus.png" alt="Question Image" width="200" style="margin-bottom: 20px;" />
    <form id="quizForm" method="POST" action="<?= $base_url ?>app/general/question-medium/submit-answer-medium.php">
      <input type="hidden" name="question_id" value="2" />
      <input type="hidden" name="fullname" value="<?= htmlspecialchars($fullname) ?>" />
      <div class="form-group">
        <label for="answer" style="font-family: 'Righteous', cursive;">Your Answer:</label>
        <input type="text" id="answer" name="answer" class="input-answer" placeholder="Type your answer here..." required />
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
