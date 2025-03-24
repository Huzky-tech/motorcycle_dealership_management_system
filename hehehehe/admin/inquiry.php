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
    <title>Admin Inquiry Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f8f8;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #b30000;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .view {
            background-color: blue;
            color: white;
        }
        .accept {
            background-color: green;
            color: white;
        }
        .reject {
            background-color: red;
            color: white;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Customer Inquiries</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Model</th>
                <th>Inquiry Details</th>
                <th>Planned Purchase Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT * FROM inquiries";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['inquiry_details']}</td>
                        <td>{$row['purchase_date']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <a href='inquiry.php?id={$row['id']}' class='btn view'>View</a>
                            <a href='inquiry.php?action=approve&id={$row['id']}' class='btn accept'>Approve</a>
                            <a href='inquiry.php?action=reject&id={$row['id']}' class='btn reject' onclick=\"return confirm('Are you sure you want to reject this inquiry?')\">Reject</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No inquiries found</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
