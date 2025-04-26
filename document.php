<?php
// Connect to the database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "passport_seva";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve document advisor items from the database
$sql = "SELECT title, url FROM document_advisor_items ORDER BY id ASC";
$result = $conn->query($sql);

$advisorItems = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $advisorItems[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Advisor - Passport Seva</title>
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .options-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .option-item {
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
        .option-item:hover {
            background-color: #ffcc00;
            color: #fff;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="header">Document Advisor</div>
    <div class="container">
        <div class="options-container">
            <?php if (!empty($advisorItems)) : ?>
                <?php foreach ($advisorItems as $item) : ?>
                    <div class="option-item">
                        <a href="<?php echo htmlspecialchars($item['url']); ?>" style="text-decoration: none; color: inherit;">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No document advisor options available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2025 Passport Automation System | All Rights Reserved</p>
    </div>
</body>
</html>
