<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'ecommerce_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message
$message = "";

// Check if form data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];
    $image_url = $_POST['image_url'];
    $is_sold_out = isset($_POST['is_sold_out']) ? 1 : 0;

    // Insert into on_sale table
    $sql = "
        INSERT INTO on_sale (name, price, sale_price, image_url, is_sold_out) 
        VALUES ('$name', '$price', '$sale_price', '$image_url', '$is_sold_out')
    ";

    if ($conn->query($sql) === TRUE) {
        $message = "Product added to 'On Sale' successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add On Sale Product</title>
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
        input[type="text"], input[type="number"] {
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
    <h2 style="text-align: center;">Add Product to On Sale</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="price">Original Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br>

        <label for="sale_price">Sale Price:</label><br>
        <input type="number" id="sale_price" name="sale_price" step="0.01" required><br>

        <label for="image_url">Image URL:</label><br>
        <input type="text" id="image_url" name="image_url" required><br>

        <label for="is_sold_out">Mark as Sold Out:</label>
        <input type="checkbox" id="is_sold_out" name="is_sold_out"><br><br>

        <button type="submit">Add to On Sale</button>
    </form>
</body>
</html>
