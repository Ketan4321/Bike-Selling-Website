<?php
session_start();
require_once 'connection.php';

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page after logout
header('Location: home.html');
exit;

