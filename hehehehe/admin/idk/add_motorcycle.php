<?php
include '../../connect/connection.php';

$conn = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST['model'];
    $srp = $_POST['srp'];
    $downpayment = $_POST['downpayment'];
    $monthly = $_POST['monthly'];
    $stock = $_POST['stock'];

    
    $image = $_FILES['image']['name'];
    $target_dir = "../../images/";
    $target_file = $target_dir . basename($image);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO motorcycles (model, srp, downpayment, monthly, stock, image) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdddis", $model, $srp, $downpayment, $monthly, $stock, $image);

        if ($stmt->execute()) {
            echo "<script>alert('Motorcycle added successfully!'); window.location.href='../dashboard.php';</script>";
        } else {
            echo "<script>alert('Error adding motorcycle.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error uploading image.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Motorcycle</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e3e3e3;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }
        button {
            background-color: #b30000;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #900;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add New Motorcycle</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="model" placeholder="Motorcycle Model" required>
            <input type="number" name="srp" placeholder="SRP (₱)" step="0.01" required>
            <input type="number" name="downpayment" placeholder="Downpayment (₱)" step="0.01" required>
            <input type="number" name="monthly" placeholder="Monthly Payment (₱)" step="0.01" required>
            <input type="number" name="stock" placeholder="Stock Available" required>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Add Motorcycle</button>
        </form>
    </div>

</body>
</html>
