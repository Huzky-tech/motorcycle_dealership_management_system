<?php 
include '../../connect/connection.php';
$conn = dbConnect();
// Fetch customer names and purchase report IDs from purchased_report table
$customers = [];
$query = "SELECT DISTINCT customer_name, id FROM purchased_report"; // Fetch both customer_name and id
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $customers[] = $row;
}

// Handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_payment'])) {
    $customer_name = $_POST['customer_name'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $status = $_POST['status'];

    // Fetch the purchase report ID for the selected customer
    $report_query = "SELECT id FROM purchased_report WHERE customer_name = '$customer_name' LIMIT 1";
    $report_result = mysqli_query($conn, $report_query);
    $report_row = mysqli_fetch_assoc($report_result);
    $purchase_report_id = $report_row['id'] ?? null;

    if ($purchase_report_id) {
        // Insert the payment into the payments table
        $sql = "INSERT INTO payments (customer_name, amount, payment_date, status, purchase_report_id) 
                VALUES ('$customer_name', '$amount', '$payment_date', '$status', '$purchase_report_id')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Payment added successfully'); window.location.href='../dashboard.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Error: No purchase report found for this customer.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e3e3e3;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        select, input {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            margin-top: 15px;
            background-color: #b30000;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #900;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Payment</h2>
        <form method="POST">
            <label for="customer_name">Customer Name:</label>
            <select id="customer_name" name="customer_name" required>
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['customer_name']; ?>">
                        <?= $customer['customer_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" step="0.01" required>

            <label for="payment_date">Payment Date:</label>
            <input type="date" id="payment_date" name="payment_date" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>

            <button type="submit" name="submit_payment" class="button">Submit Payment</button>
        </form>
    </div>
</body>
</html>