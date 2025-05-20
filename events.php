<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PicPoint Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/photo.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
        }
        .main_box {
            display: flex;
        }
        .sidebar_menu {
            width: 250px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            height: 100vh;
            padding: 20px;
        }
        .sidebar_menu .logo a {
            font-size: 22px;
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 20px;
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

        .content {
            flex: 1;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }
        .event-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .event-card {
            background: beige;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(250, 241, 241, 0.92);
            text-align: center;
            transition: transform 0.3s ease;
            color: #333;
        }
        .event-card:hover {
            transform: scale(1.02);
        }
        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .event-card h3 {
            margin: 15px 0 5px;
        }
        .event-card a {
            display: inline-block;
            margin: 15px;
            padding: 10px 20px;
            background: #333;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }
        .event-card a:hover {
            background: #555;
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
                <li><i class="fa-solid fa-image"></i> <a href="gallery.html">Gallery</a></li>
                <li><i class="fa-solid fa-photo-film"></i> <a href="booking.php">Booking</a></li>
                <li><i class="fa-solid fa-calendar-days"></i> <a href="events.php">Events</a></li>
                <li><i class="fa-solid fa-store"></i> <a href="store.php">Store</a></li>
                <li><i class="fa-solid fa-phone"></i> <a href="contact.php">Contact</a></li>
                <li><i class="fa-regular fa-comments"></i> <a href="feedback.php">Feedback</a></li>
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

    <div class="content">
        <h1>📸 Explore Our Events</h1>
        <div class="event-container">
            <div class="event-card">
                <img src="images/e1.jpg" alt="Wedding">
                <h3>Wedding Shoots</h3>
                <a href="view_event.php?title=Wedding Shoots&image=images/e1.jpg">View Wedding Shoots</a>
            </div>
            <div class="event-card">
                <img src="images/e2.jpg" alt="Birthday">
                <h3>Birthday Shoots</h3>
                <a href="view_event.php?title=Birthday Shoots&image=images/e2.jpg">View Birthday Shoots</a>
            </div>
            <div class="event-card">
                <img src="images/e3.jpg" alt="Portrait">
                <h3>Studio Portraits</h3>
                <a href="view_event.php?title=Studio Portraits&image=images/e3.jpg">View Studio Portraits</a>
            </div>
            <div class="event-card">
                <img src="images/e4.jpg" alt="Model">
                <h3>Model Shoots</h3>
                <a href="view_event.php?title=Model Shoots&image=images/e4.jpg">View Model Shoots</a>
            </div>
            <div class="event-card">
                <img src="images/e5.jpg" alt="Festive">
                <h3>Festive Shoots</h3>
                <a href="view_event.php?title=Festive Shoots&image=images/e5.jpg">View Festive Shoots </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
