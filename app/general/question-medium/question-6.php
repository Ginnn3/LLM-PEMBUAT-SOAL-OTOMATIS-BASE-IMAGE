<?php
session_start();
include_once __DIR__ . '/../../../config.php';

if (!isset($_SESSION['id']) || !isset($_SESSION['fullname'])) {
    header("Location: " . $base_url . "auth/login-general.php");
    exit;
}

$fullname = $_SESSION['fullname'];
$conn = new mysqli("localhost", "root", "", "db_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$current_question = 6;
$prev_question = 5;

// Pastikan soal sebelumnya sudah dijawab di user_answers_medium
$stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM user_answers_medium WHERE fullname = ? AND question_id = ?");
$stmt->bind_param("si", $fullname, $prev_question);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row['cnt'] == 0) {
    header("Location: " . $base_url . "app/general/question-medium/question-5.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Question 6</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/general/css/question.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
  <?php include(__DIR__ . '/../../components/navbar.php'); ?>

  <div class="container">
    <h2>Question 3: Short answer based on the image shown</h2>
<p style="font-family: 'Righteous', cursive; font-size: 18px; margin-bottom: 12px;">
  Look at the image below. Short answer:<br>
  What is the woman holding in her hand?
</p>
    <img src="<?= $base_url ?>app/general/images/canvas.png" alt="Question Image" width="200" style="margin-bottom: 20px;" />

    <form id="quizForm" method="POST" action="<?= $base_url ?>app/general/question-medium/submit-answer-medium.php">
      <input type="hidden" name="question_id" value="6" />
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
