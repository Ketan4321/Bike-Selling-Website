<?php
require_once 'connection.php';

// Check if bike_id is set in the URL
if (isset($_GET['bike_id'])) {
    $bike_id = $_GET['bike_id'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM bikes WHERE bikename = ?");
    $stmt->bind_param("s", $bike_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        .bike-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .bike-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .bike-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .bike-description {
            margin-top: 20px;
            text-align: center;
        }
        .bike-description h2 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #007bff;
        }
        .bike-description p {
            font-size: 1.2em;
            margin: 5px 0;
        }
        .bike-specifications {
            margin-top: 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .spec-container ul {
            list-style-type: none;
            padding: 0;
        }
        .spec-container ul li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        footer {
            margin-top: 40px;
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<?php
// Check if the bike exists
if (isset($result) && $result->num_rows > 0) {
    $bike = $result->fetch_assoc();
?>
    <section class="bike-section">
        <div class="bike-content">
            <div class="bike-image">
                <img src="<?php echo htmlspecialchars($bike['image']); ?>" alt="Bike Image">
            </div>
            <div class="bike-description">
                <h2><?php echo htmlspecialchars($bike['bikename']); ?></h2>
                <p>Price: $<?php echo htmlspecialchars($bike['price']); ?></p>
            </div>
        </div>
    </section>

    <section class="bike-specifications">
        <h2>SPECIFICATIONS</h2>
        <div class="spec-container">
            <ul>
                <?php 
                // Assuming 'specifications' holds a comma-separated list of specifications
                $specifications = explode(",", $bike['specifications']);
                foreach($specifications as $spec) {
                    echo "<li>" . htmlspecialchars(trim($spec)) . "</li>";
                }
                ?>
            </ul>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <!-- Footer Content -->
            <p>&copy; 2024 Bike Store. All rights reserved.</p>
        </div>
    </footer>
<?php
} else {
    echo "<p>Bike not found.</p>";
}
$conn->close();
?>
</body>
</html>
