<?php
// Database credentials
$host = 'localhost';      // Database server (localhost if running locally)
$dbname = 'budget_tracker'; // Name of your database
$username = 'root';       // Your MySQL username
$password = '';           // Your MySQL password (leave empty for default XAMPP/MAMP setups)

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set error reporting mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Set the default fetch mode
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>
