<?php
session_start();
$username = $_SESSION['username'];
require_once 'connection.php';

// Get Honda bikes from the database
$brand = 'Honda';  // Set the brand to Honda
$stmt = $conn->prepare("SELECT * FROM bikes WHERE brand = ?");
$stmt->bind_param("s", $brand);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Collections</title>
    <style>
        /* Same CSS as before */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1e1e1e;
            color: #e0e0e0;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .navbar .brand {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .navbar .brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }
        .brandname {
            text-align: start;
            display: flex;
            align-items: center;
        }
        .brandname p {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            margin: 0;
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-links a:hover,
        .nav-links a.active {
            background-color: #555;
            color: #f0f0f0;
            border-radius: 5px;
        }
        .hero {
            background-image: url("");
            background-size: cover;
            background-position: center;
            padding: 60px 20px;
            text-align: center;
            color: #e0e0e0;
        }
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 24px;
        }
        .collection-section {
            padding: 50px 20px;
            background-color: #2c2c2c;
            color: #e0e0e0;
            text-align: center;
        }
        .collection-section h2 {
            font-size: 36px;
            margin-bottom: 30px;
        }
        .collection-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .bike-item {
            flex: 1 1 calc(25% - 15px);
            background-color: #3c3c3c;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            max-width: 280px;
        }
        .bike-item a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .bike-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.7);
        }
        .bike-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .bike-item h3 {
            font-size: 20px;
            margin-bottom: 8px;
        }
        .bike-item p {
            font-size: 20px;
            color: #b0b0b0;
            font-weight: 500;
        }
        footer {
            background-color: #333;
            color: #e0e0e0;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a class="brand" href="#">
            <img src="brandlogo1.png" alt="MotoDeal Logo">
        </a>
        <div class="brandname">
            <p>MotoDeal</p>
        </div>
        <div class="nav-links">
            <a class="active" href="index.php">Home</a>
            <a href="index.php">Services</a>
            <a href="index.php">About</a>
            <a href="index.php">Contact</a>
            <div class="dropdown">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="#" class="dropbtn"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="login.html" class="dropbtn">Login/Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Explore Our Honda Bike Collections</h1>
        <p>Find the perfect bike for your adventure</p>
    </section>

    <!-- Bike Collection Section -->
    <section id="bike-collection" class="collection-section">
        <h2>Our Honda Bike Collections</h2>
        <div class="collection-container">
            <!-- Add dynamic bikes here -->
            <?php while ($bike = $result->fetch_assoc()) { ?>
                <div class="bike-item">
                    <a href="bike_details.php?bike_id=<?php echo urlencode($bike['bikename']); ?>">
                        <img src="<?php echo htmlspecialchars($bike['image']); ?>" alt="Bike Image">
                        <h3><?php echo htmlspecialchars($bike['bikename']); ?></h3>
                        <p>Price: ₹<?php echo htmlspecialchars($bike['price']); ?>/-</p>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php
    $stmt->close();
    $conn->close();
    ?>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MotoDeal. All rights reserved.</p>
    </footer>
</body>
</html>
