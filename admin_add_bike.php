<?php
// Only allow admins to access this page
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'connection.php';

// Handle form submission to add a new bike
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            echo "Bike added successfully!";
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Error adding bike: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add New Bike</title>
    <style>
        /* Styling similar to your current design */
        .form-container {
            width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .form-container h2 {
            text-align: center;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            margin-bottom: 5px;
        }
        .form-container input, .form-container select, .form-container textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
    <div class="form-container">
        <h2>Add New Bike</h2>
        <form action="admin_add_bike.php" method="POST" enctype="multipart/form-data">
            <label for="bikename">Bike Name:</label>
            <input type="text" name="bikename" required>

            <label for="brand">Brand:</label>
            <select name="brand" required>
                <option value="Suzuki">Suzuki</option>
                <option value="Honda">Honda</option>
                <option value="BMW">BMW</option>
                <option value="Kawasaki">Kawasaki</option>
                <option value="KTM">KTM</option>
                <option value="Royal Enfield">Royal Enfield</option>
                
            </select>

            <label for="price">Price:</label>
            <input type="integer" name="price" required>

            <label for="specifications">Specifications:</label>
            <textarea name="specifications" rows="5" required></textarea>

            <label for="image">Bike Image:</label>
            <input type="file" name="image" required>

            <button type="submit">Add Bike</button>
        </form>
    </div>
</body>
</html>
