<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>PicPoint Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background: url('images/photo.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
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

        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: 100%;
        }

        .product {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }

        .product h3 {
            margin-top: 0;
        }

        .product img {
            max-width: 150px;
            display: block;
            margin-bottom: 10px;
        }

        h1 {
            color:rgb(247, 249, 248);
        }

        button {
            padding: 10px 20px;
            background-color: #00aa66;
            color: white;
            border: none;
            border-radius: 5px;
        }

        input[type="text"] {
            width: 80px;
            text-align: center;
        }
    </style>

    <script>
        function updatePhotoInputs(product) {
            const qty = parseInt(document.getElementById(product + "_qty").value);
            const container = document.getElementById(product + "_photos");
            container.innerHTML = "";

            for (let i = 0; i < qty; i++) {
                const input = document.createElement("input");
                input.type = "file";
                input.name = product + "_photo_" + (i + 1);
                input.accept = "image/*";
                input.required = true;
                container.appendChild(document.createTextNode("Upload Photo " + (i + 1) + ": "));
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
            }
        }

        function calculateTotal() {
            let total = 0;

            total += document.getElementById("cup_qty").value * 200;

            const frameQty = parseInt(document.getElementById("frame_qty").value);
            const frameSize = document.getElementById("frame_size").value;
            let framePrice = 0;
            if (frameSize === "Small") framePrice = 400;
            else if (frameSize === "Medium") framePrice = 550;
            else if (frameSize === "Large") framePrice = 750;
            total += frameQty * framePrice;

            total += document.getElementById("tshirt_qty").value * 350;
            total += document.getElementById("polaroid_qty").value * 80;

            document.getElementById("total").value = total;
        }
    </script>
</head>
<body>

<!-- Sidebar -->
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

<!-- Main content -->
<div class="main-content">
    <h1>PicPoint Store</h1>
    <form action="payment_info.php" method="post" enctype="multipart/form-data" onsubmit="calculateTotal()">

        <!-- Cups / Mugs -->
        <div class="product">
            <h3>Cups / Mugs with Photo Print (₹200 each)</h3>
            <img src="images/s1.webp" alt="Mug Sample">
            Quantity:
            <select name="cup_qty" id="cup_qty" onchange="updatePhotoInputs('cup'); calculateTotal();">
                <option value="0">0</option>
                <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
            <div id="cup_photos"></div>
        </div>

        <!-- Photo Frames -->
        <div class="product">
            <h3>Photo Frames</h3>
            <img src="images/s3.jpg" alt="Frame Sample">
            Quantity:
            <select name="frame_qty" id="frame_qty" onchange="updatePhotoInputs('frame'); calculateTotal();">
                <option value="0">0</option>
                <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
            <br>
            Size:
            <select name="frame_size" id="frame_size" onchange="calculateTotal()">
                <option value="Small">Small (₹400)</option>
                <option value="Medium">Medium (₹550)</option>
                <option value="Large">Large (₹750)</option>
            </select>
            <div id="frame_photos"></div>
        </div>

        <!-- T-Shirts -->
        <div class="product">
            <h3>T-Shirts with Photo Print (₹350 each)</h3>
            <img src="images/s2.webp" alt="T-Shirt Sample">
            Quantity:
            <select name="tshirt_qty" id="tshirt_qty" onchange="updatePhotoInputs('tshirt'); calculateTotal();">
                <option value="0">0</option>
                <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
            <br>
            Size:
            <select name="tshirt_size">
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select>
            <div id="tshirt_photos"></div>
        </div>

        <!-- Polaroids -->
        <div class="product">
            <h3>Polaroids (₹80 each)</h3>
            <img src="images/s4.jpeg" alt="Polaroid Sample">
            Quantity:
            <select name="polaroid_qty" id="polaroid_qty" onchange="updatePhotoInputs('polaroid'); calculateTotal();">
                <option value="0">0</option>
                <?php for ($i = 1; $i <= 10; $i++) echo "<option value='$i'>$i</option>"; ?>
            </select>
            <div id="polaroid_photos"></div>
        </div>

        <h3>Total Amount: ₹ <input type="text" name="total" id="total" readonly></h3>
        <button type="submit">Proceed to Payment</button>

    </form>
</div>

</body>
</html>
