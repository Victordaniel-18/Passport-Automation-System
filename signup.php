<?php
// signup.php

// Database connection parameters for XAMPP
$host = "localhost";
$dbUsername = "root";         // Default XAMPP username
$dbPassword = "";             // Default XAMPP password is usually empty
$dbName = "passport";         // ✅ Change this to your actual database name

// Create connection using mysqli
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form data when POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validate that passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='signup.html';</script>";
        exit;
    }
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare an INSERT statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Database error: " . $conn->error . "'); window.location.href='signup.html';</script>";
        exit;
    }
    
    // Bind the parameters to the query
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Sign up successful! Redirecting to login page.'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='signup.html';</script>";
    }
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
