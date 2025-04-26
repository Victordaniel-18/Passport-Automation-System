<?php
session_start();

// Database connection parameters
$host = "localhost";
$dbUsername = "root";         // Default XAMPP username
$dbPassword = "";             // Default XAMPP password is usually empty
$dbName = "passport";         // Connecting to the "passport" database

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the login form submission only if POST data is present
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form inputs
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    // Prepare a SELECT statement to fetch user details
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // If no user is found, set error and redirect back to login form
    if ($result->num_rows == 0) {
        $_SESSION['error'] = "User not found.";
        echo "user not found";
        exit;
    }

    // Fetch the user data
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verify the submitted password against the stored hash
    if (password_verify($password, $hashed_password)) {
        // Successful login: set session and redirect to welcome page
        $_SESSION['username'] = $username;
        header("Location: welcome.html");
        exit;
    } else {
        // Password incorrect: set error and redirect back to login form
        $_SESSION['error'] = "Invalid password.";
        header("Location: loginweb.html");
        exit;
    }

    $stmt->close();
} else {
    // Not a POST request: redirect to the login form page
    header("Location: loginweb.html");
    exit;
}

$conn->close();
?>
