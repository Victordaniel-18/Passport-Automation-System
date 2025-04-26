<?php
session_start();

// Database connection parameters
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "passport_seva";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form fields
    $reference = $_POST['reference-number'];
    $psk = $_POST['passport-seva-kendra'];
    $applicant_name = $_POST['applicant-name'];
    $dob = $_POST['dob'];
    $current_address = $_POST['current-address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $sub_category = $_POST['sub-category'];
    $request_mode = $_POST['request-mode'];
    $description = $_POST['description'];
    $service_request_date = $_POST['service-request-date'];
    $captcha_input = $_POST['captcha'];

    // CAPTCHA validation
    // (This assumes you have stored the correct captcha value in $_SESSION['captcha']
    // via a server-side script or by passing it from the client)
    if (!isset($_SESSION['captcha']) || $_SESSION['captcha'] !== $captcha_input) {
        echo "<script>alert('Invalid CAPTCHA. Please try again.'); window.location.href='grievance_feedback.html';</script>";
        exit;
    }

    // Prepare SQL statement to insert the feedback record
    $stmt = $conn->prepare("INSERT INTO feedback (reference_type, passport_seva_kendra, applicant_name, dob, current_address, contact, email, category, sub_category, request_mode, description, service_request_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssssssssssss", $reference, $psk, $applicant_name, $dob, $current_address, $contact, $email, $category, $sub_category, $request_mode, $description, $service_request_date);

    // Execute the statement and provide feedback
    if ($stmt->execute()) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href='grievance_feedback.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='grievance_feedback.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
