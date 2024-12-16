<?php
require 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle adding income
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['income'])) {
    $income = (float) $_POST['income'];

    // Check if the user already has an income entry
    $stmt = $pdo->prepare("SELECT total_income FROM income WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $current_income = $stmt->fetchColumn();

    if ($current_income !== false) {
        // Add to the existing income
        $stmt = $pdo->prepare("UPDATE income SET total_income = total_income + ? WHERE user_id = ?");
        $stmt->execute([$income, $user_id]);
    } else {
        // Insert a new income entry
        $stmt = $pdo->prepare("INSERT INTO income (user_id, total_income) VALUES (?, ?)");
        $stmt->execute([$user_id, $income]);
    }
}

// Handle adding an expense
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['description'], $_POST['amount'])) {
    $description = $_POST['description'];
    $amount = (float) $_POST['amount'];

    // Fetch the user's current income
    $stmt = $pdo->prepare("SELECT total_income FROM income WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $current_income = $stmt->fetchColumn();

    // Check if the user has enough income for the expense
    if ($current_income >= $amount) {
        // Add the expense
        $stmt = $pdo->prepare("INSERT INTO expenses (user_id, description, amount) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $description, $amount]);

        // Deduct the expense amount from the user's income
        $stmt = $pdo->prepare("UPDATE income SET total_income = total_income - ? WHERE user_id = ?");
        $stmt->execute([$amount, $user_id]);
    } else {
        $error = "Insufficient income for this expense!";
    }
}

// Fetch the current total income for display
$stmt = $pdo->prepare("SELECT total_income FROM income WHERE user_id = ?");
$stmt->execute([$user_id]);
$current_income = $stmt->fetchColumn();

// Fetch user's expenses
$stmt = $pdo->prepare("SELECT * FROM expenses WHERE user_id = ?");
$stmt->execute([$user_id]);
$expenses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
</head>
<body class="dashboard-body">
    <style>
       /* General Body Styling */
body.dashboard-body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #ffffff;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    justify-content: center;
}

/* Header */
h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2rem;
}

/* Income and Expense Display */
p {
    font-size: 1.2rem;
    margin: 10px 0;
}

.error {
    color: #ff4f4f;
    font-weight: bold;
    text-align: center;
}

/* Forms Styling */
form {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
    width: 300px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

form h3 {
    margin-bottom: 15px;
}

form label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

form input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
}

form button {
    background: #4caf50;
    border: none;
    padding: 10px;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
}

form button:hover {
    background: #45a049;
}

/* Expense List */
.expense-list {
    list-style: none;
    padding: 0;
    width: 300px;
}

.expense-list li {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
    padding: 10px;
    margin: 5px 0;
    display: flex;
    justify-content: space-between;
}

.expense-list li:nth-child(odd) {
    background: rgba(255, 255, 255, 0.2);
}

/* Logout Link */
a {
    display: inline-block;
    margin: 10px 0;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}
 
    </style>
    <h2>Welcome to your Dashboard</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <p>Total Income: Tsh.<?= number_format($current_income, 2) ?></p>
    <a href="logout.php">Logout</a>

    <form method="post" class="income-form">
        <h3>Add to Your Income</h3>
        <label for="income">Enter Income to Add:</label>
        <input type="number" id="income" name="income" step="0.01" required>
        <button type="submit">Add Income</button>
    </form>

    <form method="post" class="expense-form">
        <h3>Add Expense</h3>
        <label>Description</label>
        <input type="text" name="description" required>
        <label>Amount</label>
        <input type="number" name="amount" step="0.01" required>
        <button type="submit">Add Expense</button>
    </form>

    <h3>Expense History</h3>
    <ul class="expense-list">
        <?php foreach ($expenses as $expense): ?>
            <li><?= $expense['description'] ?> - $<?= number_format($expense['amount'], 2) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>






