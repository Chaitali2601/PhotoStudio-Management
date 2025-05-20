<?php
include 'db.php';
session_start();

// Simulate logged in user (replace with login session check in future)
$user_email = 'demo@user.com';

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'] ?? 0;

$stmt = $conn->prepare("SELECT b.id AS booking_id, p.package_name, b.booking_date, b.booking_time, pay.amount, pay.status FROM bookings b 
    JOIN packages p ON b.package_id = p.id 
    LEFT JOIN payments pay ON pay.booking_id = b.id 
    WHERE b.user_id IS NULL OR b.user_id = ? ORDER BY b.booking_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Dashboard - PicPoint</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('images/photo.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #fff;
    }
    .main_box {
      display: flex;
    }
    .sidebar_menu {
      width: 250px;
      background: rgba(0, 0, 0, 0.9);
      color: white;
      height: 100vh;
      padding: 20px;
      position: fixed;
      top: 0;
      left: 0;
    }
    .sidebar_menu .logo a {
      font-size: 22px;
      color: white;
      text-decoration: none;
      display: block;
      margin-bottom: 30px;
    }
    .menu ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .menu ul li {
      margin: 20px 0;
      display: flex;
      align-items: center;
    }
    .menu ul li i {
      margin-right: 10px;
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
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .social_media ul a {
      color: #00acee;
      font-size: 18px;
      text-decoration: none;
    }
    .social_media ul a:hover {
      color: #00acee;
    }
    .content {
      flex: 1;
      margin-left: 270px;
      padding: 20px;
    }
    h2 {
      text-align: center;
      margin-top: 20px;
    }
    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background: rgba(0, 0, 0, 0.75);
      color: #fff;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: rgb(22, 105, 41);
    }
    tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.05);
    }
  </style>
</head>
<body>
  <div class="main_box">
    <div class="sidebar_menu">
      <div class="logo">
        <a href="#">PicPoint</a>
      </div>
      <div class="menu">
        <ul>
          <li><i class="fa-solid fa-person"></i> <a href="dashboard.php">Dashboard</a></li>
          <li><i class="fa-solid fa-image"></i><a href="gallery.html"> Gallery</a></li>
          <li><i class="fa-solid fa-photo-film"></i><a href="booking.php"> Booking</a></li>
          <li><i class="fa-solid fa-calendar-days"></i><a href="events.php"> Events</a></li>
          <li><i class="fa-solid fa-store"></i><a href="store.php"> Store</a></li>
          <li><i class="fa-solid fa-phone"></i><a href="contact.php"> Contact</a></li>
          <li><i class="fa-regular fa-comments"></i><a href="feedback.php"> Feedback</a></li>
          <li><i class="fa-solid fa-right-from-bracket"></i><a href="logout.php">Logout</a></li>
        </ul>
      </div>
      <div class="social_media">
        <ul>
          <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
        </ul>
      </div>
    </div>

    <div class="content">
      <h2>📅 My Bookings</h2>
      <table>
        <tr>
          <th>Booking ID</th>
          <th>Package</th>
          <th>Date</th>
          <th>Time</th>
          <th>Amount</th>
          <th>Payment Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td>#<?= $row['booking_id'] ?></td>
            <td><?= $row['package_name'] ?></td>
            <td><?= $row['booking_date'] ?></td>
            <td><?= $row['booking_time'] ?></td>
            <td>₹<?= number_format($row['amount'], 2) ?></td>
            <td><?= $row['status'] ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</body>
</html>
