<?php 
include 'connect/connection.php'; 

$conn = dbConnect();

// Fetch available motorcycle models
$model_query = "SELECT model FROM motorcycles";
$model_result = $conn->query($model_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST['model'];
    $color = $_POST['color'];
    $inquiry_details = $_POST['inquiry_details'];
    $purchase_date = $_POST['purchase_date'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $quantity = $_POST['quantity'];

    $customer_name = trim("$first_name $middle_name $last_name");

    // Fetch motorcycle_id based on model
    $motorcycle_query = "SELECT id, stock FROM motorcycles WHERE model = ?";
    $stmt = $conn->prepare($motorcycle_query);
    $stmt->bind_param("s", $model);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo "<script>alert('Invalid motorcycle model selected.'); window.history.back();</script>";
        exit();
    }

    $motorcycle_row = $result->fetch_assoc();
    $motorcycle_id = $motorcycle_row['id'];
    $current_stock = $motorcycle_row['stock'];

    if ($current_stock >= $quantity) {
        // Insert inquiry using motorcycle_id
        $sql = "INSERT INTO inquiries (customer_name, motorcycle_id, model, color, inquiry_details, purchase_date, address, email, mobile, quantity)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($sql);
        $insert_stmt->bind_param("sisssssssi", $customer_name, $motorcycle_id, $model, $color, $inquiry_details, $purchase_date, $address, $email, $mobile, $quantity);

        if ($insert_stmt->execute()) {
            // Update stock
            $new_stock = $current_stock - $quantity;
            $update_sql = "UPDATE motorcycles SET stock = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ii", $new_stock, $motorcycle_id);
            $update_stmt->execute();

            echo "<script>alert('Purchase successful! Stock updated.'); window.location.href='home.php';</script>";
        } else {
            echo "Error: " . $insert_stmt->error;
        }

        $insert_stmt->close();
        $update_stmt->close();
    } else {
        echo "<script>alert('Not enough stock available.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #fff;
        }
        .header {
            background: #b00000;
            color: white;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .back-btn {
            background: white;
            color: #b00000;
            padding: 8px 12px;
            border: 1px solid #b00000;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .back-btn:hover {
            background: #b00000;
            color: white;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background: #b00000;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .btn:hover {
            background: #8a0000;
        }
        .section-title {
            color: #b00000;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .form-row {
            display: flex;
            gap: 10px;
        }
        .form-row input {
            flex: 1;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            Inquiry Form
            <a href="home.php" class="back-btn">Back</a>
        </div>

        <form method="POST" action="">
            <label>Model</label>
            <select name="model" required>
                <option value="">Choose</option>
                <?php
                if ($model_result->num_rows > 0) {
                    while ($row = $model_result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['model']) . "'>" . htmlspecialchars($row['model']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No models available</option>";
                }
                ?>
            </select>

            <label>Color</label>
            <select name="color" required>
                <option>Choose</option>
                <option>Black</option>
                <option>Red</option>
                <option>White</option>
            </select>

            <label>Inquiry Details</label>
            <input type="text" name="inquiry_details" placeholder="Value" required>

            <label>Planned Date to Purchase</label>
            <input type="date" name="purchase_date" required>

            <!-- Add Quantity Field -->
            <label>Quantity</label>
            <input type="number" name="quantity" min="1" required>

            <!-- Customer Information -->
            <p class="section-title">Customer Information</p>

            <div class="form-row">
                <input type="text" name="first_name" placeholder="First Name*" required>
                <input type="text" name="middle_name" placeholder="Middle Name">
                <input type="text" name="last_name" placeholder="Last Name*" required>
            </div>

            <label>Address (Unit no. / Building / Street)</label>
            <input type="text" name="address" placeholder="Address" required>

            <div class="form-row">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="text" name="mobile" placeholder="Mobile Number" required>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Submit</button>
        </form>
    </div>

</body>
</html>