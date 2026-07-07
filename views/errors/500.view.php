<div style="background: #ffcccc; color: #990000; padding: 20px; border-radius: 5px; border: 1px solid #ff0000;">
  <h2>System Error 🚨</h2>
  <p>පද්ධතියේ බිඳ වැටීමක් සිදුවී ඇත. කරුණාකර පසුව උත්සාහ කරන්න.</p>
  <?php if (isset($message)): ?>
    <p><strong>Error Message:</strong>
      <?php echo $message; ?>
    </p>
  <?php endif; ?>
</div>