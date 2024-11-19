<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');  // Set the correct content type for JSON
header("Access-Control-Allow-Origin: *");  // Allows all origins, or replace * with your specific frontend URL
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Get current time for comparison
$current_time = date('Y-m-d H:i:s');
// Pagination settings
$limit = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// SQL Query to fetch all deals, including both expired and active ones
$sql = "
    SELECT 
        deal_of_the_day.id AS deal_id,
        deal_of_the_day.product_name, 
        deal_of_the_day.description, 
        deal_of_the_day.original_price, 
        deal_of_the_day.discounted_price, 
        deal_of_the_day.image_url, 
        deal_of_the_day.start_time, 
        deal_of_the_day.end_time,
        products.size,
        products.color,
        products.availability,
        products.quantity
    FROM deal_of_the_day
    LEFT JOIN products ON deal_of_the_day.id = products.id
    ORDER BY deal_of_the_day.start_time ASC
     LIMIT $limit OFFSET $offset;
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Query failed: " . mysqli_error($conn)]);
    exit;
}

// Fetch results
$deals = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Check if the deal is expired by comparing end_time with the current time
    $row['expired'] = (strtotime($row['end_time']) < strtotime($current_time)) ? true : false;
    
    // Add each row to the deals array
    $deals[] = $row;
}

// Return the array of deals as JSON
echo json_encode($deals);

// Close the database connection
mysqli_close($conn);
?>
