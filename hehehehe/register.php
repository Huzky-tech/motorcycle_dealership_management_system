<?php
include 'connect/connection.php';

function register() {
    $conn = dbConnect();

    // Get input data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare SQL for 'accounts' table
    $sql_accounts = "INSERT INTO accounts (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_accounts);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $account_id = $conn->insert_id;

        // Prepare SQL for 'users' table
        $sql_users = "INSERT INTO users (username, email, account_id) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql_users);
        $stmt2->bind_param("ssi", $username, $email, $account_id);

        if ($stmt2->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center fw-bold' role='alert'>
                    Error in Users Table: " . $conn->error . "
                  </div>";
        }
        $stmt2->close();
    } else {
        echo "<div class='alert alert-danger text-center fw-bold' role='alert'>
                Error in Accounts Table: " . $conn->error . "
              </div>";
    }
    $stmt->close();
    $conn->close();
}

if (isset($_POST['register'])) {
    register();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #ffffff;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 850px;
            height: 500px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .left {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right {
            flex: 1;
            background: url('images/k.jpg') center no-repeat;
            background-size: cover;
            height: 100%;
        }

        h2 {
            font-size: 28px;
            color: #000;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background: #c00;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #900;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #000;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left">
            <h2>Register</h2>
            <form action="register.php" method="POST">
                <label>Username</label>
                <input type="text" name="username" required>

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn" name="register">Register</button>
            </form>
            <a href="index.php">Already have an account? Log in</a>
        </div>
        <div class="right"></div>
    </div>

</body>
</html>
