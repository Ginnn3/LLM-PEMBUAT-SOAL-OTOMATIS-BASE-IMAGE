<?php
session_start();
include_once __DIR__ . '/../../../config.php';

if (!isset($_SESSION['fullname'])) {
    header("Location: " . $base_url . "auth/login-general.php");
    exit;
}

$fullname = $_SESSION['fullname'];

$conn = new mysqli("localhost", "root", "", "db_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT MAX(question_id) AS last_question FROM user_answers_easy WHERE fullname = ?");
$stmt->bind_param("s", $fullname);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$last_question = (int)($row['last_question'] ?? 0);
$stmt->close();

$current_question = 1;

if ($current_question > $last_question + 1) {
    header("Location: " . $base_url . "app/general/pict-general-easy.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Question 1</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/general/css/question.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>
  <?php include(__DIR__ . '/../../components/navbar.php');?>

  <div class="container">
    <h2>Question 1: What is depicted on the image?</h2>
    <img src="<?= $base_url ?>app/general/images/bus.png" alt="Question Image" width="200" style="margin-bottom: 20px;" />
    <form id="quizForm" method="POST" action="<?= $base_url ?>app/general/question-easy/submit-answer.php">
      <input type="hidden" name="question_id" value="1" />
      <div class="choices">
        <input type="radio" id="optA" name="answer" value="A" required />
        <label for="optA">A. A yellow school bus full of students</label>

        <input type="radio" id="optB" name="answer" value="B" />
        <label for="optB">B. A group of children riding on top of a yellow bus</label>

        <input type="radio" id="optC" name="answer" value="C" />
        <label for="optC">C. A plane full of passengers</label>

        <input type="radio" id="optD" name="answer" value="D" />
        <label for="optD">D. An airplane with many people flying near it</label>
      </div>
<button class="btn-question" type="submit" style="font-family: 'Righteous', cursive; font-size: 16px; align-items: center; gap: 8px;">
 Selesai
</button>
    </form>
  </div>

  <?php include(__DIR__ . '/../../components/footer.php'); ?>

  <script>
  const BASE_URL = "<?= $base_url ?>";
  const FULLNAME = <?= json_encode($fullname) ?>;
</script>

  <script src="<?= $base_url ?>app/assets/js/footer.js"></script>
</body>
</html>
