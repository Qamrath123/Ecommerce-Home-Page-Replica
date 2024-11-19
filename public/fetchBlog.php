<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database connection (Update with your actual database credentials)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ecommerce_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blogs from the database
$sql = "SELECT id, title, content, date_posted, image_url, status FROM latest_blog WHERE status = 'published' ORDER BY id DESC";
$result = $conn->query($sql);

$blogs = [];

if ($result->num_rows > 0) {
    // Store each blog post in the array
    while ($row = $result->fetch_assoc()) {
        // Format the date_posted to 'Apr 20, 2020'
        $date = new DateTime($row['date_posted']);
        $formatted_date = $date->format('M d, Y'); // Format as 'Apr 20, 2020'
        
        $blogs[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'content' => $row['content'],
            'date_posted' => $formatted_date, // Use the formatted date
            'image_url' => $row['image_url'],
            'status' => $row['status'],
        ];
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($blogs);

$conn->close();
?>
