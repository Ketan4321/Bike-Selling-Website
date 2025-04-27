<?php
session_start(); // Ensure the session is started

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Handle item removal from the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id']; // Correct input name
    $user_id = $_SESSION['user_id']; // Use the correct session variable

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param('ii', $item_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<p>Item removed successfully.</p>";
    } else {
        echo "<p>Error removing item: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Retrieve cart items for the logged-in user
$user_id = $_SESSION['user_id']; // Use session variable
$email = $_SESSION['email'];
$username = $_SESSION['username'];

// Prepare SQL query to fetch items booked by the logged-in user
$sql = "SELECT id, brand, model, price, is_booked FROM bookings WHERE user_id = ? AND email = ? AND username = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters and execute the query
$stmt->bind_param('iss', $user_id, $email, $username);

if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    die("Error executing query: " . $stmt->error);
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        /* Cart Items Styling */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .cart-info {
            display: flex;
            flex-direction: column;
        }

        .cart-info p {
            margin: 5px 0;
            font-size: 1rem;
            color: #555;
        }

        .cart-info .brand {
            font-size: 1.2rem;
            color: #333;
        }

        .cart-info .price {
            font-weight: bold;
            color: #ff6b6b;
        }

        /* Remove Button Styling */
        .remove-form {
            display: flex;
            align-items: center;
        }

        .remove-btn {
            padding: 10px 20px;
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #ff4c4c;
        }

        /* Continue Shopping Button */
        .continue-shopping-btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 15px;
            margin-top: 30px;
            background-color: #6bb9ff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .continue-shopping-btn:hover {
            background-color: #3498db;
        }

        /* Empty Cart Message */
        .empty-cart {
            text-align: center;
            color: #999;
            font-size: 1.2rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>

        <div class="cart-items">
            <?php
            if ($result->num_rows > 0) {
                // Display cart items
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='cart-item'>";
                    echo "<div class='cart-info'>";
                    echo "<p class='brand'><strong>Brand: " . htmlspecialchars($row['brand']) . "</strong></p>";
                    echo "<p class='model'>Model: " . htmlspecialchars($row['model']) . "</p>";
                    echo "<p class='price'>Total Price: ₹" . htmlspecialchars($row['price']) . "</p>";
                    echo "</div>";

                    if ($row['is_booked'] == 1) { // Check if bike is booked
                        echo "<p>Bike Booked</p>";
                    } else {
                        echo "<form action='cart.php' method='post' class='remove-form'>";
                        echo "<input type='hidden' name='item_id' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit' name='remove_item' class='remove-btn'>Remove</button>";
                        echo "</form>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p class='empty-cart'>Your cart is empty.</p>";
            }
            ?>
        </div>

        <a href="payment.php" class="continue-shopping-btn">Proceed for Payment</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
