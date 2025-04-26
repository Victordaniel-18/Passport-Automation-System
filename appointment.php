<?php
session_start();

// Database connection parameters
$servername = "localhost";
$db_username = "root";    // adjust as needed
$db_password = "";        // adjust as needed
$dbname = "passport_system";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve login credentials and CAPTCHA from the form
    $login_id      = $conn->real_escape_string($_POST['login_id']);
    $password_input = $_POST['password']; // Do not escape password, as it is used for verification
    $captcha_input  = $_POST['captcha'];

    // Validate the CAPTCHA (assuming you generated and stored it in $_SESSION['captcha'])
    if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] !== $captcha_input) {
        echo "<script>alert('Incorrect CAPTCHA. Please try again.'); window.location.href='appointment.html';</script>";
        exit;
    }

    // Look for the user record in the database based on login_id
    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE login_id = ? LIMIT 1");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $login_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the provided password with the hashed password from the database
        if (password_verify($password_input, $row['password_hash'])) {
            // Credentials are correct; redirect to welcome.html
            header("Location: welcome.html");
            exit;
        } else {
            echo "<script>alert('Invalid login credentials.'); window.location.href='appointment.html';</script>";
            exit;
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='appointment.html';</script>";
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
