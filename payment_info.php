<?php
session_start();
if (!isset($_SESSION['booking_data']) && !isset($_SESSION['store_data'])) {
    header("Location: index.php");
    exit;
}

$type = $_GET['type'] ?? 'booking';
$data = ($type === 'store') ? $_SESSION['store_data'] : $_SESSION['booking_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Make Payment - PicPoint</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('images/photo.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .payment-box {
      background: rgba(0, 0, 0, 0.85);
      padding: 30px;
      border-radius: 10px;
      width: 90%;
      max-width: 600px;
      text-align: center;
    }
    .payment-box h2 {
      margin-bottom: 20px;
    }
    .details {
      text-align: left;
      margin-bottom: 20px;
    }
    .qr {
      margin: 20px auto;
    }
    input[type="file"] {
      margin-top: 10px;
      padding: 5px;
    }
    button {
      background: #28a745;
      color: #fff;
      border: none;
      padding: 10px 20px;
      margin-top: 20px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="payment-box">
    <h2>Scan & Pay to Confirm <?= ucfirst($type) ?></h2>

    <div class="details">
      <p><strong>Name:</strong> <?= htmlspecialchars($data['name']) ?></p>
      <?php if ($type === 'booking'): ?>
        <p><strong>Package:</strong> <?= htmlspecialchars($data['package']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($data['booking_date']) ?> | 
           <strong>Time:</strong> <?= htmlspecialchars($data['booking_time']) ?></p>
      <?php else: ?>
        <p><strong>Product:</strong> <?= htmlspecialchars($data['product']) ?></p>
        <p><strong>Quantity:</strong> <?= htmlspecialchars($data['quantity']) ?></p>
        <p><strong>Total Price:</strong> ₹<?= number_format($data['price'], 2) ?></p>
      <?php endif; ?>
    </div>

    <div class="qr">
      <img src="images/qr.jpg" alt="QR Code" width="200">
      <p>UPI: <strong>bisen.chaitali@ybl</strong></p>
    </div>

    <form action="payment_upload.php" method="POST" enctype="multipart/form-data">
      <label>Upload Payment Screenshot:</label><br>
      <input type="file" name="screenshot" accept="image/*" required>
      <input type="hidden" name="type" value="<?= $type ?>">
      <button type="submit">Upload & Confirm</button>
    </form>
  </div>
</body>
</html>
