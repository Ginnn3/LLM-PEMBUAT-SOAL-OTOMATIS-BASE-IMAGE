<?php
require_once __DIR__ . '/../../config.php';
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Help</title>
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/help.css" />
  <link rel="stylesheet" href="<?= $base_url ?>app/assets/css/components.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" >
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" href="<?= $base_url ?>app/assets/images/logo.png" type="image/png">
</head>
<body>

<?php include_once(__DIR__ . '/../components/nav-without-out.php'); ?>

  <!-- Help Section -->
  <section class="help-container">
    <h2>Hi! How can we help you?</h2>
    <p>Troubleshooting, Feedback, and more.</p>

    <div class="contact-card">
      <div class="contact-row">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="Whatsapp" />
        <span>+62 812 9769 4668</span>
      </div>
      <div class="contact-row">
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png" alt="Gmail" />
        <div>
          <p>irgindanursika3@gmail.com</p>
          <p>bayubagas0204@gmail.com</p>
        </div>
      </div>
    </div>
  </section>
  <?php include_once(__DIR__ . '/../components/footer.php'); ?>
</body>
</html>
