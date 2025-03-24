<?php
include 'connect/connection.php';

$conn = dbConnect();

$sql = "SELECT * FROM motorcycles"; 
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorcycle Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f8f8f8;
        }
        .hero {
            position: relative;
            text-align: center;
        }
        .hero img {
            width: 100%;
            height: 50vh;
            object-fit: cover;
        }
        .hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        .container {
            width: 90%;
            margin: 30px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            justify-content: center;
        }
        .card {
            background: white;
            padding: 15px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .card h3 {
            font-size: 18px;
            margin: 10px 0;
            color: black;
        }
        .card p {
            font-size: 14px;
            color: gray;
            margin-bottom: 5px;
        }
        .card .price {
            font-size: 16px;
            font-weight: bold;
            color: #c00;
        }
        .card .downpayment {
            font-size: 14px;
            font-weight: bold;
            color: #006400;
        }
        .stock {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background: #c00;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #900;
        }
        .out-of-stock {
            background: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="hero">
        <img src="images/g.jpg" alt="Motorcycle">
        <div class="hero-text">MOTORCYCLES</div>
    </div>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="images/'.$row["image"].'" alt="'.htmlspecialchars($row["model"]).'">';
                echo '<h3>'.htmlspecialchars($row["model"]).'</h3>';
                echo '<p>SRP: ₱'.number_format($row["srp"], 2).'</p>';
                echo '<p class="downpayment">Downpayment: ₱'.number_format($row["downpayment"], 2).'</p>';
                echo '<p class="price">Monthly: ₱'.number_format($row["monthly"], 2).'</p>';
                echo '<p class="stock">Stock: '.htmlspecialchars($row["stock"]).'</p>';

                if ($row["stock"] > 0) {
                    echo '<a href="inquery.php?id='.$row["id"].'" class="btn">Inquire</a>';
                } else {
                    echo '<button class="btn out-of-stock" disabled>Out of Stock</button>';
                }

                echo '</div>';
            }
        } else {
            echo "<p>No motorcycles found.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
