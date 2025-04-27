<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();
require_once 'connection.php';  // Ensure this file contains the correct database connection

// Get user details from the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;  // Fetch the logged-in user's ID from the session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : null;        // Fetch the logged-in user's email from the session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null; // Fetch the logged-in user's username from the session

// Check if user is logged in
if ($user_id === null || $email === null || $username === null) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit(); // Ensure no further code is executed after the redirect
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape and validate form inputs to prevent SQL injection
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $price = $_POST['price'];

    // Check for empty fields
    if (empty($phone) || empty($location) || empty($brand) || empty($model) || empty($price)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare SQL query using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, email, username, phone, location, brand, model, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("isssssss", $user_id, $email, $username, $phone, $location, $brand, $model, $price);

        if ($stmt->execute()) {
            // Redirect to cart.php after successful booking
            header("Location: cart.php");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            // Display error if query fails
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Display error if statement preparation fails
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
