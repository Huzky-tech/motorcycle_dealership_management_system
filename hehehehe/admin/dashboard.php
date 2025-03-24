<?php
include '../connect/connection.php'; // Ensure you have a proper database connection file

$conn = dbConnect();
// Fetch total sales from the 'payments' table
$query_sales = "SELECT SUM(amount) AS total_sales FROM payments";
$result_sales = mysqli_query($conn, $query_sales);
$row_sales = mysqli_fetch_assoc($result_sales);
$total_sales = number_format($row_sales['total_sales'] ?? 0, 2);

// Fetch total motorcycles
$query_motorcycles = "SELECT COUNT(*) AS total_motorcycles FROM motorcycles";
$result_motorcycles = mysqli_query($conn, $query_motorcycles);
$row_motorcycles = mysqli_fetch_assoc($result_motorcycles);
$total_motorcycles = $row_motorcycles['total_motorcycles'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealership Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #900; color: white; padding: 20px; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; }
        .sidebar h2 { font-size: 22px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .sidebar a { width: 100%; display: block; padding: 12px; background: black; color: white; border-radius: 5px; margin-bottom: 12px; text-decoration: none; font-size: 14px; transition: all 0.3s ease; }
        .sidebar a:hover { background: #c00; transform: scale(1.05); }
        .sidebar .active { background: #c00; }
        .header { background: #900; color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; position: fixed; top: 0; left: 250px; width: calc(100% - 250px); height: 60px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header a { color: white; text-decoration: none; font-size: 14px; padding: 8px 12px; background: black; border-radius: 5px; transition: 0.3s; }
        .header a:hover { background: #c00; }
        .main-content { margin-left: 250px; padding: 20px; width: calc(100% - 250px); margin-top: 60px; }
        .summary-container { display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap; }
        .summary-card { flex: 1; min-width: 200px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; border-left: 5px solid #2ca7ff; }
        .summary-card h3 { font-size: 14px; color: #666; margin: 0; }
        .summary-card p { font-size: 24px; font-weight: bold; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2><a href="dashboard.php">Dashboard</a></h2>
        <a href="dashboard.php?page=motorcycle" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'motorcycle') ? 'active' : ''; ?>">Motorcycle Inventory</a>
        <a href="dashboard.php?page=payment" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'payment') ? 'active' : ''; ?>">Payment</a>
        <a href="dashboard.php?page=reports" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'reports') ? 'active' : ''; ?>">Purchased Reports</a>
        <a href="dashboard.php?page=inquiry" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'inquiry') ? 'active' : ''; ?>">Inquiry Approval</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dealership Management System</h1>
            <a href="../index.php">Log out</a>
        </div>
        <p class="welcome-text">Welcome admin</p>

        <?php if (!isset($_GET['page'])): ?>
            <div class="summary-container">
                <div class="summary-card">
                    <h3>Total Sales</h3>
                    <p>$<?php echo $total_sales; ?></p>
                </div>
                <div class="summary-card">
                    <h3>Motorcycles Added</h3>
                    <p><?php echo $total_motorcycles; ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php 
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'motorcycle':
                    include 'motorcycle.php';
                    break;
                case 'payment':
                    include 'payment.php';
                    break;
                case 'reports':
                    include 'reports.php';
                    break;
                case 'inquiry':
                    include 'inquiry.php';
                    break;
                default:
                    echo "<p style='text-align:center; padding:20px;'>Page not found.</p>";
                    break;
            }
        }
        ?>
    </div>
</body>
</html>
