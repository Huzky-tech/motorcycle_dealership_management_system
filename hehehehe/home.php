<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Dealership</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: rgb(255, 255, 255);
            color: black;
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #c00;
            padding: 15px 30px;
        }

        .nav-links {
            list-style: none;
            display: flex;
        }

        .nav-links li {
            margin: 0 15px;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            background: #c00;
            border-radius: 5px;
            transition: background 0.3s;
            display: inline-block;
        }

        .nav-links a:hover {
            background: #900;
        }

        .nav-links .active {
            font-weight: bold;
            background: #900;
        }

        .search-logout {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box {
            padding: 7px;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .logout-btn {
            background: black;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #900;
        }

        /* Hero Section */
        .hero {
            position: relative;
            text-align: center;
            color: white;
        }

        .hero img {
            width: 100%;
            height: 90vh;
            object-fit: cover;
        }

        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .hero-text h1 {
            font-size: 48px;
            font-weight: bold;
        }

        .hero-text .btn {
            display: inline-block;
            background: #c00;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .hero-text .btn:hover {
            background: #900;
        }

        /* Latest Arrival Section */
        .latest-arrival {
            text-align: center;
            margin: 40px 0;
            color: black;
            background: white;
            padding: 20px;
        }

        .latest-arrival h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .bike-gallery {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .bike-gallery img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <div class="navbar">
        <ul class="nav-links">
            <li><a href="home.php" class="<?php echo (!isset($_GET['page'])) ? 'active' : ''; ?>">Home</a></li>
            <li><a href="home.php?page=motorcycle_1" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'motorcycle_1') ? 'active' : ''; ?>">Motorcycle</a></li>
            <li><a href="home.php?page=purchase_1" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'purchase_1') ? 'active' : ''; ?>">Purchase</a></li>
        </ul>
        <div class="search-logout">
            <input type="text" class="search-box" placeholder="Search...">
            <button class="logout-btn" onclick="window.location.href='index.php'">Logout</button>
        </div>
    </div>

    <div class="content">
        <?php 
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'purchase_1':
                    include 'purchase_1.php';
                    break;
                case 'motorcycle_1':
                    include 'motorcycle_1.php';
                    break;
                default:
                    echo "<p style='text-align:center; padding:20px;'>Page not found.</p>";
                    break;
            }
        } else {
            ?>
            <div class="hero">
                <img src="images/g.jpg" alt="Ducati Motorcycle">
                <div class="hero-text">
                    <h1>DUCATI'S MOTOR DEALERSHIP</h1>
                    <a href="home.php?page=motorcycle_1" class="btn">EXPLORE</a>
                </div>
            </div>

            <div class="latest-arrival">
                <h2>---- Latest Arrival ----</h2>
                <div class="bike-gallery">
                    <img src="images/ww.jpg" alt="New Ducati Model">
                    <img src="images/lll.jpg" alt="Latest Ducati">
                </div>
            </div>
            <?php
        }
        ?>
    </div>

</body>
</html>
