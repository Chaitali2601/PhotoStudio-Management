<?php
include 'db.php';

$source = $_POST['source']; // booking or store
$id = $_POST['id']; // booking_id or store_order_id

$uploadDir = 'uploads/payments/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$filename = $_FILES['screenshot']['name'];
$tempname = $_FILES['screenshot']['tmp_name'];
$target = $uploadDir . time() . "_" . basename($filename);

if (move_uploaded_file($tempname, $target)) {
    $stmt = $conn->prepare("INSERT INTO payments (booking_id, store_order_id, amount, status, proof_image) VALUES (?, ?, ?, ?, ?)");
    
    $booking_id = $source === 'booking' ? $id : null;
    $store_id = $source === 'store' ? $id : null;
    $amount = 0; // You can calculate or pass this from previous page
    $status = "Pending";

    $stmt->bind_param("iiiss", $booking_id, $store_id, $amount, $status, $target);
    $stmt->execute();

    echo "<script>alert('Payment screenshot uploaded. Your order is being processed.'); window.location.href='dashboard.php';</script>";
} else {
    echo "<script>alert('Upload failed. Try again.'); history.back();</script>";
}
?>
