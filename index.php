<?php
session_start();
include 'db.php'; // Ensure this file connects to your DB

$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';

    if (!empty($name)) {
        // Registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Successfully registered";
        } else {
            $_SESSION['error'] = "Registration failed. Email may already be in use.";
        }
        header("Location: index.php");
        exit();
    } else {
        // Login
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['success'] = "Successfully logged in";
                header("Location: gallery.html");
                exit();
            } else {
                $_SESSION['error'] = "Invalid password";
            }
        } else {
            $_SESSION['error'] = "User not found";
        }
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - PicPoint</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: "Arial", sans-serif;
      background: url('images/photo.jpg') no-repeat center center fixed;
      background-size: cover;
      padding: 0;
      margin: 0;
    }
    .main_box {
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
      display: block;
      margin-bottom: 20px;
      font-weight: bold;
    }
    .menu ul {
      list-style: none;
      padding: 0;
    }
    .menu ul li {
      margin: 20px 0;
    }
    .menu ul li a {
      color: white;
      text-decoration: none;
      font-size: 16px;
    }
    .menu ul li i {
      margin-right: 10px;
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
    .auth-container {
      width: 350px;
      margin: 100px auto;
      background: rgba(0, 0, 0, 0.6);
      padding: 20px;
      border-radius: 10px;
      color: white;
      position: center;
      left: 600px;
    }
    .auth-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .auth-container .toggle-btn {
      text-align: center;
      cursor: pointer;
      color: #00acee;
      margin-top: 10px;
    }
    .auth-container .toggle-btn:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php if (!empty($successMessage)): ?>
    <script>alert("<?= $successMessage ?>");</script>
  <?php endif; ?>
  <?php if (!empty($errorMessage)): ?>
    <script>alert("<?= $errorMessage ?>");</script>
  <?php endif; ?>

  <div class="main_box">
    <div class="sidebar_menu">
      <div class="logo">
        <a href="#">PicPoint</a>
      </div>
      <div class="menu">
        <ul>
          <li><i class="fa-solid fa-person"></i> <a href="dashboard.php">Dashboard</a></li>
          <li><i class="fa-solid fa-image"></i> <a href="gallery.html">Gallery</a></li>
          <li><i class="fa-solid fa-photo-film"></i> <a href="booking.php">Booking</a></li>
          <li><i class="fa-solid fa-calendar-days"></i> <a href="events.php">Events</a></li>
          <li><i class="fa-solid fa-store"></i> <a href="store.php">Store</a></li>
          <li><i class="fa-solid fa-phone"></i> <a href="contact.php">Contact</a></li>
          <li><i class="fa-regular fa-comments"></i> <a href="feedback.php">Feedback</a></li>
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

    <div class="auth-container">
      <h2 id="form-title">Login</h2>
      <form id="auth-form" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <div class="mb-3" id="nameField" style="display: none;">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" />
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </form>
      <p class="toggle-btn" onclick="toggleForm()">New user? Register here</p>
    </div>
  </div>

  <script>
    let isRegister = false;
    function toggleForm() {
      isRegister = !isRegister;
      document.getElementById("form-title").innerText = isRegister ? "Register" : "Login";
      document.getElementById("nameField").style.display = isRegister ? "block" : "none";
      document.querySelector(".toggle-btn").innerText = isRegister
        ? "Already have an account? Login here"
        : "New user? Register here";
    }
  </script>
</body>
</html>
