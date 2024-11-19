<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');  // Set the correct content type for JSON
header("Access-Control-Allow-Origin: *");  // Allows all origins, or replace * with your specific frontend URL
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

// Include the database connection
require_once('../dbCon.php');
$database = new Database();
$conn = $database->getConnection();




// Fetch testimonials
$sql = "SELECT name, designation, message, image_url FROM testimonials ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$testimonials = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $testimonials[] = $row;
    }
}

// Output as JSON
echo json_encode($testimonials);

// Close connection
mysqli_close($conn);
?>
