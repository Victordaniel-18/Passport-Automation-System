<?php
// Initialize variables
$finalFee = "";
$errorMessage = "";
$serviceType = "";
$feeAmount = "";
$age = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $serviceType = isset($_POST['service_type']) ? $_POST['service_type'] : "select";
    $feeAmount = isset($_POST['fee_amount']) ? floatval($_POST['fee_amount']) : 0;
    
    if ($serviceType === "fresh") {
        // For Fresh Passport, age is needed for rebate calculation
        if (isset($_POST['age']) && $_POST['age'] !== "") {
            $age = intval($_POST['age']);
            // Apply a 10% rebate for minors (age <= 8) or senior citizens (age > 60)
            if ($age <= 8 || $age > 60) {
                $finalFee = $feeAmount * 0.9;
            } else {
                $finalFee = $feeAmount;
            }
        } else {
            $errorMessage = "Please enter the applicant's age for Fresh Passport service.";
        }
    } else {
        // For other services, no rebate applies
        $finalFee = $feeAmount;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Calculator - Passport Seva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
  
