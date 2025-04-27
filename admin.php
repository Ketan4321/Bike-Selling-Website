<?php
session_start();
// Only allow admins to access this page
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.html');
    exit();
}

require_once 'connection.php';

// Handle form submission to add a new bike
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addBike') {
    $bikename = $_POST['bikename'];
    $brand = $_POST['brand'];  // Capture the brand
    $price = $_POST['price'];
    $specifications = $_POST['specifications'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Insert the bike details into the database
    $stmt = $conn->prepare("INSERT INTO bikes (bikename, brand, price, specifications, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $bikename, $brand, $price, $specifications, $target);
    
    if ($stmt->execute()) {
        // Move the uploaded image to the server directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $message = "Bike added successfully!";
        } else {
            $message = "Failed to upload image.";
        }
    } else {
        $message = "Error adding bike: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all bikes from the bikes table
$bike_query = "SELECT id, bikename, price, image, specifications, brand FROM bikes";
$bike_result = $conn->query($bike_query);

// Check if the query was successful
if (!$bike_result) {
    die("Error fetching bikes: " . $conn->error);
}

// Fetch all users from the database
$user_query = "SELECT id, username, email, password1, created_at FROM users";
$user_result = $conn->query($user_query);

// Check if the query was successful
if (!$user_result) {
    die("Error fetching users: " . $conn->error);
}

// Fetch all orders from the bookings table where is_booked = 1
$order_query = "SELECT id, username, email, phone, location, brand, model, price FROM bookings WHERE is_booked = 1";
$order_result = $conn->query($order_query);

// Check if the query was successful
if (!$order_result) {
    die("Error fetching orders: " . $conn->error);
}

// Fetch all payments from the payments table
$payment_query = "SELECT id, username, email, cardholder_name, card_number, expiry_date, cvv, created_at FROM payments";
$payment_result = $conn->query($payment_query);

// Check if the query was successful
if (!$payment_result) {
    die("Error fetching payments: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            display: flex;
            width: 100%;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            text-align: center;
            color: #e67e22;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            cursor: pointer;
            color: #ecf0f1;
            transition: background-color 0.3s;
        }

        .sidebar ul li:hover {
            background-color: #34495e;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            background-color: #ffffff;
        }

        .section {
            display: none;
        }

        .section h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #e67e22;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #d35400;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: #ffffff;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1c40f;
        }

        .message {
            color: #e67e22;
            text-align: center;
            margin-bottom: 20px;
        }

        .logout-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li onclick="showSection('addNew')">Add New Bike</li>
                <li onclick="showSection('orders')">Orders</li>
                <li onclick="showSection('userDetails')">User Details</li>
                <li onclick="showSection('paymentHistory')">Payment History</li>
                <li onclick="showSection('bikeData')">Bike Data</li>
            </ul>
            <form method="post" action="logout.php">
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Add New Bike Form -->
            <div id="addNew" class="section">
                <h2>Add New Bike</h2>
                <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
                <div class="form-container">
                    <form action="admin.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="addBike">
                        <label for="bikename">Bike Name:</label>
                        <input type="text" id="bikename" name="bikename" required>

                        <label for="brand">Brand:</label>
                        <select id="brand" name="brand" required>
                            <option value="Suzuki">Suzuki</option>
                            <option value="Honda">Honda</option>
                            <option value="BMW">BMW</option>
                            <option value="Kawasaki">Kawasaki</option>
                            <option value="KTM">KTM</option>
                            <option value="Royal Enfield">Royal Enfield</option>
                        </select>

                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" required>

                        <label for="specifications">Specifications:</label>
                        <textarea id="specifications" name="specifications" rows="4" required></textarea>

                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>

                        <button type="submit">Add Bike</button>
                    </form>
                </div>
            </div>

            <!-- Orders Section -->
            <div id="orders" class="section">
                <h2>Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = $order_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['username']); ?></td>
                                <td><?php echo htmlspecialchars($order['email']); ?></td>
                                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                <td><?php echo htmlspecialchars($order['location']); ?></td>
                                <td><?php echo htmlspecialchars($order['brand']); ?></td>
                                <td><?php echo htmlspecialchars($order['model']); ?></td>
                                <td><?php echo htmlspecialchars($order['price']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- User Details Section -->
            <div id="userDetails" class="section">
                <h2>User Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $user_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['password1']); ?></td>
                                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Payment History Section -->
            <div id="paymentHistory" class="section">
                <h2>Payment History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Cardholder Name</th>
                            <th>Card Number</th>
                            <th>Expiry Date</th>
                            <th>CVV</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($payment = $payment_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payment['id']); ?></td>
                                <td><?php echo htmlspecialchars($payment['username']); ?></td>
                                <td><?php echo htmlspecialchars($payment['email']); ?></td>
                                <td><?php echo htmlspecialchars($payment['cardholder_name']); ?></td>
                                <td><?php echo htmlspecialchars($payment['card_number']); ?></td>
                                <td><?php echo htmlspecialchars($payment['expiry_date']); ?></td>
                                <td><?php echo htmlspecialchars($payment['cvv']); ?></td>
                                <td><?php echo htmlspecialchars($payment['created_at']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Bike Data Section -->
            <div id="bikeData" class="section">
                <h2>Bike Data</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Bike Name</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Specifications</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($bike = $bike_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($bike['id']); ?></td>
                                <td><?php echo htmlspecialchars($bike['bikename']); ?></td>
                                <td><?php echo htmlspecialchars($bike['brand']); ?></td>
                                <td><?php echo htmlspecialchars($bike['price']); ?></td>
                                <td><?php echo htmlspecialchars($bike['specifications']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($bike['image']); ?>" alt="<?php echo htmlspecialchars($bike['bikename']); ?>" style="width: 100px;"></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(function(section) {
                section.style.display = 'none';
            });

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        // Show the default section (Add New Bike)
        showSection('addNew');
    </script>
</body>
</html>
