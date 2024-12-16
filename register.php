<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            $error = "This email is already registered. Please use a different email.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$firstname, $lastname, $email, $hashed_password])) {
                header('Location: login.php');
                exit();
            } else {
                $error = "Registration failed. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Navigation Bar Styles */
        nav {
            background: #333;
            color: #fff;
            width: 100%;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            margin-right: 15px;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #6a11cb;
        }

        /* Registration Form Styles */
        .register-form {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .register-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #6a11cb;
            font-weight: bold;
        }

        .register-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .register-form button {
            width: 100%;
            padding: 10px;
            background: #6a11cb;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease;
        }

        .register-form button:hover {
            background: #2575fc;
        }

        .register-form .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

    </style>
</head>
<body>
    <nav>
        <div class="nav-content">
            <a href="index.php">Home</a>
        </div>
    </nav>

    <form method="POST" class="register-form">
        <h2>Register Here Our Client</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <input type="text" name="firstname" placeholder="Firstname" required><br><br>
        <input type="text" name="lastname" placeholder="Lastname" required><br><br>
        <input type="email" name="email" placeholder="Enter your valid email" required><br><br>
        <input type="password" name="password" placeholder="Enter your password" required><br><br>
        <input type="password" name="confirm_password" placeholder="Confirm your password" required><br><br>
        <button type="submit">Register</button><br>
        <div>
            <p>If you have an account <a href="login.php">Login Here</a></p>
        </div>
    </form>
</body>
</html>
