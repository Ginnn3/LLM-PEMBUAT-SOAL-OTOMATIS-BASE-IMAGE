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

// Ambil jawaban dan status benar/salah user dari soal 1 sampai 6 (hard mode)
$stmt = $conn->prepare("SELECT question_id, answer, is_correct FROM user_answers_hard WHERE fullname = ? AND question_id BETWEEN 1 AND 6 ORDER BY question_id ASC");
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
    1 => "Your answer is incorrect, because it does not explain how the single tree in this image can evoke various emotions and themes, such as loneliness, independence, or vulnerability. Overall, this essay does not explain to reflect on their own experiences with loneliness, independence, or vulnerability in their lives.",
    2 => "Your answer is incorrect, the essay does not explain the cup of coffee placed on a wooden table surrounded by several books, creating an inviting atmosphere for relaxation or rejuvenation during a work or study session. The essay does not remind the idea that taking a break can help individuals better manage their time and energy levels, leading to increased productivity and creativity. The presence of potted plants and vases in the image is also not explained in the essay, further emphasizing the importance of incorporating natural elements into our living spaces, as they have been shown to improve mood and overall well-being. In conclusion, the essay does not explain in concrete terms",
    3 => "Your answer is incorrect, because it does not explain the unicorn in this picture by adding an explanation of magical elements and imagination into the scene, drawing the viewer's attention and imagination. With the example explanation, its white mane and tail contrast beautifully with the bright colors of the meadow, drawing attention to it as a focal point. Overall, this essay does not explain concretely.",
    4 => "Your answer is incorrect because it does not highlight the importance of birds as symbols of freedom and the beauty of nature. It does not emphasize their unique traits and behaviors that make them interesting subjects to appreciate. It also does not emphasize the role of birds in maintaining the ecosystem and the emotional impact they can have.",
    5 => "Your answer is incorrect because it does not highlight the importance of reading as it provides many benefits to our daily lives. It also emphasizes the broader implications of reading in terms of expanding one's knowledge, understanding different cultures, and finding solace through literature.",
    6 => "Your answer is incorrect because it does not discuss the different ways people can enjoy nature, such as hiking or riding a motorcycle, and how these activities can lead to a deeper appreciation of nature."
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Result Hard</title>
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
      <h2>Your Result (Hard Mode)</h2>
      <p>You answered <?= $total_correct ?> out of 6 questions correctly.</p>
<?php if ($total_correct === 6): ?>
  <div style="margin-top: 20px; margin-bottom: 30px; padding: 20px; background-color: #d4edda; border-left: 6px solid #a042f4; border-radius: 8px;">
    <h3 style="color: #a042f4; font-size: 1.5em; margin-bottom: 10px;">
      Congratulation <?= $fullname ?>
    </h3>
    <p style="color: #a042f4; font-size: 1.1em;">
      Your deserved to the next step difficulty
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
            $explanation_text = (!$correct && isset($explanations[$i])) ? $explanations[$i] : 'Good Job Your Answer is correct';
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
