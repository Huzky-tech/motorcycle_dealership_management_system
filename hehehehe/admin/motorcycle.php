<?php
include_once '../connect/connection.php';
$conn = dbConnect();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorcycle Inventory</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e3e3e3;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: #b30000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 5px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #b30000;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions a {
            padding: 6px 12px;
            margin: 0 5px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .edit {
            background-color: #28a745;
        }
        .delete {
            background-color: #dc3545;
        }
        img {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Motorcycle Inventory</h2>
        <a href="idk/add_motorcycle.php" class="button">Add New Motorcycle</a>

        <table>
            <tr>
                <th>ID</th>
                <th>Model</th>
                <th>SRP</th>
                <th>Downpayment</th>
                <th>Monthly</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>

            <?php
            $conn = new mysqli("localhost", "root", "", "motor_db");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, model, srp, downpayment, monthly, stock, image FROM motorcycles";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['model']) . "</td>
                        <td>₱" . number_format($row['srp'], 2) . "</td>
                        <td>₱" . number_format($row['downpayment'], 2) . "</td>
                        <td>₱" . number_format($row['monthly'], 2) . "</td>
                        <td>" . htmlspecialchars($row['stock']) . "</td>
                        <td><img src='../images/" . htmlspecialchars($row['image']) . "' alt='Motorcycle'></td>
                        <td class='actions'>
                            <a href='edit_motorcycle.php?id=" . htmlspecialchars($row['id']) . "' class='edit'>Update</a>
                            <a href='delete_motorcycle.php?id=" . htmlspecialchars($row['id']) . "' class='delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No motorcycles available</td></tr>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </table>
    </div>

</body>
</html>
