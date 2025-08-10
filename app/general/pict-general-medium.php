<?php 
include_once(__DIR__ . '/../../config.php'); 
session_start();

$fullname = $_SESSION['fullname'] ?? null;
if (!$fullname) {
    header("Location: " . $base_url . "login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "db_ta");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah user ingin reset soal dari awal
if (isset($_GET['reset']) && $_GET['reset'] == 1) {
    $reset_stmt = $conn->prepare("DELETE FROM user_answers_medium WHERE fullname = ?");
    $reset_stmt->bind_param("s", $fullname);
    $reset_stmt->execute();
    $reset_stmt->close();
    // Redirect agar URL bersih tanpa parameter reset
    header("Location: " . $base_url . "app/general/pict-general-medium.php");
    exit;
}

// Ambil soal terakhir yang dijawab user berdasarkan fullname dari tabel user_answers_medium
$stmt = $conn->prepare("SELECT MAX(question_id) AS last_answered FROM user_answers_medium WHERE fullname = ?");
$stmt->bind_param("s", $fullname);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$last_answered = $data['last_answered'] ?? 0;
$stmt->close();
$conn->close();

// Tentukan soal terakhir yang bisa diakses user
$last_question = max(1, $last_answered + 1);
if ($last_question > 6) $last_question = 6;

// Array data soal medium (gunakan gambar berbeda jika ada)
$questions = [
    1 => ['title' => 'Question 1', 'img' => $base_url . 'app/general/images/banana.png'],
    2 => ['title' => 'Question 2', 'img' => $base_url . 'app/general/images/cactus.png'],
    3 => ['title' => 'Question 3', 'img' => $base_url . 'app/general/images/clock.png'],
    4 => ['title' => 'Question 4', 'img' => $base_url . 'app/general/images/laptop.png'],
    5 => ['title' => 'Question 5', 'img' => $base_url . 'app/general/images/bicycle.png'],
    6 => ['title' => 'Question 6', 'img' => $base_url . 'app/general/images/canvas.png'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Image-General-Medium</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/choose-pict-general.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>
<?php include(__DIR__ . '/../components/navbar.php'); ?>
<div id="customModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
     <img src="<?= $base_url ?>app/assets/images/angry.gif" alt="Angry character" style="width: 120px; margin-bottom: 20px;" />
    <p>😡 Anda sudah menjawab soal ini.<br>Silakan selesaikan semua 6 soal terlebih dahulu!</p>
  </div>
</div>

<div class="container">
   <div class="image-grid">
    <?php foreach ($questions as $num => $q): 
        $is_answered = ($num <= $last_answered);
        $is_next = ($num == $last_answered + 1);
        $is_all_done = ($last_answered >= 6);

        // Default: dikunci
        $link = '#';
        $onclick = 'return false;';
        $class = 'locked';

        // Jika sudah dijawab tapi belum selesai semua
        if ($is_answered && !$is_all_done) {
            $link = "javascript:showCustomModal();";
            $class = 'unlocked';
            $onclick = '';
        }

        // Jika sudah dijawab dan semua soal sudah selesai
        if ($is_answered && $is_all_done) {
            $link = $base_url . "app/general/question-medium/question-$num.php";
            $class = 'unlocked';
            $onclick = '';
        }

        // Soal berikutnya bisa diakses normal
        if ($is_next) {
            $link = $base_url . "app/general/question-medium/question-$num.php";
            $class = 'unlocked';
            $onclick = '';
        }
    ?>
    <div class="image-item <?= $class ?>" data-index="<?= $num ?>">
        <img src="<?= htmlspecialchars($q['img']) ?>" alt="Gambar <?= $num ?>" />
        <a href="<?= htmlspecialchars($link) ?>" class="btn-question" <?= $onclick ? "onclick=\"$onclick\"" : "" ?>>
            Question <?= $num ?>
        </a>
    </div>
    <?php endforeach; ?>
</div>

     <?php if ($last_answered >= 6): ?>
    <div style="text-align: center; margin-top: 40px;">
  <a href="<?= $base_url ?>app/general/pict-general-medium.php?reset=1" 
     class="btn-retry">
    <i class="fa fa-rotate-left" aria-hidden="true"></i> Ulangi Soal
  </a>
</div>

  <?php endif; ?>
</div>

<?php include(__DIR__ . '/../components/footer.php'); ?>
<script>
function showCustomModal() {
  var modal = document.getElementById("customModal");
  modal.style.display = "block";
}

// Close when user clicks ×
document.querySelector(".close").onclick = function() {
  document.getElementById("customModal").style.display = "none";
}

// Close when user clicks outside modal
window.onclick = function(event) {
  var modal = document.getElementById("customModal");
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>
</body>
</html>
