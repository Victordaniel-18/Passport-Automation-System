<?php
// Database connection parameters
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "passport_seva";

// Initialize result variables for both forms
$applicationStatusResult = "";
$rtiStatusResult = "";

// Create connection to the database
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submissions if method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the Application Status form was submitted (by checking if "application-id" exists)
    if (isset($_POST['application-id']) && !empty($_POST['application-id'])) {
        $app_id = $_POST['application-id'];
        // Prepare a statement to fetch application status
        $stmt = $conn->prepare("SELECT status, updated_on FROM application_statuses WHERE application_id = ?");
        $stmt->bind_param("s", $app_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $applicationStatusResult = "Status: " . $row['status'] . " (Last updated: " . $row['updated_on'] . ")";
        } else {
            $applicationStatusResult = "No details found for Application ID: " . htmlspecialchars($app_id);
        }
        $stmt->close();
    }
    // Check if the RTI Status form was submitted (by checking if "rti-id" exists)
    if (isset($_POST['rti-id']) && !empty($_POST['rti-id'])) {
        $rti_id = $_POST['rti-id'];
        // Prepare a statement to fetch RTI status
        $stmt = $conn->prepare("SELECT status, updated_on FROM rti_statuses WHERE rti_id = ?");
        $stmt->bind_param("s", $rti_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $rtiStatusResult = "Status: " . $row['status'] . " (Last updated: " . $row['updated_on'] . ")";
        } else {
            $rtiStatusResult = "No details found for RTI ID: " . htmlspecialchars($rti_id);
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .grid-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 1.2em;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .grid-item:hover {
            background-color: #ffcc00;
            color: #fff;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }
        /* Responsive Grid */
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 480px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">Status Tracker</div>
    <div class="container">
        <div class="grid-container">
            <!-- Application Status Section -->
            <div class="grid-item">
                <a href="#application-status" style="text-decoration: none; color: inherit;">
                    <!-- Use a relative URL or public path for images -->
                    <img src="status_logo.jpeg" alt="Application Status" width="50" height="50">
                    <h3>Application Status</h3>
                </a>
            </div>
            <!-- RTI Status Section -->
            <div class="grid-item">
                <a href="#rti-status" style="text-decoration: none; color: inherit;">
                    <img src="status_logo.jpeg" alt="RTI Status" width="50" height="50">
                    <h3>RTI Status</h3>
                </a>
            </div>
        </div>

        <!-- Application Status Details -->
        <div id="application-status" style="display: none; margin-top: 40px;">
            <h2>Application Status Details</h2>
            <form method="post" action="">
                <label for="application-id">Enter Application ID:</label>
                <input type="text" id="application-id" name="application-id" required>
                <button type="submit">Check Status</button>
            </form>
            <?php if(!empty($applicationStatusResult)) { ?>
                <p><?php echo $applicationStatusResult; ?></p>
            <?php } else { ?>
                <p>Details about your application status will appear here after you submit the form.</p>
            <?php } ?>
        </div>

        <!-- RTI Status Details -->
        <div id="rti-status" style="display: none; margin-top: 40px;">
            <h2>RTI Status Details</h2>
            <form method="post" action="">
                <label for="rti-id">Enter RTI ID:</label>
                <input type="text" id="rti-id" name="rti-id" required>
                <button type="submit">Check Status</button>
            </form>
            <?php if(!empty($rtiStatusResult)) { ?>
                <p><?php echo $rtiStatusResult; ?></p>
            <?php } else { ?>
                <p>Details about your RTI status will appear here after you submit the form.</p>
            <?php } ?>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025 Passport Automation System | All Rights Reserved</p>
    </div>
    <script>
        // JavaScript to toggle the display of status details when a link is clicked
        const applicationLink = document.querySelector("a[href='#application-status']");
        const rtiLink = document.querySelector("a[href='#rti-status']");
        const applicationStatusDiv = document.getElementById('application-status');
        const rtiStatusDiv = document.getElementById('rti-status');

        applicationLink.addEventListener('click', function(e) {
            e.preventDefault();
            applicationStatusDiv.style.display = 'block';
            rtiStatusDiv.style.display = 'none';
        });

        rtiLink.addEventListener('click', function(e) {
            e.preventDefault();
            rtiStatusDiv.style.display = 'block';
            applicationStatusDiv.style.display = 'none';
        });
    </script>
</body>
</html>
