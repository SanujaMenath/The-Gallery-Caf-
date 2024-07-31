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
  <?php include ("../components/header.php"); ?>

  <!-- contact-section -->
  <div class="contact-container">
   
    <h1>Contact Us</h1>
    <div class="contact-content">
      <div class="contact-info">
      <h2>Contact Information</h2>
      <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7921.7920951135475!2d79.84784688729451!3d6.903033472385038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259602cb3bc09%3A0x677419394138f674!2sThe%20Gallery%20Caf%C3%A9!5e0!3m2!1sen!2slk!4v1722435333796!5m2!1sen!2slk"
      width="450" height="300" style="border:0;" allowfullscreen="" loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"></iframe>
      
        <p>
          <strong>Address:</strong> No.293, Alfred Rd, Colombo 0300
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
  <?php include ("../components/footer.php"); ?>
</body>

</html>