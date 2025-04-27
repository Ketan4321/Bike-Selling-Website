<?php
// Include database connection
include 'connection.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    if (isset($_POST['password'])) {
        // Hash the new password securely
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Prepare the SQL query to update the user's password
        $query = "UPDATE users SET password1 = ? WHERE username = ?";
        $stmt = $conn->prepare($query);

        // Check if query preparation was successful
        if ($stmt === false) {
            // Output the error message
            die('Error preparing statement: ' . $conn->error);
        }

        // Bind the parameters and execute the query
        $stmt->bind_param("ss", $password, $username);

        if ($stmt->execute()) {
            // Output JavaScript for alert and redirection
            echo "<script>
                    alert('Password Changed.');
                    window.location.href = 'login.html';
                  </script>";
            exit; // Ensure no further code is executed
        } else {
            echo 'Error: ' . $conn->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Universal styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #121212; /* Dark background */
            color: #f0f0f0; /* Light text */
        }

        .container {
            background: #1e1e1e; /* Dark grey container background */
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        b {
            font-size: 24px;
            margin-bottom: 20px;
            display: inline-block;
        }

        label {
            font-size: 14px;
            color: #ddd;
            display: block;
            text-align: left;
            margin-bottom: 8px;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2c2c2c;
            color: #fff;
        }

        input[type="password"]::placeholder {
            color: #aaa;
        }

        button.Btn {
            background-color: #007BFF; /* Button color */
            color: #fff;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button.Btn:hover {
            background-color: #0056b3; /* Hover effect for the button */
        }

        /* Footer or extra text */
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #bbb;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <b>Reset Password</b><br><br>
        <form method="POST">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" required>
            <button class="Btn" type="submit">Reset Password</button>
        </form>
        <div class="footer">
            <p>Return to <a href="login.html">Login</a></p>
        </div>
    </div>
</body>
</html>
