<?php
session_start();
require_once 'connection.php';

// Hardcoded admin credentials
$admin_username = "admin";
$admin_password = "admin123";

// Variable to store login status
$login_success = false;

// Handle form submissions for registration and login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle registration
    if (isset($_POST['register'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password1'];
        $confirm_password = $_POST['password2'];
        $security_question = $_POST['security_question'];
        $security_answer = trim($_POST['security_answer']);

        // Validate input fields
        if (empty($username) || empty($email) || empty($password) || empty($security_question) || empty($security_answer)) {
            echo 'All fields are required.';
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email format.';
            exit;
        }

        // Check if passwords match
        if ($password !== $confirm_password) {
            echo 'Passwords do not match.';
            exit;
        }

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username or email already exists
        $checkQuery = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo 'Username or email already taken.';
            $stmt->close();
            exit;
        }
        $stmt->close();

        // Prepare SQL query for registration, including security question and answer
        $query = "INSERT INTO users (username, email, password1, security_question, security_answer) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters and execute query
            $stmt->bind_param('sssss', $username, $email, $hashed_password, $security_question, $security_answer);

            if ($stmt->execute()) {
                // After successful registration, redirect to login page
                header('Location: login.html');
                exit;
            } else {
                echo 'Error: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            echo 'Error preparing statement: ' . $conn->error;
        }
    }

    // Handle login
    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password1'];

        // Admin login check
        if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['username'] = $username;
            $_SESSION['user_role'] = 'admin'; // Mark this session as admin
            header('Location: admin.php'); // Redirect to admin page
            exit();
        }

        // Validate input fields for normal users
        if (empty($username) || empty($password)) {
            echo 'Both username and password are required.';
            exit;
        }

        // Prepare SQL query to fetch user data
        $query = "SELECT id, username, email, password1 FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Bind parameters and execute query
            $stmt->bind_param('s', $username);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                // Verify password and set session variables if correct
                if ($row && password_verify($password, $row['password1'])) {
                    $_SESSION['user_id'] = $row['id']; // Store the user ID in the session
                    $_SESSION['username'] = $row['username']; // Store the username in the session
                    $_SESSION['email'] = $row['email']; // Store the email in the session

                    // Set login success variable
                    $login_success = true;

                    // Redirect to home page (index.php) after successful login
                    header('Location: index.php');
                    exit();
                } else {
                    echo 'Invalid username or password.';
                }
            } else {
                echo 'Error executing query: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            echo 'Error preparing statement: ' . $conn->error;
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.html');
    exit;
}

$conn->close();
?>
