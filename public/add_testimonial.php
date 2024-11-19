<?php
// Database credentials
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ecommerce_db';

// Establish the database connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Initialize variables for form feedback
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $testimonial_message = mysqli_real_escape_string($conn, $_POST['message']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);

    // Validate inputs
    if (empty($name) || empty($designation) || empty($testimonial_message)) {
        $error = 'All fields except "Image URL" are required.';
    } else {
        // Insert testimonial into the database
        $query = "INSERT INTO testimonials (name, designation, message, image_url) VALUES ('$name', '$designation', '$testimonial_message', '$image_url')";
        
        if (mysqli_query($conn, $query)) {
            $message = 'Testimonial added successfully!';
        } else {
            $error = 'Error adding testimonial: ' . mysqli_error($conn);
        }
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Testimonial</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        h1 {
            color: #333;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        form input, form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Add a Testimonial</h1>

    <?php if ($message): ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="designation">Designation:</label>
        <input type="text" id="designation" name="designation" required>
        
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
        
        <label for="image_url">Image URL (optional):</label>
        <input type="text" id="image_url" name="image_url">
        
        <button type="submit">Submit Testimonial</button>
    </form>
</body>
</html>
