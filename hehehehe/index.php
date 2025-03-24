<?php 
session_start();
include 'connect/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    $conn = dbConnect();

    if (!$conn) {
        die("Database connection failed!");
    }

    $sql = "SELECT * FROM accounts WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Query preparation failed!");
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            echo "✅ Password matches!<br>";

            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'A') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            echo "❌ Password does NOT match!<br>";
            $_SESSION['error'] = "Incorrect Username or Password";
        }
    } else {
        echo "❌ No user found with that username.<br>";
        $_SESSION['error'] = "Incorrect Username or Password";
    }
}
?>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-awesome-cursor/0.3.1/jquery.awesome-cursor.min.js" integrity="sha512-mR4OOU/ky22CpIhlxfBwQ2ckKWapf+g2+1sbUCkVtFaaRcVLpytf0ERgrXXUUYgFOdbehWOJJdW7QzYJ7XlLiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            width: 800px;
            height: 450px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        .left {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .right {
            width: 50%;
            background: url('images/k.jpg') center no-repeat;
            background-size: cover;
        }
        h2 {
            font-size: 28px;
            color: #000;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
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
        .alert {
            position: absolute;
            top: 20px; 
            left: 50%;
            transform: translateX(-50%);
            width: 50%; 
            text-align: center;
            }
</style>
</head>
<body>

    <div class="container">
        <div class="left">
            <h2>Log in</h2>
            <form action="" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="btn" name="login">Sign In</button>
            </form>
            <a href="register.php">Register?</a>
        </div>
        <div class="right"></div>
    </div>

</body>
</html>