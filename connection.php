<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bike showroom"; // Consider removing spaces from the database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful


