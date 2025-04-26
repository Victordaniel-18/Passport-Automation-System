<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";  // Default for XAMPP
$password = "";      // Default for XAMPP
$dbname = "passport"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the table has the required columns
$tableCheck = $conn->query("SHOW COLUMNS FROM new_register LIKE 'login_id'");
if ($tableCheck->num_rows == 0) {
    die("Error: 'login_id' column is missing in the 'new_register' table.");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data with validation
    $passport_office = isset($_POST['state']) ? trim($_POST['state']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    
    // Check if user selected login_id same as email
    $login_id = isset($_POST['same_as_email']) && $_POST['same_as_email'] === 'yes' ? $email : trim($_POST['login_id']);
    
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $hint_question = isset($_POST['hint_question']) ? $_POST['hint_question'] : '';
    $hint_answer = isset($_POST['hint_answer']) ? trim($_POST['hint_answer']) : '';

    // Ensure all required fields are filled
    if (empty($passport_office) || empty($name) || empty($surname) || empty($dob) || empty($email) || empty($login_id) || empty($password) || empty($hint_question) || empty($hint_answer)) {
        die("<script>alert('All fields are required.'); window.history.back();</script>");
    }

    // Check if email or login_id already exists in new_register table
    $checkUser = $conn->prepare("SELECT id FROM new_register WHERE email = ? OR login_id = ?");
    $checkUser->bind_param("ss", $email, $login_id);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email or Login ID already exists!'); window.history.back();</script>";
    } else {
        // Insert user data into new_register table
        $sql = "INSERT INTO new_register (passport_office, name, surname, dob, email, login_id, password, hint_question, hint_answer)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $passport_office, $name, $surname, $dob, $email, $login_id, $password, $hint_question, $hint_answer);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to welcome page.'); window.location.href = 'welcome.html';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    }

    $checkUser->close();
}

$conn->close();
?>
