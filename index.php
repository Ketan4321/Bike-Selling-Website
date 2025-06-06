<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MotoDeal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Basic styling for the navigation bar */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("homebike.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        
            /* Style the navbar container */
/* Style the navbar container */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #333;
    padding: 14px;
    position: fixed;    
    height:40px ;   /* Fix the navbar at the top */
    top: 0;                /* Stick it to the top */
    width: 100%;           /* Make it span the full width */
    z-index: 9999;         /* Ensure it's on top of all other content */
}

    /* Navbar links */
    .nav-links a {
        color: white;
        text-decoration: none;
        padding: 14px 20px;
        display: inline-block;
    }

    /* Dropdown container */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown button */
    .dropbtn {
        color: white;
        text-decoration: none;
        padding: 14px 20px;
        background-color: #333;
        border: none;
        cursor: pointer;
    }

    /* The dropdown content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #808080;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    .cart {
    position: relative;
    display: flex;
    justify-content: flex-end; /* Aligns the cart to the right */
    align-items: center;
    margin-top: 20px; /* Adjust this value if the navbar height changes */
    padding-right: 20px; /* Adds a bit of padding to the right side */
}

        .cart-icon {
            font-size: 24px;
            color: white;
            text-decoration: none;
            padding: 10px;
            background-color: #333;
            border-radius: 50%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .cart-icon:hover {
            transform: scale(1.2);
        }

        /* Responsive layout - when the screen is less than 600px wide, stack the links vertically instead of horizontally */
        @media screen and (max-width: 600px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start; /* Align items to the start when stacked */
            }
            .navbar .nav-links {
                width: 100%;
                flex-direction: column;
            }
            .navbar .nav-links a {
                width: 100%;
            }
            .navbar .brand {
                margin-bottom: 10px;
            }
        }

        .wellcome {
            position: relative;
            color: #ddd;
            text-align: center;
            margin-top: 90px;
            font-size: 30px;
        }

        #services {
            height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 450px; /* Makes the services section start after the initial screen */
            padding: 50px 20px;
            background-color: #100f0f;
            color: #fff;
        }

        #services h1 {
            font-size: 36px;
            margin-bottom: 40px;
            color: #fff;
            text-align: center;
        }

        .service-row {
            display: flex;
            justify-content: space-around;
            width: 100%;
            flex-wrap: wrap;
        }

        .box {
            text-align: center;
            transition: all 0.2s ease-out;
            padding: 24px;
            background-color: black;
            color: #fff;
            box-shadow: 9px 9px 16px 0px rgba(0, 0, 0, 0.25);
            border-radius: 3%;
            margin: 15px;
            width: 200px;
        }

        .box>p {
            margin-top: 0;
        }

        .box>.icon {
            font-size: 40px;
            border: 2px solid #fff;
            padding: 25px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .box>h4 {
            padding: 20px 0;
            font-weight: bold;
        }

        #about {
            height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            background-color: #070606;
            color: #979797;
            margin-top: 100px;
        }

        #about h1 {
            font-size: 36px;
            margin-bottom: 20px;
            text-align: center;
        }

        #about p {
            font-size: 18px;
            line-height: 1.6;
            text-align: center;
            max-width: 800px;
        }

        #brands {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            background-color: #070606;
            margin-top: 100px;
            height: 600px;
        }

        #brands h1 {
            font-size: 36px;
            margin-bottom: 20px;
            text-align: center;
            color: #fff;
        }

        .brand-list {
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
            gap: 20px; /* Space between brand items */
            max-width: 1000px; /* Adjust width if needed */
            margin: 0 auto;
            flex-direction: row;
        }

        .brand-item {
            flex: 1 1 150px; /* Makes each brand item flexible with a base width */
            text-align: center;
            flex-direction: row;
        }

        .brand-item a {
            display: block;
            color: #fff;
            text-decoration: none;
            transition: transform 0.3s, background-color 0.3s;
            padding: 10px;
            border-radius: 5px;
            background-color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .brand-item a:hover {
            transform: scale(1.05);
            background-color: #555;
        }

        .brand-item img {
            width: 150px;  /* Fixed width */
            height: 100px; /* Maintain aspect ratio */
            margin-bottom: 10px;
            transition: filter 0.3s;
        }

        .brand-item img:hover {
            filter: grayscale(0%);
        }

        .brand-item p {
            font-size: 18px;
            margin-top: 5px;
        }
        #contact {
        height: 600px;
        padding: 50px 20px;
        background-color: #100f0f; /* Same background as services */
        color: white;
        text-align: center;
        margin-top: 50px;
        display: flex;
        flex-direction: column;
        align-items: center;
        }

        #contact .contact-info {
            display: flex;
            justify-content: space-around; /* Ensures horizontal layout */
            flex-wrap: nowrap; /* Keeps items in a row */
            margin-top: 30px;
            width: 100%; /* Ensure full width */
            max-width: 800px; /* Limits the width of the section */
        }

        .contact-item {
            flex: 1 1 auto; /* Flexible layout for each item */
            margin: 20px;
            text-align: center;
        }

        .contact-item i {
            font-size: 24px;
            color: #fff;
        }

        .contact-item p {
            margin-top: 10px;
            font-size: 18px;
        }


            
    </style>
</head>
<body>

    <div class="navbar">
        <img src="brandlogo1.png" alt="MotoDeal Logo">
        
        <h1>MotoDeal</h1>
        
        <div class="nav-links">
            <a class="active" href="#home">Home</a>
            <a href="#services">Services</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
             <!-- Dropdown for Brands -->
             <div class="dropdown">
                <a href="#brands" class="dropbtn">Brands</a>
                <div class="dropdown-content">
                    <a href="suzuki.php">Suzuki</a>
                    <a href="honda.php">Honda</a>
                    <a href="bmw.php">BMW</a>
                    <a href="kawasaki.php">Kawasaki</a>
                    <a href="ktm.php">KTM</a>
                    <a href="royalenfiled.php">Royal Enfield</a>
                </div>
            </div>
    
            <!-- Dropdown for Login/Register and Logout -->
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


    <div class="wellcome">
        <h4>Hello, <?php echo htmlspecialchars($username); ?>!</h4>
        <h1>Welcome To MotoDeal</h1>
        <h4>Explore the wide range of Bikes</h4>
    </div>

    <div class="cart">
        <a href="cart.php" class="cart-icon">
            <i class="fa fa-shopping-cart"></i> <!-- Font Awesome cart icon -->
        </a>
    </div>


    <section id="services" class="pb-5">
        <h1>Services</h1>
        <div class="service-row">
            <div class="box">
                <div class="icon">
                    <i class="fa fa-wrench" aria-hidden="true"></i>
                </div>
                <h4>Sales and Consultation</h4>
                <p>Expert advice on selecting the right bike based on the customer's needs, preferences, and budget.</p>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                </div>
                <h4>Maintenance</h4>
                <p>Regular servicing like oil changes, brake adjustments, and gear tuning to keep bikes in optimal condition.</p>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </div>
                <h4>Repairs</h4>
                <p>Addressing mechanical issues, such as fixing flat tires, repairing broken chains, and adjusting derailleurs.</p>
            </div>
            <div class="box">
                <div class="icon">
                    <i class="fa fa-balance-scale" aria-hidden="true"></i>
                </div>
                <h4>Parts and Accessories</h4>
                <p>Providing high-quality parts for repairs or upgrades, such as tires, tubes, brakes, and more.</p>
            </div>
        </div>
    </section>

    <section id="about">
        <h1>About Us</h1>
        <p>
            MotoDeal is dedicated to providing top-quality bikes and exceptional customer service. Our knowledgeable team is passionate about cycling and committed to helping you find the perfect bike for your needs. From sales and consultations to repairs and maintenance, we offer a comprehensive range of services to ensure your biking experience is smooth and enjoyable. Whether you’re a seasoned cyclist or a beginner, we’re here to support you every step of the way.
        </p>
    </section>

    <section id="brands">
        <h1>Our Brands</h1>
        <div class="brand-list">
            <div class="brand-item">
                <a href="suzuki.php"><img src="suzukilogo.jpg" alt="Brand 1">
                <p>SUZUKI</p></a>
            </div>
            <div class="brand-item">
                <a href="honda.php"><img src="hondalogo.png" alt="Brand 2">
                <p>HONDA</p></a>
            </div>
            <div class="brand-item">
                <a href="bmw.php"><img src="bmwlogo.png" alt="Brand 3">
                <p>BMW</p></a>
            </div>
            <div class="brand-item">
                <a href="kawasaki.php"><img src="kawasakilogo.jpg" alt="Brand 4">
                <p>KAWASAKI</p></a>
            </div>
            <div class="brand-item">
                <a href="ktm.php"><img src="ktmlogo.png" alt="Brand 5">
                <p>KTM</p></a>
            </div>
            <div class="brand-item">
                <a href="royalenfiled.php"><img src="royalenfiledlogo.png" alt="Brand 6">
                <p>ROYAL ENFIELD</p></a>
            </div>
        </div>
    </section>

    <section id="contact" style="background-color: #100f0f; color: #fff;">
        <h2>Contact Us</h2>
        <p>We'd love to hear from you! Reach out to us using the following methods:</p>
        <div class="contact-info">
            <div class="contact-item">
                <i class="fa fa-phone"></i>
                <p>+1 (555) 123-4567</p>
            </div>
            <div class="contact-item">
                <i class="fa fa-envelope"></i>
                <p>support@motodeal.com</p>
            </div>
            <div class="contact-item">
                <i class="fa fa-map-marker"></i>
                <p>123 Moto Street, Cityville</p>
            </div>
        </div>
    </section>
</body>
</html>
