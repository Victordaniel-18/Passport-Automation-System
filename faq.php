<?php
// Connect to the database
$servername   = "localhost";
$dbUsername   = "root";
$dbPassword   = "";
$dbName       = "passport_seva";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the FAQ topics from the database
$sql    = "SELECT title, anchor FROM faq_topics ORDER BY id ASC";
$result = $conn->query($sql);

$faqItems = array();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqItems[] = $row;
    }
} else {
    // Fallback static FAQ topics if no data is found in the database
    $faqItems = array(
        array("title" => "Services Available", "anchor" => "#services"),
        array("title" => "Special Cases of Minors Requiring Passports", "anchor" => "#minors"),
        array("title" => "Where to apply?", "anchor" => "#apply"),
        array("title" => "Application Form", "anchor" => "#form"),
        array("title" => "Fee Payment", "anchor" => "#payment"),
        array("title" => "Password Manage
