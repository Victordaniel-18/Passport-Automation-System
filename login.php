<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$db_username = "root";  
$db_password = "";      
$dbname = "passport"; 

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debug: Check if POST data is received
    error_log("Received POST Data: " . print_r($_POST, true));
    
    // Ensure the username and password are set
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    error_log("POST Data: " . print_r($_POST, true)); // Debugging line


    // Debug: Check if values are empty
    if (empty($username) || empty($password)) {
        error_log("Username or Password is empty");
        echo "<script>alert('Username and Password are required.'); window.history.back();</script>";
        exit;
    }

    // Fetch user data
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        die("Something went wrong. Try again later.");
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Debug: Check stored password hash
        error_log("Stored Hash: " . $row['password']);

        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true); // Prevent session fixation

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['username'];

            header("Location: welcome.html");
            exit;
        } else {
            error_log("Password mismatch for user: " . $username);
            echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
        }
    } else {
        error_log("Invalid username: " . $username);
        echo "<script>alert('Invalid Username. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
