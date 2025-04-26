<?php
// Start the PHP code and connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "passport_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the contact details from the database
$sql = "SELECT phone, service_support, ivrs_support FROM contact_details LIMIT 1";
$result = $conn->query($sql);

// If data is found, fetch it; otherwise, use fallback static details.
if ($result && $result->num_rows > 0) {
    $contact = $result->fetch_assoc();
} else {
    $contact = array(
        "phone" => "1800-258-1800",
        "service_support" => "Citizen Service Executive Support: 8 AM to 10 PM",
        "ivrs_support" => "Automated Interactive Voice Response (IVRS) Support: 24 hours"
    );
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Passport Seva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .header {
            background-color: #ffcc00;
            padding: 20px;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            color: #000;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .contact-section h3 {
            font-size: 1.6em;
            margin-bottom: 20px;
        }
        .contact-section p, .contact-section ul {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .contact-section ul {
            list-style-type: none;
            padding: 0;
        }
        .contact-section ul li {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">Contact Us</div>
    <div class="container">
        <div class="contact-section">
            <h3>For any query and suggestions on Passport Seva, please contact the Passport Seva Call Centre at:</h3>
            <ul>
                <li><strong>Phone:</strong> <?php echo htmlspecialchars($contact['phone']); ?></li>
                <li><strong>Call Centre Timings:</strong></li>
                <ul>
                    <li><?php echo htmlspecialchars($contact['service_support']); ?></li>
                    <li><?php echo htmlspecialchars($contact['ivrs_support']); ?></li>
                </ul>
            </ul>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025 Passport Automation System | All Rights Reserved</p>
    </div>
</body>
</html>
