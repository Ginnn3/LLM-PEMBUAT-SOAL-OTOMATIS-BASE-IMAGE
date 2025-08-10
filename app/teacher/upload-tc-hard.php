<?php
ini_set('max_execution_time', 300); 
include_once(__DIR__ . '/../../config.php');

$question = '';
$imagePreviewUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = $_FILES['image']['tmp_name'];

        // Buat preview base64 image
        $imagePreviewUrl = 'data:' . $_FILES['image']['type'] . ';base64,' . base64_encode(file_get_contents($imagePath));

        // Kirim ke Flask
        $curl = curl_init();
        $cfile = new CURLFile($imagePath, $_FILES['image']['type'], $_FILES['image']['name']);

        curl_setopt_array($curl, [
            CURLOPT_URL => 'http://localhost:5000/analyze-image-hard',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => ['image' => $cfile],
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            $question = 'Gagal menghubungi server Flask: ' . curl_error($curl);
        } else {
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $data = json_decode($response, true);
            if ($httpCode === 200 && isset($data['question'])) {
                $question = $data['question'];
            } else {
                $question = 'Respons tidak valid dari Flask: ' . htmlspecialchars($response);
            }
        }
        curl_close($curl);
    } else {
        $question = 'Gagal mengunggah file.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Upload Gambar-Hard Mode</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/upload-tc.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/home.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
  <style>
    .container {
      max-width: 700px;
      margin: 3rem auto;
      padding: 1rem;
      text-align: center;
    }

    .back-button {
  position: fixed;
  top: 80px; /* sesuaikan dengan tinggi navbar jika perlu */
  left: 20px;
  background-color: #a042f4;
  color: #ffff;
  padding: 8px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  z-index: 1000;
  transition: background-color 0.2s ease;
}
.back-button:hover {
  background-color: #5722d1;
}

    .form-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .file-button {
      background-color: #a042f4;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .file-button:hover {
      background-color: #5722d1;
    }

    input[type="file"] {
      display: none;
    }

    img#preview-image {
      max-width: 150px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .output-box {
      background: #eef6ee;
      margin: 2rem auto;
      padding: 20px;
      max-width: 600px;
      border-top: 6px solid #a042f4;
      border-radius: 8px;
      font-family: monospace;
      color: #333;
      text-align: left;
      width: 90%;
      box-sizing: border-box;
      overflow-x: hidden;
    }

    .output-box pre {
      white-space: pre-wrap;
      word-break: break-word;
      overflow-wrap: break-word;
      max-width: 100%;
      font-family: monospace;
      font-size: 14px;
      line-height: 1.5;
      margin: 0;
      hyphens: auto;
    }

    .loading-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(255, 255, 255, 0.8);
      z-index: 9999;
      justify-content: center;
      align-items: center;
    }

    .loading-overlay .spinner {
      font-size: 80px;
      color: #a042f4;
    }
  </style>
</head>
<body>
<?php include_once(__DIR__ . '/../components/navbar.php'); ?>

<div class="container">
  <a href="<?= $base_url ?>app/teacher/difficulty-tc.php" class="back-button">
    <i class="fas fa-arrow-left"></i> Back
  </a>

  <h1>Upload Image</h1>

  <form action="" method="POST" enctype="multipart/form-data" id="upload-form">
    <!-- Preview langsung -->
    <div id="preview-container" style="display: none;">
      <h3>Preview</h3>
      <img id="preview-image" src="" alt="Preview Gambar" />
    </div>
    <div class="form-buttons">
      <label for="image-input" class="file-button">
        <i class="fas fa-upload"></i> Choose File
      </label>
      <button type="submit" class="file-button">
        <i class="fas fa-magnifying-glass"></i> Generate
      </button>
    </div>
    <input type="file" name="image" id="image-input" accept="image/*" required />
  </form>

  <!-- Preview setelah submit -->
  <?php if ($imagePreviewUrl && $question): ?>
    <div style="margin-top: 20px;">
      <h3>Preview</h3>
      <img src="<?= $imagePreviewUrl ?>" alt="Preview Gambar" style="max-width:220px; border-radius:10px;" />
    </div>
  <?php endif; ?>

  <?php if ($question): ?>
    <div class="output-box">
      <h2>Result</h2>
      <pre><?= htmlspecialchars($question) ?></pre>
    </div>
  <?php endif; ?>
</div>

<!-- Loading Spinner -->
<div class="loading-overlay" id="loading-overlay">
  <i class="fas fa-spinner fa-spin spinner"></i>
</div>

<script>
  const imageInput = document.getElementById('image-input');
  const previewContainer = document.getElementById('preview-container');
  const previewImage = document.getElementById('preview-image');
  const loadingOverlay = document.getElementById('loading-overlay');
  const form = document.getElementById('upload-form'); 

  imageInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImage.src = e.target.result;
        previewContainer.style.display = 'block';
      };
      reader.readAsDataURL(file);
    } else {
      previewContainer.style.display = 'none';
      previewImage.src = '';
    }
  });

  form.addEventListener('submit', function () {
    loadingOverlay.style.display = 'flex';
  });
</script>

<?php include_once(__DIR__ . '/../components/footer.php'); ?>
</body>
</html>
