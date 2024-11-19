<?php
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

// Get the status from the query string (if any)
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Modify the query to limit the number of products (8 by default)
$query = "SELECT * FROM products";
if ($status) {
    $query .= " WHERE status = '$status'";  // Filter based on the status (featured, latest, bestseller)
}
$query .= " LIMIT 8";  // Limit to 8 products

$result = $conn->query($query);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => $row['price'],
            'image' => $row['image']
        ];
    }
} else {
    $products = [];  // No products found
}

echo json_encode($products);  // Return the products as JSON
?>
