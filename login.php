<?php
require 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <style>
        body.login-body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .nav {
            padding: 10px;
            background-color: #6a11cb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: bisque;
        }

        .nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav ul li {
            margin: 0 10px;
        }

        .nav ul li a {
            color: bisque;
            text-decoration: none;
        }

        .login-form {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px;
        }

        .login-form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-form input:focus {
            border-color: #6a11cb;
            outline: none;
        }

        .login-form button {
            background: #6a11cb;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .login-form button:hover {
            background: #2575fc;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="login-body">
    <nav class="nav">
        <ul>
            <li><a href="index.php">HOME</a></li>
        </ul>
    </nav>
    
    <form method="POST" class="login-form">
        <h2>Login Here</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?> 
        <input type="email" name="email" placeholder="Enter your email" required><br><br>
        <input type="password" name="password" placeholder="Your password" required><br><br>
        <button type="submit">Login</button><br>
        <p>If you haven't an account <a href="register.php">Register here</a></p>
    </form>
</body>
</html>
