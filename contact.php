<?php
include 'db.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $msg = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $msg);
    if ($stmt->execute()) {
        $message = "Thank you for contacting us! We will get back to you soon.";
    } else {
        $message = "Something went wrong. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - PicPoint</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      background: url('images/photo.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: "Arial", sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
    }

    .sidebar_menu {
      width: 250px;
      background: rgba(0,0,0,0.9);
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      padding: 20px;
    }

    .sidebar_menu .logo a {
      font-size: 22px;
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    .menu ul {
      list-style-type: none;
      padding: 0;
      margin-top: 30px;
    }

    .menu ul li {
      margin: 20px 0;
    }

    .menu ul li a {
      color: white;
      text-decoration: none;
      font-size: 16px;
    }

    .menu ul li a:hover {
      color: #00acee;
    }

    .social_media {
      position: absolute;
      bottom: 20px;
      left: 20px;
    }

    .social_media ul {
      display: flex;
      gap: 10px;
    }

    .social_media ul a {
      color: #00acee;
      font-size: 18px;
      text-decoration: none;
    }

    .social_media ul a:hover {
      color: #00acee;
    }

    .contact-box {
      max-width: 600px;
      margin: 60px auto;
      background: rgba(0,0,0,0.85);
      padding: 30px;
      border-radius: 10px;
      color: white;
      flex: 1;
      margin-left: 600px;
    }

    .contact-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="sidebar_menu">
    <div class="logo">
      <a href="#">PicPoint</a>
    </div>
    <div class="menu">
      <ul>
        <li><i class="fa-solid fa-person"></i> <a href="dashboard.php">Dashboard</a></li>
        <li><i class="fa-solid fa-image"></i><a href="gallery.html">Gallery</a></li>
        <li><i class="fa-solid fa-photo-film"></i><a href="booking.php">Booking</a></li>
        <li><i class="fa-solid fa-calendar-days"></i><a href="events.php">Events</a></li>
        <li><i class="fa-solid fa-store"></i><a href="store.php">Store</a></li>
        <li><i class="fa-solid fa-phone"></i><a href="contact.php">Contact</a></li>
        <li><i class="fa-regular fa-comments"></i><a href="feedback.php">Feedback</a></li>
        <li><i class="fa-solid fa-right-from-bracket"></i><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <div class="social_media">
      <ul>
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-youtube"></i></a>
      </ul>
    </div>
  </div>

  <div class="contact-box">
    <h2>Contact Us</h2>
    <?php if ($message): ?>
      <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
      <label>Name</label>
      <input type="text" name="name" class="form-control" required>
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
      <label>Subject</label>
      <input type="text" name="subject" class="form-control" required>
      <label>Message</label>
      <textarea name="message" class="form-control" rows="4" required></textarea>
      <button type="submit" class="btn btn-success mt-3 w-100">Send Message</button>
    </form>
  </div>
</body>
</html>
