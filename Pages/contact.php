<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Styles/header.css" />
  <link rel="stylesheet" href="../Styles/contact.css" />
  <link rel="stylesheet" href="../Styles/footer.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>The Gallery Café - Contact Us</title>
</head>

<body>
  <!-- header section -->
  <?php include("../components/header.php");?>

  <!-- contact-section -->
  <div class="contact-container">
    <h1>Contact Us</h1>
    <div class="contact-content">
      <div class="contact-info">
        <h2>Contact Information</h2>
        <p>
          <strong>Address:</strong> 123 Coffee Street, Mocha City, CA 90210
        </p>
        <p><strong>Phone:</strong> (123) 456-7890</p>
        <p><strong>Email:</strong> info@thegallerycafe.com</p>
      </div>
      <div class="contact-form">
        <h2>Send Us a Message</h2>
        <form action="send_message.php" method="post">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required />

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />

          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject" required />

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit">Send Message</button>
        </form>
      </div>
    </div>
  </div>

  <!-- footer-section -->
  <?php include("../components/footer.php");?>
</body>

</html>