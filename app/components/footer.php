<?php include_once __DIR__ . '/../../config.php'; ?>
<footer>
  <div class="footer-container">
  <div class="footer-section">
  <h3>Subscribe for Our Newsletter</h3>
  <div class="subscribe-form">
  <form action="<?= $base_url ?>app/components/subscribe.php" method="POST">
  <input type="email" name="email" placeholder="Enter your email" required />
  <button type="submit">
    <i class="fa fa-paper-plane"></i> Subscribe
  </button>
</form>
  </div>
</div>
    <div class="footer-section">
      <h3>Support</h3>
      <p>Jl. Kh. Khasim Ashari, Tangerang Kota</p>
      <p>
        <a href="mailto:LearningEnglish@gmail.com" class="email-link">visiongenius.assistant@gmail.com</a>
      </p>
    </div>

    <div class="footer-section">
      <h3>More Information</h3>
      <p>Follow Us</p>
      <img src="<?= $base_url ?>app/assets/images/barcode.png" alt="QR Code" />
      <div class="social-links">
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-facebook"></a>
        <a href="#" class="fab fa-x-twitter"></a>
      </div>
    </div>
  </div>
</footer>
<script src="<?= $base_url ?>app/assets/js/footer.js"></script>
