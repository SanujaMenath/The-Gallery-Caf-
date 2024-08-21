<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us</title>
  <link rel="stylesheet" href="../Styles/header.css" />
  <link rel="stylesheet" href="../Styles/footer.css" />
  <link rel="stylesheet" href="../Styles/aboutUs.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
  <!-- header section -->
  <?php include("../components/header.php");?>

  <!-- About Section -->
  <div class="about-container">
    <h1>About Us</h1>
    <section class="mission">
      <h2>Our Mission</h2>
      <p>
        At The Gallery Café, our mission is to provide a warm, inviting
        atmosphere where customers can enjoy delicious food, great coffee, and
        artistic surroundings. We believe in the power of community and aim to
        create a space where everyone feels welcome.
      </p>
    </section>
    <hr>
    <div class="teams">
      <h2>Meet Our Team</h2>
    </div>
    
    <section class="team">
      <div class="team-member">
        <img src="../Assets/about/ceo.jpg" alt="Jane Doe" />
        <h3>Nimal Perera</h3>
        <p>Founder & CEO</p>
        <p>
          Jane is the visionary behind The Gallery Café. With a background in
          art and culinary arts, she has combined her passions to create a
          unique café experience.
        </p>
      </div>
      <div class="team-member">
        <img src="../Assets/about/chef.jpg" alt="John Smith" />
        <h3>Tharindu Fernando</h3>
        <p>Head Chef</p>
        <p>
          John is the culinary genius in our kitchen. His innovative dishes
          and commitment to using fresh, local ingredients make every meal
          unforgettable.
        </p>
      </div>
      <div class="team-member">
        <img src="../Assets/about/manager.jpg" alt="Sarah Brown" />
        <h3>Chathurika Jayasinghe</h3>
        <p>Manager</p>
        <p>
          Sarah ensures that everything runs smoothly at The Gallery Café.
          With her extensive experience in hospitality, she guarantees
          excellent service for every customer.
        </p>
      </div>
    </section>
    <h3>Privacy Policy</h3>
    <p>Your privacy is important to us. Read our full Privacy Policy to understand how we collect, use, and protect your personal information.</p>
    <a href="privacy_policy.php">Read our Privacy Policy</a>

    <h3>Terms and Conditions</h3>
    <p>Please read our Terms and Conditions carefully before using our services.</p>
    <a href="Terms_and_Conditions.html">Read our Terms and Conditions</a>
  </div>

  <!-- footer-section -->
  <?php include("../components/footer.php");?>
</body>

</html>
  