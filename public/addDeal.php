<?php
// Display PHP errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection (update credentials as needed)
$host = "localhost";
$username = "root";
$password = "";
$database = "ecommerce_db";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Variable to hold messages
$message = "";

// Handle POST request when the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if all required fields are provided
    $required_fields = ['product_name', 'description', 'original_price', 'discounted_price', 'image_url', 'start_time', 'end_time'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $message = "All fields are required.";
            break;
        }
    }

    if (!$message) {
        // Retrieve and sanitize input
        $product_name = $conn->real_escape_string($_POST['product_name']);
        $description = $conn->real_escape_string($_POST['description']);
        $original_price = floatval($_POST['original_price']);
        $discounted_price = floatval($_POST['discounted_price']);
        $image_url = $conn->real_escape_string($_POST['image_url']);
        $start_time = $conn->real_escape_string($_POST['start_time']);
        $end_time = $conn->real_escape_string($_POST['end_time']);

        // Insert the deal into the database
        $sql = "INSERT INTO deal_of_the_day(product_name, description, original_price, discounted_price, image_url, start_time, end_time)
                VALUES ('$product_name', '$description', $original_price, $discounted_price, '$image_url', '$start_time', '$end_time')";

        if ($conn->query($sql) === TRUE) {
            $message = "Deal added successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Deal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input, textarea, button {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Deal of the Day</h1>
        <!-- Display Message -->
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter product description" required></textarea>

            <label for="original_price">Original Price:</label>
            <input type="number" id="original_price" name="original_price" placeholder="Enter original price" step="0.01" required>

            <label for="discounted_price">Discounted Price:</label>
            <input type="number" id="discounted_price" name="discounted_price" placeholder="Enter discounted price" step="0.01" required>

            <label for="image_url">Image URL:</label>
            <input type="text" id="image_url" name="image_url" placeholder="Enter image URL" required>

            <label for="start_time">Start Time:</label>
            <input type="datetime-local" id="start_time" name="start_time" required>

            <label for="end_time">End Time:</label>
            <input type="datetime-local" id="end_time" name="end_time" required>

            <button type="submit">Add Deal</button>
        </form>
    </div>
</body>
</html>
