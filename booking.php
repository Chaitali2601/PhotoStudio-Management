<?php
include 'db.php';
session_start();

$success = "";
$error = "";

// Pre-select package if passed via URL
$preselected_package = isset($_GET['package']) ? $_GET['package'] : '';

// Fetch packages
$packages = [];
$result = $conn->query("SELECT package_name FROM packages");
while ($row = $result->fetch_assoc()) {
    $packages[] = $row['package_name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $booking_date = $_POST['booking_date'];
    $booking_time = $_POST['booking_time'];
    $package = ($_POST['package'] === 'Other') ? trim($_POST['other_package']) : $_POST['package'];

    // Store booking data in session
    $_SESSION['booking_data'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'booking_date' => $booking_date,
        'booking_time' => $booking_time,
        'package' => $package
    ];

    // Redirect to payment page
    header("Location: payment_info.php?type=booking");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Your Event - PicPoint</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      font-family: Arial, sans-serif;
      background: url('images/photo.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    .sidebar_menu {
      width: 250px;
      background: rgba(0,0,0,0.9);
      height: 100vh;
      padding: 20px;
      box-sizing: border-box;
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
      color: white;
      font-size: 18px;
      text-decoration: none;
    }

    .social_media ul a:hover {
      color: #00acee;
    }

    .main_content {
      flex: 1;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-box {
      background: rgba(0,0,0,0.85);
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 600px;
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-box form input,
    .form-box form select,
    .form-box form button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
    }

    .form-box form input,
    .form-box form select {
      background: #f2f2f2;
      color: #000;
    }

    .form-box form button {
      background:rgb(22, 105, 41);
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }

    .form-box .message {
      margin-top: 10px;
      padding: 10px;
      background-color: #28a745;
      color: #fff;
      border-radius: 5px;
      text-align: center;
    }

    .form-box .message.error {
      background-color: #dc3545;
    }

    #otherInput {
      display: none;
    }

    .package-select-link {
      text-align: center;
      margin: 15px 0;
    }

    .package-select-link a {
      display: inline-block;
      padding: 10px;
      background: #00acee;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .package-select-link a:hover {
      background: #008ecf;
    }
  </style>
  <script>
    function toggleOtherInput(value) {
      const otherField = document.getElementById('otherInput');
      otherField.style.display = (value === 'Other') ? 'block' : 'none';
    }
  </script>
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
      <a href="#"><i class="fa-brands fa-facebook"></i></a>
      <a href="#"><i class="fa-brands fa-twitter"></i></a>
      <a href="#"><i class="fa-brands fa-instagram"></i></a>
      <a href="#"><i class="fa-brands fa-youtube"></i></a>
    </div>
  </div>

  <div class="main_content">
    <div class="form-box">
      <h2>Book Your Photo Session</h2>

      <?php if ($success): ?>
        <div class="message"><?= $success ?></div>
      <?php elseif ($error): ?>
        <div class="message error"><?= $error ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <input type="text" name="name" placeholder="Your Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="tel" name="phone" placeholder="Phone Number" required pattern="[0-9]{10}">
        <input type="date" name="booking_date" required>
        <input type="time" name="booking_time" required>

        <?php if (!empty($preselected_package)): ?>
          <label>Selected Package: <strong><?= htmlspecialchars($preselected_package) ?></strong></label>
          <input type="hidden" name="package" value="<?= htmlspecialchars($preselected_package) ?>">
        <?php else: ?>
          <div class="package-select-link">
            <a href="events.php">Select a Package from Events Page</a>
          </div>
        <?php endif; ?>

        <input type="text" name="other_package" id="otherInput" placeholder="Enter your custom package">

        <button type="submit">Confirm Booking</button>
      </form>
    </div>
  </div>
</body>
</html>
