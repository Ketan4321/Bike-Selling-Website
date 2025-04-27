<?php
session_start();
$username = $_SESSION['username'];
require_once 'connection.php';

// Get Honda bikes from the database
$brand = 'KTM';  // Set the brand to Honda
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
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #1e1e1e; /* Dark background color */
        color: #e0e0e0; /* Light text color */
    }
    
    /* Navbar */
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        background-color: #333; /* Dark background */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Darker shadow */
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
        color: #fff; /* White text color */
        margin: 0;
    }
    
    .nav-links {
        display: flex;
        gap: 20px;
    }
    
    .nav-links a {
        color: #e0e0e0; /* Light text color */
        text-decoration: none;
        font-size: 16px;
        padding: 10px 15px;
        transition: background-color 0.3s, color 0.3s;
    }
    
    .nav-links a:hover,
    .nav-links a.active {
        background-color: #555; /* Slightly lighter background on hover */
        color: #f0f0f0; /* Lighter text color */
        border-radius: 5px;
    }
    
    /* Hero Section */
    .hero {
        background-image: url(""); /* Optional: add a dark background image */
        background-size: cover;
        background-position: center;
        padding: 60px 20px;
        text-align: center;
        color: #e0e0e0; /* Light text color */
    }
    
    .hero h1 {
        font-size: 48px;
        margin-bottom: 20px;
    }
    
    .hero p {
        font-size: 24px;
    }
    
    /* Bike Collection Section */
    .collection-section {
        padding: 50px 20px;
        background-color: #2c2c2c; /* Dark background for section */
        color: #e0e0e0; /* Light text color */
        text-align: center;
    }
    
    .collection-section h2 {
        font-size: 36px;
        margin-bottom: 30px;
    }
    
    .collection-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Center items horizontally */
        gap: 20px; /* Space between items */
        max-width: 1200px; /* Limit the container width */
        margin: 0 auto; /* Center the container */
    }
    
    .bike-item {
        flex: 1 1 calc(25% - 15px); /* 4 items per row with reduced gap */
        background-color: #3c3c3c; /* Dark background for items */
        padding: 10px; /* Reduced padding */
        border-radius: 8px; /* Slightly smaller border radius */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Darker shadow */
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
        max-width: 280px; /* Limit maximum width of each item */
    }
    
    .bike-item a {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .bike-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.7); /* Darker shadow on hover */
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
        color: #b0b0b0; /* Slightly lighter text color */
        font-weight: 500;
    }
    
    /* Footer */
    footer {
        background-color: #333; /* Dark background */
        color: #e0e0e0; /* Light text color */
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
        <h1>Explore Our KTM Bike Collections</h1>
        <p>Find the perfect bike for your adventure</p>
    </section>

    <!-- Bike Collection Section -->
    <section id="bike-collection" class="collection-section">
        <h2>Our KTM Bike Collections</h2>
        <div class="collection-container">
            <div class="bike-item">
                <a href="suzuki1.html">
                    <img src="img/ktm1.jpg" alt="Bike 1">
                    <h3>KTM 200 Duke</h3>
                    <p>₹178,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#mountain-bikes">
                    <img src="img/ktm2.jpg" alt="Bike 2">
                    <h3>KTM RC 200</h3>
                    <p>₹198,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#electric-bikes">
                    <img src="img/ktm3.jpg" alt="Bike 3">
                    <h3>KTM 390 Duke</h3>
                    <p>₹318,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#hybrid-bikes">
                    <img src="img/ktm4.jpg" alt="Bike 4">
                    <h3>KTM RC 390</h3>
                    <p>₹335,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm5.jpg" alt="Bike 5">
                    <h3>KTM 390 Adventure</h3>
                    <p>₹338,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm6.jpg" alt="Bike 5">
                    <h3>KTM 790 Duke</h3>
                    <p>₹599,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm7.jpg" alt="Bike 5">
                    <h3>KTM 690 Duke</h3>
                    <p>₹600,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm8.jpg" alt="Bike 5">
                    <h3>KTM 250 SX-F</h3>
                    <p>₹724,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm9.jpg" alt="Bike 5">
                    <h3>KTM 300 EXC-F TPI</h3>
                    <p>₹740,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm10.jpg" alt="Bike 5">
                    <h3>KTM 790 Adventure S</h3>
                    <p>₹748,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm11.jpg" alt="Bike 5">
                    <h3>KTM 450 SX-F</h3>
                    <p>₹760,999/-</p>
                </a>
            </div>
            <div class="bike-item">
                <a href="#folding-bikes">
                    <img src="img/ktm12.jpg" alt="Bike 5">
                    <h3>KTM 1290 Super Duke GT</h3>
                    <p>₹1,200,999/-</p>
                </a>
            </div>
            <!-- Add dynamic bikes here -->
            <?php while ($bike = $result->fetch_assoc()) { ?>
                <div class="bike-item">
                    <a href="bike_details.php?bike_id=<?php echo urlencode($bike['bikename']); ?>">
                        <img src="<?php echo htmlspecialchars($bike['image']); ?>" alt="Bike Image">
                        <h3><?php echo htmlspecialchars($bike['bikename']); ?></h3>
                        <p>Price: <?php echo htmlspecialchars($bike['price']); ?>/-</p>
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
