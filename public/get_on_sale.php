<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');  // Set the correct content type for JSON
header("Access-Control-Allow-Origin: *");  // Allows all origins, or replace * with your specific frontend URL
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ecommerce_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all "On Sale" products
$sql = "
    SELECT 
        id, 
        name, 
        price, 
        sale_price, 
        image_url, 
        is_sold_out 
    FROM 
        on_sale 
    ORDER BY 
        created_at DESC
";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
   
    // Return the products as JSON
    echo json_encode($products);
} else {
    echo json_encode([]);
}

$conn->close();
?>
