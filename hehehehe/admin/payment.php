<?php
include_once '../connect/connection.php';
$conn = dbConnect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
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
            background-color:#b30000;
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
        .details a {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment History</h2>
        <a href="idk/add_payment.php" class="button">Add New Payment</a>

        <table>
            <tr>
                <th>Payment ID</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
          
            $conn = new mysqli("localhost", "root", "", "motor_db");

          
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

          
            $sql = "SELECT * FROM payments";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['payment_id']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>\${$row['amount']}</td>
                        <td>{$row['payment_date']}</td>
                        <td>{$row['status']}</td>
                        <td class='details'>
                            <a href='update_payment.php?id={$row['payment_id']}' class='edit'>Update</a>
                            <a href='delete_payment.php?id={$row['payment_id']}' class='delete' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No payment records found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
