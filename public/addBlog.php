<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection (Update with your actual database credentials)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ecommerce_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
$message = "";

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url'];
    $status = $_POST['status'];
  

    // Check if required fields are not empty
    if (!empty($title) && !empty($content) && !empty($status)) {
        // Insert data into the 'blogs' table
        $sql = "INSERT INTO latest_blog (title, content, image_url, status) 
                VALUES ('$title', '$content', '$image_url', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Blog post added successfully!";
        } else {
            $message = "Error adding blog post: " . $conn->error;
        }
    } else {
        $message = "All fields (Title, Content, and Status) are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #00a36c;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #007a54;
        }
        .message {
            text-align: center;
            color: green;
            margin-top: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Add Blog Post</h2>

    <!-- Display success or error message -->
    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- Blog post submission form -->
    <form action="" method="POST">
        <label for="title">Blog Title:</label><br>
        <input type="text" id="title" name="title" placeholder="Blog Title" required><br>

        <label for="content">Blog Content:</label><br>
        <textarea id="content" name="content" placeholder="Write your blog content here" required></textarea><br>

        <label for="image_url">Image URL:</label><br>
        <input type="text" id="image_url" name="image_url" placeholder="Image URL"><br>

        <label for="status">Status:</label><br>
        <select name="status" id="status" required>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select><br>

        <button type="submit">Add Blog</button>
    </form>
</body>
</html>
