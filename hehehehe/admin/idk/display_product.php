<?php
include_once '../connect/connection.php';
$conn = dbConnect();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Determine status based on action
    if ($action == 'approve') {
        $status = 'approved';

        // Update status in the inquiries table
        $sql = "UPDATE inquiries SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute()) {
            // Fetch the approved inquiry data
            $query = "SELECT * FROM inquiries WHERE id = ?";
            $stmt2 = $conn->prepare($query);
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $result = $stmt2->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Insert the data into purchased_report
                $insertQuery = "INSERT INTO purchased_report (customer_name, model, inquiry_details, purchase_date, status) VALUES (?, ?, ?, ?, ?)";
                $stmt3 = $conn->prepare($insertQuery);
                $stmt3->bind_param("sssss", $row['customer_name'], $row['model'], $row['inquiry_details'], $row['purchase_date'], $status);

                if ($stmt3->execute()) {
                    echo "<script>alert('Inquiry approved and added to Purchased Report successfully!'); window.location.href='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error adding to Purchased Report.');</script>";
                }

                $stmt3->close();
            }
            $stmt2->close();
        } else {
            echo "<script>alert('Error updating inquiry status.');</script>";
        }

        $stmt->close();
    } elseif ($action == 'reject') {
        $status = 'rejected';
        
        $sql = "UPDATE inquiries SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Inquiry has been rejected successfully!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating inquiry status.');</script>";
        }

        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorcycle Inquiry Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }
        h2 {
            color: #b30000;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input, select, textarea {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Motorcycle Inquiry</h2>
    <form action="process_inquiry.php" method="post">
        
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name">

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="model">Motorcycle Model:</label>
        <select id="model" name="model" required>
            <option value="">Select a model</option>
            <?php while ($row = $model_result->fetch_assoc()) { ?>
                <option value="<?php echo htmlspecialchars($row['model']); ?>">
                    <?php echo htmlspecialchars($row['model']); ?> (Stock: <?php echo $row['stock']; ?>)
                </option>
            <?php } ?>
        </select>

        <label for="color">Preferred Color:</label>
        <input type="text" id="color" name="color" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" required>

        <label for="inquiry_details">Inquiry Details:</label>
        <textarea id="inquiry_details" name="inquiry_details" rows="4" required></textarea>

        <label for="purchase_date">Planned Purchase Date:</label>
        <input type="date" id="purchase_date" name="purchase_date" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="mobile" required>

        <button type="submit">Submit Inquiry</button>
    </form>
</div>

</body>
</html>

