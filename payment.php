<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and has the necessary session variables
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    die("Required session data not found.");
}

// Initialize variables with session data
$username = $_SESSION['username'];
$email = $_SESSION['email'];

require_once 'connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gather POST data
    $cardholderName = $_POST['cardholderName'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];

    // Check if all fields are provided
    if (empty($cardholderName) || empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
        die("All fields are required.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO payments (username, email, cardholder_name, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $username, $email, $cardholderName, $cardNumber, $expiryDate, $cvv);

    // Execute the statement
    if ($stmt->execute()) {
        // Update the bookings table to mark bikes as booked
        $updateStmt = $conn->prepare("UPDATE bookings SET is_booked = 1 WHERE user_id = ?");
        $updateStmt->bind_param('i', $_SESSION['user_id']);
        $updateStmt->execute();
        $updateStmt->close();
        
        $message = "Payment details stored successfully.";
        // JavaScript for popup and redirection
        echo '<script>
                alert("Your bike is booked!");
                window.location.href = "index.php";
              </script>';
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page with Validation</title>
    <style>
        /* Basic styling for the form */
        .payment-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 8px;
        }
        .form-row {
            margin-bottom: 20px;
        }
        .form-row label {
            display: block;
            margin-bottom: 6px;
        }
        .form-row input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        #submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }
        #submit:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
            display: none;
        }
        .message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="payment-form">
        <h2>Payment Details</h2>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <form id="payment-form" method="post">
            <div class="form-row">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
            </div>

            <div class="form-row">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>

            <div class="form-row">
                <label for="cardholder-name">Cardholder Name</label>
                <input type="text" id="cardholder-name" name="cardholderName" placeholder="Enter cardholder's name" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" title="Location must contain only letters and spaces" required>
                <div id="cardholder-name-error" class="error">Cardholder name is required.</div>
            </div>

            <div class="form-row">
                <label for="card-number">Card Number</label>
                <input type="text" id="card-number" name="cardNumber" placeholder="1234 5678 9012 3456" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);" title="Please enter a 10-digit phone number" required>
                <div id="card-number-error" class="error">Invalid card number. Must be 16 digits.</div>
            </div>

            <div class="form-row">
                <label for="expiry-date">Expiry Date (MM/YY)</label>
                <input type="text" id="expiry-date" name="expiryDate" placeholder="MM/YY" required>
                <div id="expiry-date-error" class="error">Invalid expiry date. Format must be MM/YY.</div>
            </div>

            <div class="form-row">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" required>
                <div id="cvv-error" class="error">Invalid CVV. Must be 3 digits.</div>
            </div>

            <button id="submit" type="submit">Pay Now</button>
        </form>
    </div>

    <script>
        document.getElementById('payment-form').addEventListener('submit', function(event) {
            // Clear previous error messages
            document.getElementById('card-number-error').style.display = 'none';
            document.getElementById('expiry-date-error').style.display = 'none';
            document.getElementById('cvv-error').style.display = 'none';

            // Gather form data
            const cardholderName = document.getElementById('cardholder-name').value;
            const cardNumber = document.getElementById('card-number').value;
            const expiryDate = document.getElementById('expiry-date').value;
            const cvv = document.getElementById('cvv').value;

            // Validate form data
            const cardNumberRegex = /^\d{16}$/;
            if (!cardNumberRegex.test(cardNumber)) {
                document.getElementById('card-number-error').style.display = 'block';
                return;
            }

            const expiryDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expiryDateRegex.test(expiryDate)) {
                document.getElementById('expiry-date-error').style.display = 'block';
                return;
            }

            const cvvRegex = /^\d{3}$/;
            if (!cvvRegex.test(cvv)) {
                document.getElementById('cvv-error').style.display = 'block';
                return;
            }

            // Submit the form
            document.getElementById('payment-form').submit();
        });
    </script>

</body>
</html>
