<?php
// Include database connection
include 'connection.php';

if (isset($_POST['username']) && isset($_POST['security_answer'])) {
    $username = $_POST['username'];
    $security_answer = $_POST['security_answer'];

    // Check if the username exists and validate the security answer
    $query = "SELECT * FROM users WHERE username = ? AND security_answer = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $security_answer);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // If correct, allow the user to reset their password
        header("Location: reset_password.php?username=" . urlencode($username));
        exit;
    } else {
        echo "Invalid username or security answer.";
    }
} else {
    echo "Please provide both username and security answer.";
}
