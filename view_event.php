<?php
// Get package data from URL
$packageTitle = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : 'Custom Package';
$packageImage = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : 'images/default.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $packageTitle ?> - PicPoint</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('images/photo.jpg') no-repeat center center fixed;
      background-size: cover;
      color: white;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 800px;
      margin: 50px auto;
      background: rgba(0, 0, 0, 0.85);
      padding: 30px;
      border-radius: 10px;
    }
    h2 {
      text-align: center;
      margin-bottom: 10px;
    }
    .package-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin: 15px 0 5px;
    }
    select, input[type=checkbox] {
      margin-bottom: 10px;
    }
    .price-display {
      font-size: 20px;
      margin: 20px 0;
      text-align: center;
    }
    .btn {
      display: block;
      width: 100%;
      padding: 12px;
      background-color: #00aaff;
      color: white;
      border: none;
      border-radius: 5px;
      text-align: center;
      cursor: pointer;
      font-size: 16px;
      text-decoration: none;
    }
    .btn:hover {
      background-color: #008ecc;
    }
  </style>
</head>
<body>
<div class="container">
  <h2><?= $packageTitle ?></h2>
  <img src="<?= $packageImage ?>" alt="Package Image" class="package-image">

  <form id="packageForm">
    <label for="days">Select Duration:</label>
    <select id="days" name="days" onchange="calculatePrice()">
      <option value="1">1 Day</option>
      <option value="2">2 Days</option>
      <option value="3">3 Days</option>
      <option value="4">4 Days</option>
      <option value="5">5 Days</option>
    </select>

    <label>Choose Services:</label>
    <input type="checkbox" id="photo" name="service" value="Photographer" onchange="calculatePrice()"> Photographer<br>
    <input type="checkbox" id="video" name="service" value="Videographer" onchange="calculatePrice()"> Videographer<br>
    <input type="checkbox" id="drone" name="service" value="Drone" onchange="calculatePrice()"> Drone<br>

    <div class="price-display">
      Total Price: ₹<span id="totalPrice">0</span>
    </div>

    <!-- Redirect with package name only -->
    <a href="booking.php?package=<?= urlencode($packageTitle) ?>" class="btn">Book Now</a>
  </form>
</div>

<script>
  const basePrices = {
    photo: 6000,
    video: 9000,
    drone: 5000
  };

  function calculatePrice() {
    let days = parseInt(document.getElementById("days").value);
    let price = 0;

    if (document.getElementById("photo").checked) price += basePrices.photo * days;
    if (document.getElementById("video").checked) price += basePrices.video * days;
    if (document.getElementById("drone").checked) price += basePrices.drone * days;

    document.getElementById("totalPrice").innerText = price;
  }

  window.onload = calculatePrice;
</script>
</body>
</html>
