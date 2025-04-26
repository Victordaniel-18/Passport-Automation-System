<?php
// Initialize variables for the selected location and centre details.
$selectedLocation = "select"; // default
$centreInfo = "";

// Process form submission if the request method is POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determine which action was requested
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === "locate") {
            // Retrieve the selected centre location.
            $selectedLocation = isset($_POST["centre-location"]) ? $_POST["centre-location"] : "select";
            
            // Determine the centre details based on the selected location.
            switch ($selectedLocation) {
                case "passport-seva-kendra":
                    $centreInfo = "Passport/Post Office Seva Kendra details: You can visit the nearest Seva Kendra to apply for your passport.";
                    break;
                case "district-passport-cell":
                    $centreInfo = "District Passport Cell details: District offices that assist with passport application processing.";
                    break;
                case "police-station":
                    $centreInfo = "Police Station details: For police verification, visit your local police station.";
                    break;
                case "mission-post-abroad":
                    $centreInfo = "Mission/Post Abroad details: Embassies and consulates located abroad for passport services.";
                    break;
                case "passport-office":
                    $centreInfo = "Passport Office details: Main offices where passport applications and queries are processed.";
                    break;
                default:
                    $centreInfo = "Please select a location.";
            }
        } elseif ($action === "cancel") {
            // Reset the selection if the Cancel button was clicked.
            $selectedLocation = "select";
            $centreInfo = "";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locate Centre - Passport Seva</title>
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
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 1.2em;
            display: block;
            margin-bottom: 10px;
        }
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #ffcc00;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            color: #000;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #ff9900;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">Locate Centre</div>
    <div class="container">
        <h2>Select the Centre for Passport Services</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="centre-location">Choose a Location:</label>
                <select id="centre-location" name="centre-location">
                    <option value="select" <?php if ($selectedLocation=="select") echo "selected"; ?>>select</option>
                    <option value="passport-seva-kendra" <?php if ($selectedLocation=="passport-seva-kendra") echo "selected"; ?>>Passport/Post Office Seva Kendra</option>
                    <option value="district-passport-cell" <?php if ($selectedLocation=="district-passport-cell") echo "selected"; ?>>District Passport Cell</option>
                    <option value="police-station" <?php if ($selectedLocation=="police-station") echo "selected"; ?>>Police Station</option>
                    <option value="mission-post-abroad" <?php if ($selectedLocation=="mission-post-abroad") echo "selected"; ?>>Mission/Post Abroad</option>
                    <option value="passport-office" <?php if ($selectedLocation=="passport-office") echo "selected"; ?>>Passport Office</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="action" value="locate">Locate Centre</button>
            </div>
            <?php if (!empty($centreInfo)) : ?>
                <div class="form-group" id="centre-details">
                    <h3>Centre Details:</h3>
                    <p id="centre-info"><?php echo $centreInfo; ?></p>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <button type="submit" name="action" value="cancel">Cancel</button>
            </div>
        </form>
    </div>
    <div class="footer">
        <p>&copy; 2025 Passport Automation System | All Rights Reserved</p>
    </div>
</body>
</html>
