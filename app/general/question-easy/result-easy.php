<?php
session_start();
include_once __DIR__ . '/../../../config.php';

if (!isset($_SESSION['id'])) {
    header("Location: " . $base_url . "auth/login-general.php");
    exit;
}

$fullname = $_SESSION['fullname'];

$conn = new mysqli("localhost", "root", "", "db_ta");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil jawaban dan status benar/salah user dari soal 1 sampai 6 (easy mode)
$stmt = $conn->prepare("SELECT question_id, answer, is_correct FROM user_answers_easy WHERE fullname = ? AND question_id BETWEEN 1 AND 6 ORDER BY question_id ASC");
$stmt->bind_param("s", $fullname);
$stmt->execute();
$result = $stmt->get_result();

$answers = [];
$total_correct = 0;

while ($row = $result->fetch_assoc()) {
    $answers[$row['question_id']] = $row;
    if ($row['is_correct'] == 1) {
        $total_correct++;
    }
}

$stmt->close();
$conn->close();

// Array penjelasan untuk tiap soal
$explanations = [
    1 => "Your answer incorrect, the correct answer is 'A' because the picture shows a yellow bus with full student passengers.",
    2 => "Your answer incorrect, the correct answer is 'A' because the picture shows a fire engine bus with red and yellow colors.",
    3 => "Your answer incorrect, the correct answer is 'A' because the picture shows a pizza with olives as a topping.",
    4 => "Your answer incorrect, the correct answer is 'A' because the picture shows a hot air balloon with one of its colors, namely red.",
    5 => "Your answer incorrect, the correct answer is 'B' because the picture shows the sky with blue color.",
    6 => "Your answer incorrect, the correct answer is 'A' because the picture shows a blue dragon."
];

?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Result Easy</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/general/css/question.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>
  <?php include(__DIR__ . '/../../components/navbar.php'); ?>

  <div class="container">
      <h2>Your Result (Easy Mode)</h2>
      <p>You answered <?= $total_correct ?> out of 6 questions correctly.</p>
      
<?php if ($total_correct === 6): ?>
  <div style="margin-top: 20px; margin-bottom: 30px; padding: 20px; background-color: #d4edda; border-left: 6px solid #a042f4; border-radius: 8px;">
    <h3 style="color: #a042f4; font-size: 1.5em; margin-bottom: 10px;">
      Congratulation <?= $fullname ?>
    </h3>
    <p style="color: #a042f4; font-size: 1.1em;">
      Kamu telah menunjukkan pemahaman yang sangat baik. Pertahankan semangat belajar ini! 💪
    </p>
  </div>
<?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 700px;">
      <thead>
        <tr>
          <th>Question</th>
          <th>Your Answer</th>
          <th>Correct?</th>
          <th>Explanation</th>
        </tr>
      </thead>
      <tbody style="text-align: center;">
        <?php for ($i = 1; $i <= 6; $i++): 
            $ans = $answers[$i]['answer'] ?? '-';
            $correct = isset($answers[$i]) && $answers[$i]['is_correct'] == 1;
            $icon = $correct ? '✔️' : '❌';
            $explanation_text = (!$correct && isset($explanations[$i])) ? $explanations[$i] : 'Good Job Your Answer is Correct';
        ?>

        <tr>
          <td><?= $i ?></td>
          <td><?= htmlspecialchars($ans) ?></td>
          <td><?= $icon ?></td>
          <td><?= htmlspecialchars($explanation_text) ?></td>
        </tr>
        <?php endfor; ?>
      </tbody>
    </table>

    <br />
    <a href="<?= $base_url ?>app/general/difficulty-general.php" class="btn-question">Back to Quiz Home</a>
  </div>

  <?php include(__DIR__ . '/../../components/footer.php'); ?>
</body>
</html>
