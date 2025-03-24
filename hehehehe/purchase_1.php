<?php 
include 'connect/connection.php';

$conn = dbConnect();
$sql = "SELECT i.id, i.customer_name, 
               IFNULL(m.model, i.model) AS model, 
               i.color, i.inquiry_details, i.purchase_date, 
               COALESCE(m.srp, 0) AS srp, 
               COALESCE(m.downpayment, 0) AS downpayment, 
               COALESCE(m.monthly, 0) AS monthly
        FROM inquiries i
        LEFT JOIN motorcycles m ON i.motorcycle_id = m.id
        WHERE i.status = 'approved'
        ORDER BY i.purchase_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_id'])) {
    $cancel_id = intval($_POST['cancel_id']); 

    $cancel_sql = "UPDATE inquiries SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($cancel_sql);

    if ($stmt) {
        $stmt->bind_param("i", $cancel_id);
        if ($stmt->execute()) {
            echo "<script>alert('Order cancelled successfully!'); window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Error cancelling order.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchased Inquiries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #b00000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        th {
            background: #b00000;
            color: white;
        }
        td {
            background: #fafafa;
        }
        .btn {
            background: #b00000;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background: #8a0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchased Inquiries</h1>
        <table>
            <tr>
                <th>Customer Name</th>
                <th>Model</th>
                <th>Color</th>
                <th>Inquiry Details</th>
                <th>Planned Purchase Date</th>
                <th>SRP</th>
                <th>Downpayment</th>
                <th>Monthly</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    

                    echo "<tr>
                            <td>" . htmlspecialchars($row['customer_name']) . "</td>
                            <td>" . htmlspecialchars($row['model']) . "</td>
                            <td>" . htmlspecialchars($row['color']) . "</td>
                            <td>" . htmlspecialchars($row['inquiry_details']) . "</td>
                            <td>" . htmlspecialchars($row['purchase_date']) . "</td>
                            <td>₱" . number_format($row["srp"], 2) . "</td>
                            <td>₱" . number_format($row["downpayment"], 2) . "</td>
                            <td>₱" . number_format($row["monthly"], 2) . "</td>
                            <td>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='cancel_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='btn' onclick=\"return confirm('Are you sure you want to cancel this order?');\">Cancel Order</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No purchased inquiries found.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
